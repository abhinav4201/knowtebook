<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['publish']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cmnt = sanitizeString($_POST['comment']);
            $result= queryMysql("SELECT * FROM `requirement` WHERE `issue no`='$cnt'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $usr=$row['username'];
            }
            queryMysql("INSERT INTO `comment` (`comment id`, `issue username`, `issue no`, `username`, `comment`, `posting time`) VALUES (NUll,'$usr','$cnt','$user','$cmnt',NOW())");
            if($usr!=$user)
            {
                $pc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$user'");
                $pcc=$pc->fetch_array(MYSQLI_ASSOC);
                $pcs=$pcc['icomment']+1;
                queryMysql("UPDATE `profile count` SET `icomment`='$pcs' WHERE `username`='$user'");
                
            }
            die(header('location:yourrequirecmnt.php?content='.$cnt));
        }
        if(isset($_POST['delete']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cmntid= sanitizeString($_REQUEST['comment']);
            $result= queryMysql("SELECT * FROM `comment` WHERE `comment id`='$cmntid'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $usrc=$row['username'];
                $cmc= $row['comment'];
            }
            queryMysql("INSERT INTO `delicomment`(`username`, `comment`, `issue no`, `deleted on`) VALUES ('$usrc','$cmc','$cnt',NOW())");
            queryMysql("DELETE FROM `comment` WHERE `comment id`='$cmntid'");
            $pc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usrc'");
            $pcc=$pc->fetch_array(MYSQLI_ASSOC);
            $pcs=$pcc['icomment']-1;
            queryMysql("UPDATE `profile count` SET `icomment`='$pcs' WHERE `username`='$usrc'");
            die(header('location:yourrequirecmnt.php?content='.$cnt));
        }
        if(isset($_POST['report']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cmntid= sanitizeString($_REQUEST['comment']);
            $result= queryMysql("SELECT * FROM `comment` WHERE `comment id`='$cmntid'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $usrc=$row['username'];
                $cmc= $row['comment'];
            }
            $r= queryMysql("SELECT * FROM `repicomment` WHERE `comment id`='$cmntid' AND `comment username`='$usrc'");
            if($r->num_rows==0)
            {
                queryMysql("INSERT INTO `repicomment`(`username`, `comment username`, `comment`, `comment id`, `issue no`, `reported on`) VALUES ('$user','$usrc','$cmc','$cmntid','$cnt',NOW())");
                $pc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usrc'");
                $pcc=$pc->fetch_array(MYSQLI_ASSOC);
                $pcs=$pcc['icomment']-1;
                queryMysql("UPDATE `profile count` SET `icomment`='$pcs' WHERE `username`='$usrc'");
            }
            die(header('location:yourrequirecmnt.php?content='.$cnt));
        }
    }
    if(isset($_REQUEST['content']))
    {
        $cnt= sanitizeString($_REQUEST['content']);
        $result= queryMysql("SELECT * FROM `requirement` WHERE `issue no`='$cnt'");
        if($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
        }
        $result1= queryMysql("SELECT * FROM `comment` WHERE `issue no`='$cnt'");
        if($result1->num_rows)
        {
            $rows = $result1->num_rows;
        }
    }
?>
    <div data-role="page" id="" data-url="">
        <header><div data-role="header" data-fullscreen="true" class="info" id="header" data-position="fixed">
            <h1 id="hh1"><?php echo $userstr;?></h1>
            <a href="javascript:void(0)" onClick="openNav()" aria-label="menu" class="icon pos01" data-icon="bars" data-iconpos="notext">&#9776;</a>
            </div>
        </header>
        <main>      
            <div data-role="main" id="main01" class="ui-content jqm-fullwidth jqm-content">
                <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);"></div>
                <div class="overlay" data-theme="a" id="myNav">
                    <div class="overlay2">
                        <a href="javascript:void(0)" onClick="closeNav()" class="closebtn">&times;</a>
                        <div id="photo301"><?php if (file_exists("uploads/$user.jpg"))
                                                    echo "<img id='photo301' src='uploads/$user.jpg'>";
                                                else echo "<span id='pho302'>Please upload pic</span>";?></div>
                        <div><h1><?php echo $user;?></h1></div>
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
                <div id="cnt600">
                    <?php
                        if(isset($_REQUEST['content']))
                        {
                            if($result->num_rows)
                            {
                                $usr=$row['username'];
                                $un=queryMysql("SELECT * FROM `issue viewed` WHERE `username`='$user' AND `issue no`='$cnt'");
                                /*ip address check 
                                $ip= queryMysql("SELECT * FROM `ip address` WHERE `username`='$usr'");
                                $ip1=$ip->fetch_array(MYSQLI_ASSOC);
                                $ipa1=$ip1['address'];
                                $ip= queryMysql("SELECT * FROM `ip address` WHERE `username`='$user'");
                                $ip2=$ip->fetch_array(MYSQLI_ASSOC);
                                $ipa2=$ip2['address'];
                                */
                                if($un->num_rows==0)
                                {
                                    if($usr!=$user)/*&&($ipa1!=$ipa2)*/
                                    {
                                        $pvc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usr'");
                                        if($pvc->num_rows)
                                        {
                                            $pvcc=$pvc->fetch_array(MYSQLI_ASSOC);
                                            $pvs=$pvcc['issue view']+1;
                                            queryMysql("UPDATE `profile count` SET `issue view`='$pvs' WHERE `username`='$usr'");
                                            queryMysql("INSERT INTO `issue viewed`( `username`, `issue username`, `issue no`, `viewed on`) VALUES ('$user','$usr','$cnt',NOW())");
                                        }
                                    }
                                }
                                $pt=strtotime($row['posting time']);
                                echo '<div class="in500"><b>Issue No.'. $row['issue no'].'</b>'.'&nbsp;&nbsp;&#8652;&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$row['username'].'</a>&nbsp;&nbsp;&#9872;&nbsp;&nbsp;'.'<span class="available">';
                                echo date("Y-m-d",$pt).'</span></div>';
                                echo '<div class="it500">'. ucfirst($row['issue']).'</div>';
                                echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.ucfirst($row['description']).'</div>';
                            } 
                        }
                    ?>
                    <div id="cmnt600">
                        <?php
                            if(isset($_REQUEST['content']))
                            {
                                if($result1->num_rows)
                                {
                                    for ($j = 0 ; $j < $rows ; ++$j)
                                    {
                                        $row1 = $result1->fetch_array(MYSQLI_ASSOC);
                                        $usr = $row1['username'];
                                        $cmntid=$row1['comment id'];
                                        $cmntid2=0;
                                        $rep=queryMysql("SELECT * FROM `repicomment` WHERE `issue no`='$cnt' AND `comment id`='$cmntid'");
                                        if($rep->num_rows)
                                        {
                                            $repo=$rep->fetch_array(MYSQLI_ASSOC);
                                            $cmntid2=$repo['comment id'];
                                        }
                                        if($cmntid2==$cmntid)
                                        continue;
                                        echo '<div class="usr600"><b><a href="member.php?content='.$usr.'">'.$row1['username'].'</a></b>'.'&nbsp;&nbsp;'.'<span class="time">';
                                        echo timeAgo(strtotime($row1['posting time'])).'</span>';
                                        if($row['username']==$user)
                                        {
                        ?>
                                            <span class='gap'>
                                                <form class="c602" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post">
                                                    <?php echo '<input type="hidden" name="content" value='.$cnt.'>';?>
                                                    <?php echo '<input type="hidden" name="comment" value='.$cmntid.'>';?>
                                                    <label for='del600'></label><input type='submit' value='Delete' name='delete' class='del600'>
                                                </form>
                                            </span>
                                            <div class="tooltip5"><button id="ic" style="font-size:24px;margin-left:15px;">&#10071;</button>
                                                <span class="tooltiptext5">
                                                    <form class="c605" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post">
                                                        <?php echo '<input type="hidden" name="content" value='.$cnt.'>';?>
                                                        <?php echo '<input type="hidden" name="comment" value='.$cmntid.'>';?>
                                                        <label for='del600'></label><input type='submit' value='Report User' name='report' class='del600'>
                                                    </form>
                                                </span>
                                            </div>
                        <?php
                                        }
                                        echo '</div>';
                                        echo '<div class="cmnt601"><span style="font-size:larger;">&#8627;</span>&nbsp;'.$row1['comment'].'</div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                    <div id="cmnt602">
                        <?php
                            if(isset($_REQUEST['content']))
                            {
                                if($result->num_rows)
                                {
                        ?>
                            <form class="c600" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post">
                            <label for="cmnt603"></label><textarea name="comment" class="input" id="cmnt603" cols="30" rows="10" required></textarea>
                            <input type="submit" value="Publish" name="publish" class="ui-btn">
                            <?php echo '<input type="hidden" name="content" value='.$cnt.'>';?>
                            </form>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>