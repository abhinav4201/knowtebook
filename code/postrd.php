<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php
    $error="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['publish']))
        {
            $tit = sanitizeString($_POST['title']);
            $int = sanitizeString($_POST['introduction']);
            $the = sanitizeString($_POST['thesis']);
            $body= sanitizeString($_POST['body']);
            $sum = sanitizeString($_POST['summary']);
            $ref = sanitizeString($_POST['reference']);
            $icop = queryMysql("SELECT * FROM `research paper` WHERE `introduction`='$int'");
            $tcop = queryMysql("SELECT * FROM `research paper` WHERE `thesis`='$the'");
            $bcop = queryMysql("SELECT * FROM `research paper` WHERE `body`='$body'");
            if(($icop->num_rows==0) && ($tcop->num_rows==0) && ($bcop->num_rows==0))
            {
                queryMysql("INSERT INTO `research paper` VALUES (NULL,'$user','$tit','$int','$the','$body','$sum','$ref',NoW())");
                $insertID = $connection->insert_id;
                $ins = queryMysql("SELECT * FROM `sponsor` WHERE `sponsored`='$user'");
                if($ins->num_rows)
                {
                    queryMysql("UPDATE `sponsor` SET `research no`='$insertID',`research status`=0,`post no`=0,`post status`=1,`issue no`=0,`issue status`=1,`posting time`=NOW() WHERE `sponsored`='$user'");
                }
                die(header('location:postrd.php'));
            }
            else{
                if($bcop->num_rows)
                {
                    $co=$bcop->fetch_array(MYSQLI_ASSOC);
                    $nno=$co['no'];
                    $nusr=$co['username'];
                    $ntit=$co['title'];
                    $error="Copy Paste is not allowed.<br>";
                    $error.="Title : <a href='yourrdcmnt.php?content=".$nno."' style='text-decoration:none;'>".$ntit."</a><br>From : <a href='member.php?content=".$nusr."' style='text-decoration:none;'>".$nusr."</a>";
                }
                elseif($icop->num_rows)
                {
                    $co=$icop->fetch_array(MYSQLI_ASSOC);
                    $nno=$co['no'];
                    $nusr=$co['username'];
                    $ntit=$co['title'];
                    $error="Copy Paste is not allowed.<br>";
                    $error.="Title : <a href='yourrdcmnt.php?content=".$nno."' style='text-decoration:none;'>".$ntit."</a><br>From : <a href='member.php?content=".$nusr."' style='text-decoration:none;'>".$nusr."</a>";
                }
                elseif($tcop->num_rows)
                {
                    $co=$tcop->fetch_array(MYSQLI_ASSOC);
                    $nno=$co['no'];
                    $nusr=$co['username'];
                    $ntit=$co['title'];
                    $error="Copy Paste is not allowed.<br>";
                    $error.="Title : <a href='yourrdcmnt.php?content=".$nno."' style='text-decoration:none;'>".$ntit."</a><br>From : <a href='member.php?content=".$nusr."' style='text-decoration:none;'>".$nusr."</a>";
                }
            }
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
                <?php echo '<div class="error cop9000">'.$error.'</div>';?>
                <div id="cnt400">
                    <div id="fakebox3">
                        <div id="top400">
                            <h3 id="ph3">REPORT</h3>
                            <form action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" class="c700">
                                <label for="tit700">TITLE</label><input type="text" name="title" id="tit700" class="input" placeholder="Title" required>
                                <label for="int700">INTRODUCTION</label><textarea name="introduction" class="input" required placeholder="Introduction" id="int700" cols="30" rows="10"></textarea>
                                <label for="the700">THESIS</label><textarea name="thesis" class="input" required placeholder="Thesis" id="the700" cols="30" rows="10"></textarea>
                                <label for="bod700">SUPPORTING POINTS</label><textarea name="body" class="input" required placeholder="Method + Result" id="bod700" cols="30" rows="10"></textarea>
                                <label for="sum700">SUMMARY</label><textarea name="summary" class="input" required placeholder="Summary" id="sum700" cols="30" rows="10"></textarea>
                                <label for="ref700">REFERENCES</label><textarea name="reference" class="input" required placeholder="References" id="ref700" cols="30" rows="10"></textarea>
                                <input type="submit" value="Publish" name="publish" id="b700" class="ui-btn">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>