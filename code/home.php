<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php /*publish post */
    $error="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (isset($_POST['publish']))
        {
            $tit = sanitizeString($_POST['title']);
            $met = sanitizeString($_POST['metadescription']);
            $not = sanitizeString($_POST['notes']);
            $sou = sanitizeString($_POST['source']);
            $rcop= queryMysql("SELECT * FROM `post` WHERE `notes`='$not'");
            if($rcop->num_rows==0)
            {
                queryMysql("INSERT INTO `post` VALUES (NULL,'$user','$tit','$met','$not','$sou',NOW())");
                $insertID = $connection->insert_id;
                $ins = queryMysql("SELECT * FROM `sponsor` WHERE `sponsored`='$user'");
                if($ins->num_rows)
                {
                    queryMysql("UPDATE `sponsor` SET `post no`='$insertID',`post status`=0,`research no`=0,`research status`=1,`issue no`=0,`issue status`=1,`posting time`=NOW() WHERE `sponsored`='$user'");
                }
                die(header('location:home.php'));
            }
            else{
                $co=$rcop->fetch_array(MYSQLI_ASSOC);
                $nno=$co['post no'];
                $nusr=$co['username'];
                $ntit=$co['title'];
                $error="Copy Paste is not allowed.<br>";
                $error.="Title : <a href='postcmnt.php?content=".$nno."' style='text-decoration:none;'>".$ntit."</a><br>From : <a href='member.php?content=".$nusr."' style='text-decoration:none;'>".$nusr."</a>";
            }
        }
    }
?>
<?php /*notification*/
    $count = 0;
    $count += Notification("requirement",$user,"comment","issue username");
    $count += Notification("research paper",$user,"rcomment","research username");
    $count += Notification("post",$user,"pcomment","post username");
    $ps = queryMysql("SELECT * FROM `sponsor` WHERE `post status`= 0 AND `username`= '$user'");
    $count += $ps->num_rows;
    $rs = queryMysql("SELECT * FROM `sponsor` WHERE `research status`= 0 AND `username`= '$user'");
    $count += $rs->num_rows;
    $iss = queryMysql("SELECT * FROM `sponsor` WHERE `issue status`= 0 AND `username`= '$user'");
    $count += $iss->num_rows;
?>
<?php /*detailed info*/
    $result= queryMysql("SELECT `username` FROM education WHERE `username`='$user'");
    if($result->num_rows == 0)
    {
        queryMysql("INSERT INTO `education`(`username`) VALUES ('$user')");
    }
    $result= queryMysql("SELECT `username` FROM work WHERE `username`='$user'");
    if($result->num_rows == 0)
    {
        queryMysql("INSERT INTO `work`(`username`) VALUES ('$user')");
    }
    $result1= queryMysql("SELECT * FROM `education` WHERE `username`='$user'");
    if($result1->num_rows)
    {
        $row= $result1->fetch_array(MYSQLI_ASSOC);
    }
    $result2= queryMysql("SELECT * FROM `work` WHERE `username`='$user'");
    if($result2->num_rows)
    {
        $row1= $result2->fetch_array(MYSQLI_ASSOC);
    }
?>
<?php 
    $ip = getIPAddress();
?>
<div data-role="page" id="home" data-url="home">
        <header><div data-role="header" data-fullscreen="true" class="info" id="header" data-position="fixed">
            <h1 id="hh1"><?php echo $userstr.' - '.$ip;?></h1>
            <a href="javascript:void(0)" onClick="openNav()" aria-label="menu" class="icon pos01" data-icon="bars" data-iconpos="notext">&#9776;</a>
            <a href="javascript:void(0)" aria-label="notification" id="notification-icon" name="button" onclick="Notification()" class="icon pos3">&#9200;</a>
			<span id="notification-count"><?php if($count>0) { echo $count; } ?></span>
            </div>
        </header>
        <main>      
            <div data-role="main" id="main01" class="ui-content">
                <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);"></div>               
                <div id="notifi" class="notifi1"><div id="notification-latest"></div></div>               
                <div class="overlay" data-theme="a" id="myNav">
                    <div class="overlay2">
                        <a href="javascript:void(0)" onClick="closeNav()" class="closebtn">&times;</a>
                        <div id="photo301">
                            <?php 
                                if (file_exists("uploads/$user.jpg"))
                                echo "<img id='photo301' src='uploads/$user.jpg'>";
                                else echo "<span id='pho302'>Please upload pic</span>";
                            ?>
                        </div>
                        <div><h1><?php echo $user;?></h1></div>
                        <fieldset id=education>
                            <legend><strong>Education</strong></legend>
                            <?php
                                if($row['phd']!="")
                                {echo "Phd:&nbsp;&nbsp;". ucfirst($row['phd'])."<br>";}
                                if($row['master']!="")
                                {echo "Master:&nbsp;&nbsp;". ucfirst($row['master'])."<br>";}
                                if($row['graduation']!="")
                                {echo "Graduation:&nbsp;&nbsp;". ucfirst($row['graduation'])."<br>";}
                                if($row['hsc']!="")
                                {echo "HSC:&nbsp;&nbsp;". ucfirst($row['hsc'])."<br>";}
                                if($row['ssc']!="")
                                {echo "SSC:&nbsp;&nbsp;". ucfirst($row['ssc'])."<br>";}
                                if($row['achievementE']!="")
                                {
                                    $ach=explode(",",$row['achievementE']);
                                    if($ach)
                                    {foreach($ach as $key=>$value)
                                    echo "Achievement:&nbsp;&nbsp;". ucfirst($value)."<br>";}
                                    else{
                                        echo "Achievement:&nbsp;&nbsp;". ucfirst($row['achievementE'])."<br>";
                                    }
                                }
                            ?>
                        </fieldset>
                        <fieldset id=work>
                            <legend><strong>Work</strong></legend>
                            <?php
                                if($row1['curcomp']!="")
                                {echo "Current Company:&nbsp;&nbsp;". ucfirst($row1['curcomp'])."<br>";}
                                if($row1['crole']!="")
                                {echo "Current Role:&nbsp;&nbsp;". ucfirst($row1['crole'])."<br>";}
                                if($row1['cexp']!= 0)
                                {echo "Current Experience:&nbsp;&nbsp;". $row1['cexp']."<br>";}
                                if($row1['precomp']!="")
                                {echo "Previous Company:&nbsp;&nbsp;". ucfirst($row1['precomp'])."<br>";}
                                if($row1['prole']!="")
                                {echo "Previous Role:&nbsp;&nbsp;". ucfirst($row1['prole'])."<br>";}
                                if($row1['pexp']!= 0)
                                {echo "Previous Experience:&nbsp;&nbsp;". $row1['pexp']."<br>";}
                                if($row1['achievement']!="")
                                {
                                    $ach=explode(",",$row1['achievement']);
                                    if($ach)
                                    {foreach($ach as $key=>$value)
                                    echo "Achievement:&nbsp;&nbsp;". ucfirst($value)."<br>";}
                                    else{
                                        echo "Achievement:&nbsp;&nbsp;". ucfirst($row1['achievement'])."<br>";
                                    }
                                }
                            ?>
                        </fieldset>
                        <fieldset id="loc100">
                            <legend><strong>From</strong></legend>
                            <?php 
                                $re= queryMysql("SELECT * FROM profiles WHERE `username`= '$user'");
                                if($re->num_rows)
                                {
                                    $ro= $re->fetch_array(MYSQLI_ASSOC);
                                    if($ro['city']!= "")
                                    {echo "City:&nbsp;&nbsp;".ucfirst($ro['city'])."<br>";}
                                    if($ro['state']!= "")
                                    {echo "State:&nbsp;&nbsp;".ucfirst($ro['state'])."<br>";}
                                    if($ro['country']!= "")
                                    {echo "Country:&nbsp;&nbsp;".ucfirst($ro['country'])."<br>";}
                                }
                            ?>
                        </fieldset>
                        <fieldset id="loc101">
                            <legend><strong>Living In</strong></legend>
                            <?php 
                                $re= queryMysql("SELECT * FROM `clocation` WHERE `username`= '$user'");
                                if($re->num_rows)
                                {
                                    $ro= $re->fetch_array(MYSQLI_ASSOC);
                                }
                                    if($ro['address']!= "")
                                    {echo "Address:&nbsp;&nbsp;". ucfirst($ro['address'])."<br>";}
                                    if($ro['city']!= "")
                                    {echo "City:&nbsp;&nbsp;". ucfirst($ro['city'])."<br>";}
                                    if($ro['zip']!= 0)
                                    {echo "Zip:&nbsp;&nbsp;". $ro['zip']."<br>";}
                                    if($ro['state']!= "")
                                    {echo "State:&nbsp;&nbsp;". ucfirst($ro['state'])."<br>";}
                                    if($ro['country']!= "")
                                    {echo "Country:&nbsp;&nbsp;". ucfirst($ro['country'])."<br>";}                                
                            ?>
                        </fieldset>
                        <a href="editprofile.php" aria-label="edit profile" data-icon="edit">Edit Profile</a>
                        <a href="home.php" aria-label="home" data-icon="home">Home</a>
                        <a href="search.php" aria-label="search" data-icon="search">search Notes</a>
                        <a href="postrequire.php" aria-label="post requirement" data-icon="edit">Post Requirement</a>
                        <a href="yourrequire.php" aria-label="your requirement" data-icon="comment">Your Requirement</a>
                        <a href="indemand.php" aria-label="In Demand" data-icon="search">In Demand</a>
                        <a href="rd.php" aria-label="R&D" data-icon="search">R & D</a>
                        <a href="postrd.php" aria-label="post research" data-icon="edit">Post Research</a>
                        <a href="yourrd.php" aria-label="your research paper" data-icon="comment">Your Research Paper</a>
                        <a href="likednotes.php" aria-label="liked notes" data-icon="heart">Liked Notes</a>
                        <a href="purchased.php" aria-label="purchased courses" data-icon="heart">Purchased Courses</a>
                        <a href="insider.php"  aria-label="insider"data-icon="info">Insider</a>
                        <a href="setting.php" aria-label="setting" data-icon="gear">Setting</a>
                        <a href="createad.php" aria-label="create ad" data-icon="check">Create Ad</a>
                        <a href="logout.php" aria-label="logout" data-icon="refresh">Logout</a>
                    </div>
                </div>
                <?php 
                    echo '<div class="error cop9000">'.$error.'</div>';
                    include("hmain.php");//include @
                ?>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>