<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php 
    $error="";$target_dir = "uploads/";
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
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['upload']))
        {
            if(isset($_FILES['image']['name']))
            {
                $saveto = $target_dir ."$user.jpg";
                move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
                $typeok = TRUE;
                switch($_FILES['image']['type'])
                {
                    case "image/gif": $src = imagecreatefromgif($saveto); break;
                    case "image/jpeg": // Both regular and progressive jpegs
                    case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
                    case "image/png": $src = imagecreatefrompng($saveto); break;
                    default: $typeok = FALSE; break;
                }
                if ($typeok)
                {
                    list($w, $h) = getimagesize($saveto);
                    $max = 200;
                    $tw = $w;
                    $th = $h;
                    if ($w > $h && $max < $w)
                    {
                        $th = $max / $w * $h;
                        $tw = $max;
                    }
                    elseif ($h > $w && $max < $h)
                    {
                        $tw = $max / $h * $w;
                        $th = $max;
                    }
                    elseif ($max < $w)
                    {
                        $tw = $th = $max;
                    }
                    $tmp = imagecreatetruecolor($tw, $th);
                    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
                    imageconvolution($tmp, array(array(-1, -1, -1),array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
                    imagejpeg($tmp, $saveto);
                    imagedestroy($tmp);
                    imagedestroy($src);
                }
            }
            if(empty($_FILES['image']['name'])) {
                $error="<span class='error'>Please choose file</span>";
            }
        }
        if(isset($_POST['delete']))
        {
            if(file_exists($target_dir ."$user.jpg")){
            @unlink($target_dir ."$user.jpg");
            $error="<span class='available'>Photo deleted from server";}
           else{
            $error="<span class='error'>No photo present in server";}
        }
        if(isset($_POST['updateE']))
        {
            $result= queryMysql("SELECT `username` FROM education WHERE `username`='$user'");
            if($result->num_rows)
            {
                Education("phd",$user);
                Education("master",$user);
                Education("graduation",$user);
                Education("hsc",$user);
                Education("ssc",$user);
                Education("achievementE",$user);
            }
            die(header('location:editprofile.php'));
        }
        if(isset($_POST['updateW']))
        {
            $result= queryMysql("SELECT `username` FROM work WHERE `username`='$user'");
            if($result->num_rows)
            {
                Work("curcomp",$user);
                Work("crole",$user);
                Work("cexp",$user);
                Work("precomp",$user);
                Work("prole",$user);
                Work("pexp",$user);
                Work("achievement",$user);
            }
            die(header('location:editprofile.php'));
        }
        if(isset($_POST['deleteE']))
        {
            $result= queryMysql("SELECT * FROM education WHERE `username`='$user'");
            if($result->num_rows)
            {
                queryMysql("DELETE FROM `education` WHERE username='$user'");
            }
            die(header('location:editprofile.php'));
        }
        if(isset($_POST['deleteW']))
        {
            $result= queryMysql("SELECT * FROM work WHERE `username`='$user'");
            if($result->num_rows)
            {
                queryMysql("DELETE FROM `work` WHERE username='$user'");
            }
            die(header('location:editprofile.php'));
        }
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
<div data-role="page" id="editprofile" data-url="editprofile">
        <header><div class="info" id="header" data-role="header" data-fullscreen="true" data-position="fixed" id="header">
            <h1 id="hh1"><?php echo $userstr;?></h1>
            <a href="javascript:void(0)" onClick="openNav()" aria-label="menu" class="icon pos01" data-icon="bars" data-iconpos="notext">&#9776;</a>
            </div>
        </header>
        <main>      
            <div data-role="main" id="main01" class="ui-content">
                <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);"></div>
                <div class="overlay" data-theme="a" id="myNav">
                    <div class="overlay2">
                        <a href="javascript:void(0)" onClick="closeNav()" class="closebtn">&times;</a>
                        <div id="photo301"><?php if (file_exists($target_dir."$user.jpg"))
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
                <div id="cnt300">
                    <div id="left300">
                        <form class="c300" data-ajax="false" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" enctype='multipart/form-data'>
                            <div id="photo300"><?php if (file_exists($target_dir."$user.jpg"))
                                                    echo "<img id='photo301' src='uploads/$user.jpg'>";
                                                    else echo "<span id='pho302' aria-label='upload photo'>Please upload pic</span>";?></div>
                            <div id="img301"><label for="img300">Image</label><input type="file" name="image" class="input" id="img300" accept="image/*" aria-label="profile pic"></div>
                            <div id="btn300">
                                <input type="submit" class="ui-btn" aria-label="upload" value="upload" name="upload">
                                <input type="submit" class="ui-btn" aria-label="delete" value="Delete" name="delete">
                            </div>
                            <div id="er300"><?php echo $error;?></div>
                        </form>
                    </div>
                    <div id="left301">
                        <form class="c300" data-ajax="false" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post">
                            <fieldset id="f300">
                                <legend>Education</legend>
                                <div id="phd301"><label for="phd300">Phd</label><input type="text" name="phd" id="phd300" aria-label="phd" class="input" placeholder="<?php if(@$row['phd']=="")echo 'Specialization';else echo $row['phd'];?>"></div>
                                <div id="mas300"><label for="mas301">Master's</label><input type="text" name="master" aria-label="master" id="mas301" class="input" placeholder="<?php if(@$row['master']=="")echo 'Specialization';else echo $row['master'];?>"></div>
                                <div id="gra300"><label for="gra301">Graduation</label><input type="text" name="graduation" aria-label="graduation" id="gra301" class="input" placeholder="<?php if(@$row['graduation']=="")echo 'Specialization';else echo $row['graduation'];?>"></div>
                                <div id="hsc300"><label for="hsc301">HSC</label><input type="text" name="hsc" id="hsc301" aria-label="hsc" class="input" placeholder="<?php if(@$row['hsc']=="")echo 'Specialization';else echo $row['hsc'];?>"></div>
                                <div id="ssc300"><label for="ssc301">SSC</label><input type="text" name="ssc" id="ssc301" aria-label="ssc" class="input" placeholder="<?php if(@$row['ssc']=="")echo 'Specialization';else echo $row['ssc'];?>"></div>
                                <div id="ach300"><label for="ach301">Any</label><input type="text" name="achievementE" onFocus="achievemente()" id="ach301" aria-label="achievement" class="input" placeholder="<?php if(@$row['achievementE']=="")echo 'Achievements';else echo $row['achievementE'];?>"></div>
                                <div id="ach302">&nbsp;</div>
                            </fieldset>
                            <div id="btn301">
                                <input type="submit" class="ui-btn" name="updateE" aria-label="update" value="Update">
                                <input type="submit" class="ui-btn" name="deleteE" aria-label="delete" value="Delete">
                            </div>
                        </form>
                    </div>
                    <div id="left302">
                        <form class="c300" data-ajax="false" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post">
                            <fieldset id="f300">
                                <legend>Work</legend>
                                <div id="cc300"><label for="cc301">Current</label><input type="text" name="curcomp" aria-label="current company" class="input" id="cc301" placeholder="<?php if(@$row1['curcomp']=="")echo 'Company';else echo $row1['curcomp'];?>"></div>
                                <div id="crol300"><label for="crol301">Current</label><input type="text" name="crole" aria-label="current role" class="input" id="crol301" placeholder="<?php if(@$row1['crole']=="")echo 'Role';else echo $row1['crole'];?>"></div>
                                <div id="cexp300"><label for="cexp301">Current</label><input type="number" name="cexp" aria-label="current experience" class="input" id="cexp301" placeholder="<?php if(@$row1['cexp']==0)echo 'Experience (in year)';else echo $row1['cexp'];?>"></div>
                                <div id="pc300"><label for="pc301">Previous</label><input type="text" name="precomp" aria-label="previous company" class="input" id="pc301" placeholder="<?php if(@$row1['precomp']=="")echo 'Company';else echo $row1['precomp'];?>"></div>
                                <div id="prol300"><label for="prol301">Previous</label><input type="text" name="prole" aria-label="previous role" class="input" id="prol301" placeholder="<?php if(@$row1['prole']=="")echo 'Role';else echo $row1['prole'];?>"></div>
                                <div id="pexp300"><label for="pexp301">Previous</label><input type="number" name="pexp" aria-label="previous experience" class="input" id="pexp301" placeholder="<?php if(@$row1['pexp']==0)echo 'Experience (in year)';else echo $row1['pexp'];?>"></div>
                                <div id="ach303"><label for="ach304">Any</label><input type="text" name="achievement" onFocus="achievementw()" id="ach304" aria-label="achievement" class="input" placeholder="<?php if(@$row1['achievement']=="")echo 'Achievements';else echo $row1['achievement'];?>"></div>
                                <div id="ach305">&nbsp;</div>
                            </fieldset>
                            <div id="btn302">
                                <input type="submit" class="ui-btn" name="updateW" aria-label="update" value="Update">
                                <input type="submit" class="ui-btn" name="deleteW" aria-label="delete" value="Delete">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>
