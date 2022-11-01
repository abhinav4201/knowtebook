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
            if(empty($_SESSION['6_letters_code'] ) ||
	            strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
            {
                $error="Number does not match";
            }else {
                $is = sanitizeString($_POST['issue']);
                $des = sanitizeString($_POST['description']);
                if(isset($_POST['category']))
                $cat = sanitizeString($_POST['category']);
                queryMysql("INSERT INTO `requirement` VALUES (NULL,'$user','$cat','$is','$des',NOW())");
                $insertID = $connection->insert_id;
                $ins = queryMysql("SELECT * FROM `sponsor` WHERE `sponsored`='$user'");
                if($ins->num_rows)
                {
                    queryMysql("UPDATE `sponsor` SET `issue no`='$insertID',`issue status`=0 ,`research no`=0,`research status`=1,`post no`=0,`post status`=1,`posting time`=NOW() WHERE `sponsored`='$user'");
                }
                die(header('location:postrequire.php'));
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
                <div id="cnt400">
                    <div id="fakebox3">
                        <div id="top400">
                            <h3 id="ph3">POST REQUIREMENT</h3>
                            <form action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" class="c400">
                                <div id="cat400">
                                    <div id="cat402">Select category *</div>
                                    <select name="category" id="cat401" class="input" required>
                                        <option value="education">Education</option>
                                        <option value="career">Career</option>
                                        <option value="work">Work</option>
                                        <option value="health">Health</option>
                                        <option value="parenting">Parenting</option>
                                        <option value="law">Law</option>
                                        <option value="research">Research</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <label for="it400">ISSUE</label><input type="text" name="issue" class="input" id="it400" placeholder="Heading" maxlength="200" required>
                                <label for="id400">DESCRIPTION</label><textarea name="description" id="id400" class="input" placeholder="Describe your issue" cols="30" rows="10" required></textarea>
                                <div id="cpcha400"><label for="cpcha401"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ></label><input type="text" name="6_letters_code" id="cpcha401" class="input" placeholder="Captcha" required>
                                <small>click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></div>
                                <input type="submit" value="Publish" name="publish" id="b400" class="ui-btn">
                                <br><span class="error" id="used400"><?php echo $error;?></span>
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