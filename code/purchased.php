<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
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
                <div id="fakeboxp">
                    <div id="pco">Purchased Courses</div>
                    <div id="course">
                        <?php 
                            $res=queryMysql("SELECT * FROM `purchased course` WHERE `username`='$user'");
                            if($res->num_rows)
                            {
                                for($j=0; $j< ($res->num_rows); ++$j)
                                {
                                    $pr=$res->fetch_array(MYSQLI_ASSOC);
                                    $ptime=$pr['purchased date'];
                                    $cno=$pr['course no'];
                                    $pnd=queryMysql("SELECT * FROM `course title` WHERE `course no`='$cno'");
                                    $pnda=$pnd->fetch_array(MYSQLI_ASSOC);
                                    $price=$pnda['course price'];
                                    $cuser=$pnda['username'];
                                    $ct=$pnda['course title'];
                                    echo '<div class="cdetail"><a href="course.php?content='.$cno.'">'.ucfirst($ct).'</a></div>';
                                    echo '<div class="cde">From : <a href="member.php?content='.$cuser.'">'.ucfirst($cuser).'</a></div>';
                                    echo '<div class="cdet"> Purchased : '.date(("Y-m-d"),strtotime($ptime)).'</div>';
                                    echo '<div class="cpri">Price : Rs '.$price.'</div>';
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