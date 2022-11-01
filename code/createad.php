<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php 
    $amount=0;$error="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['create']))
        {
            $cop=queryMysql("SELECT * FROM `create ad` WHERE `username`='$user' AND `status`='0'");
            if($cop->num_rows==0)
            {
                $acat=sanitizeString($_POST['adcategory']);
                $vt=sanitizeString($_POST['vtitle']);
                $vd=sanitizeString($_POST['vdescription']);
                $vu=sanitizeString($_POST['vurl']);
                $vday=sanitizeString($_POST['day']);
                $amount= $vday*50;
                $target_dir = "ad_video/";
                if(isset($_FILES['video']['name']))
                {
                    $maxsize = 31457280;//30MB
                    $saveto = $target_dir ."$vt.mp4";
                    move_uploaded_file($_FILES['video']['tmp_name'], $saveto);
                    // Select file type
                    $videoFileType = strtolower(pathinfo($saveto,PATHINFO_EXTENSION));

                    // Valid file extensions
                    $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

                    // Check extension
                    if( in_array($videoFileType,$extensions_arr) ){
                        
                        // Check file size
                        if(($_FILES['video']['size'] >= $maxsize) || ($_FILES["video"]["size"] == 0)) {
                            $error= "File too large. File must be less than 30MB.";
                        }
                    }
                }
                else{
                    $error="Invalid Extension";
                }
                if(empty($_FILES['video']['name'])) {
                    $error="Please upload video";
                }else{/*when payment is done update amount by the total paid */
                queryMysql("INSERT INTO `create ad`( `username`, `category`, `video`, `video title`, `video description`, `website url`, `video views`, `people watched`, `no of days`, `amount`, `ad start date`, `status`) VALUES ('$user','$acat','$saveto','$vt','$vd','$vu','0','0','$vday','0',NOW(),'0')");
                $_SESSION['adamount']=$amount;
                $_SESSION['adtitle']=$vt;
                }
            }else
            {
                $error="Advertisement already running.";
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
                <div id="fakebox4">
                    <div class="error"><?php echo $error;?></div>
                    <form method="post" enctype='multipart/form-data' action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>">
                        <div id="cat900">
                            <div id="cat901">Select Category</div>
                            <select name="adcategory" onFocus="adCategory(this)" onChange="adCategory(this)" size="1" id="cat902" class="input">
                                <?php 
                                    $a= array("Select Category","education","property","electronics","fashion","food","jobs","ticket","hotel","hospital","pharmacy","cars","cabs","artist","entertainment","grocery","astrology","marketing","other");
                                    foreach($a as $ad)
                                    {
                                        echo '<option aria-label="'.$ad.'" value="'.$ad.'">'.$ad.'</option>';
                                    }unset($ad);
                                ?>
                            </select>
                            <div id="usedC">&nbsp;</div>
                        </div>
                        <div id="det900">
                            <p>* Maximum advertisement is for 7 days.</p>
                            <label for="vi12">Upload Ad</label><input aria-label="upload video" type="file" name="video" id="vi12" class="input" accept="video/*">
                            <label for="vt12"></label><input type="text" aria-label="ad title" name="vtitle" id="vt12" class="input" placeholder="Video Title *" maxlenght="150" required>
                            <label for="vd12"></label><textarea aria-label="ad description" name="vdescription" id="vd12" class="input" required placeholder="Describe Your Offer *" cols="30" rows="10"></textarea>
                            <label for="vu12"></label><input aria-label="website url" type="url" name="vurl" id="vu12" class="input" placeholder="Website Url(If any)">
                            <div id="det901">
                                <div id="det902"><label for="vday12"></label><input aria-label="no of days" type="number" min=0 max=7 name="day" id="vday12" class="input" onKeyup="dayN(this)" required placeholder="No of days*"></div>
                                <!--<div id="det903"><p></p></div>
                                <div id="det904"><?php /*echo 'Rs '.$amount;*/?></div>-->
                            </div>
                        </div>
                        <div id="det905"><input type="submit" aria-label="create ad" value="Create Ad" name="create" class="ui-btn"></div>
                    </form>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>