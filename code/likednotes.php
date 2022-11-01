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
                <div id="cont">
                    <?php 
                        $result=queryMysql("SELECT * FROM `liked post` WHERE `username`='$user'");
                        if($result->num_rows)
                        {
                            $rows=$result->num_rows;
                            for($j=0; $j<$rows; ++$j)
                            {
                                $row=$result->fetch_array(MYSQLI_ASSOC);
                                $pno=$row['post no'];
                                $cop=queryMysql("SELECT * FROM `copyright notes` WHERE `notes no`='$pno'");
                                if($cop->num_rows)
                                {
                                    continue;
                                }
                                $repos= queryMysql("SELECT * FROM `courses` WHERE `post no`='$pno'");
                                if($repos->num_rows)
                                {
                                    continue;
                                }
                                $p=queryMysql("SELECT * FROM `post` WHERE `post no`='$pno'");
                                $post=$p->fetch_array(MYSQLI_ASSOC);
                                $usr=$post['username'];
                                echo '<div class="in500"><b>Notes No.'. $post['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$post['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                echo timeAgo(strtotime($post['posting time'])).'</span></div>';
                                echo '<div class="it500"><a href=postcmnt.php?content='.$post['post no'].'>'.ucfirst($post['title']).'</a></div>';
                                echo '<div class="des500">'.ucfirst($post['metadescription']).'</div>';
                            }
                        }
                        $result=queryMysql("SELECT * FROM `liked research` WHERE `username`='$user'");
                        if($result->num_rows)
                        {
                            $rows=$result->num_rows;
                            for($j=0; $j<$rows; ++$j)
                            {
                                $row=$result->fetch_array(MYSQLI_ASSOC);
                                $pno=$row['research no'];
                                $cop=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$pno'");
                                if($cop->num_rows)
                                {
                                    continue;
                                }
                                $p=queryMysql("SELECT * FROM `research paper` WHERE `no`='$pno'");
                                $post=$p->fetch_array(MYSQLI_ASSOC);
                                $usr=$post['username'];
                                echo '<div class="in500"><b>Research Paper.'. $post['no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$post['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                echo timeAgo(strtotime($post['posting time'])).'</span></div>';
                                echo '<div class="it500"><a href=yourrdcmnt.php?content='.$post['no'].'>'.ucfirst($post['title']).'</a></div>';
                                echo '<div class="des500">'.ucfirst($post['introduction']).'</div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>