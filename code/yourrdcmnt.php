<?php
    require_once 'header.php';
    if(isset($_REQUEST['content']))
    {
        $cnt= sanitizeString($_REQUEST['content']);
        setcookie('research',$cnt,time()+60*15,'/');
    }
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php
    $true=$true1=FALSE;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['publish']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cmnt = sanitizeString($_POST['comment']);
            $result= queryMysql("SELECT * FROM `research paper` WHERE `no`='$cnt'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $usr=$row['username'];
            }
            queryMysql("INSERT INTO `rcomment`(`comment id`, `research username`, `research no`, `username`, `comment`, `posting time`) VALUES (NUll,'$usr','$cnt','$user','$cmnt',NOW())");
            if($usr!=$user)
            {
                $pc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$user'");
                $pcc=$pc->fetch_array(MYSQLI_ASSOC);
                $pcs=$pcc['rcomment']+1;
                queryMysql("UPDATE `profile count` SET `rcomment`='$pcs' WHERE `username`='$user'");
                
            }
            die(header('location:yourrdcmnt.php?content='.$cnt));
        }
        if(isset($_POST['delete']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cmntid= sanitizeString($_REQUEST['comment']);
            $result= queryMysql("SELECT * FROM `rcomment` WHERE `comment id`='$cmntid'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $usrc=$row['username'];
                $cmc= $row['comment'];
            }
            queryMysql("INSERT INTO `delrcomment`(`username`, `comment`, `research no`, `deleted on`) VALUES ('$usrc','$cmc','$cnt',NOW())");
            queryMysql("DELETE FROM `rcomment` WHERE `comment id`='$cmntid'");
            $pc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usrc'");
            $pcc=$pc->fetch_array(MYSQLI_ASSOC);
            $pcs=$pcc['rcomment']-1;
            queryMysql("UPDATE `profile count` SET `rcomment`='$pcs' WHERE `username`='$usrc'");
            die(header('location:yourrdcmnt.php?content='.$cnt));
        }
        if(isset($_POST['report']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cmntid= sanitizeString($_REQUEST['comment']);
            $result= queryMysql("SELECT * FROM `rcomment` WHERE `comment id`='$cmntid'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $usrc=$row['username'];
                $cmc= $row['comment'];
            }
            $r= queryMysql("SELECT * FROM `reprcomment` WHERE `comment id`='$cmntid' AND `comment username`='$usrc'");
            if($r->num_rows==0)
            {
                queryMysql("INSERT INTO `reprcomment`(`username`, `comment username`, `comment`, `comment id`, `research no`, `reported on`) VALUES ('$user','$usrc','$cmc','$cmntid','$cnt',NOW())");
                $pc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usrc'");
                $pcc=$pc->fetch_array(MYSQLI_ASSOC);
                $pcs=$pcc['rcomment']-1;
                queryMysql("UPDATE `profile count` SET `rcomment`='$pcs' WHERE `username`='$usrc'");
            }
            die(header('location:yourrdcmnt.php?content='.$cnt));
        }
        if(isset($_POST['rcopyrt']))
        {
            $cnt= sanitizeString($_REQUEST['content']);
            $cpc=queryMysql("SELECT * FROM `research paper` WHERE `no`='$cnt'");
            if($cpc->num_rows)
            {
                $cpcc=$cpc->fetch_array(MYSQLI_ASSOC);
                $usrcp=$cpcc['username'];
                $cpy=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$cnt'");
                if($cpy->num_rows==0)
                {
                    queryMysql("INSERT INTO `copyright research`(`reporting username`, `reported username`, `research no`, `reporting time`) VALUES ('$user','$usrcp','$cnt',NOW())");
                }
            }
            die(header('location:yourrdcmnt.php?content='.$cnt));
        }
    }
    if(isset($_REQUEST['content']))
    {
        $cnt= sanitizeString($_REQUEST['content']);
        $cpc=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$cnt'");
        if($cpc->num_rows==0)
        {
            $result= queryMysql("SELECT * FROM `research paper` WHERE `no`='$cnt'");
            if($result->num_rows)
            {
                $row = $result->fetch_array(MYSQLI_ASSOC);
                $true=TRUE;
            }
            $result1= queryMysql("SELECT * FROM `rcomment` WHERE `research no`='$cnt'");
            if($result1->num_rows)
            {
                $rows = $result1->num_rows;
                $true1=TRUE;
            }
        }
        else{
            $true=FALSE;
            $true1=FALSE;
            $cop=$cpc->fetch_array(MYSQLI_ASSOC);
            $rusr=$cop['reported username'];
            if($rusr==$user)
            {
                $result= queryMysql("SELECT * FROM `research paper` WHERE `no`='$cnt'");
                if($result->num_rows)
                {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    $true=TRUE;
                }
                $result1= queryMysql("SELECT * FROM `rcomment` WHERE `research no`='$cnt'");
                if($result1->num_rows)
                {
                    $rows = $result1->num_rows;
                    $true1=TRUE;
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
                <div id="cnt600">
                    <?php
                        if(isset($_REQUEST['content']))
                        {
                            if($true)
                            {
                                $usr=$row['username'];
                                $un=queryMysql("SELECT * FROM `research viewed` WHERE `username`='$user' AND `research no`='$cnt'");
                                /*ip address check 
                                $ip= queryMysql("SELECT * FROM `ip address` WHERE `username`='$usr'");
                                if($ip->num_rows)
                                {$ip1=$ip->fetch_array(MYSQLI_ASSOC);
                                $ipa1=$ip1['address'];}
                                $ip= queryMysql("SELECT * FROM `ip address` WHERE `username`='$user'");
                                if($ip->num_rows)
                                {$ip2=$ip->fetch_array(MYSQLI_ASSOC);
                                $ipa2=$ip2['address'];}
                                */
                                if($un->num_rows==0)
                                {
                                if($usr!=$user)/*&&($ipa1!=$ipa2)*/
                                    {
                                        $pvc=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usr'");
                                        if($pvc->num_rows)
                                        {
                                            $pvcc=$pvc->fetch_array(MYSQLI_ASSOC);
                                            $pvs=$pvcc['research view']+1;
                                            queryMysql("UPDATE `profile count` SET `research view`='$pvs' WHERE `username`='$usr'");
                                            queryMysql("INSERT INTO `research viewed`( `username`, `research username`, `research no`, `viewed on`) VALUES ('$user','$usr','$cnt',NOW())");
                                        }
                                    }
                                }
                                $rno=$row['no'];
                                echo '<div class="in500"><b>PAPER No.'. $row['no'].'</b>'.'&nbsp;&nbsp;&#8652;&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$row['username'].'</a>&nbsp;&nbsp;&#9872;&nbsp;&nbsp;'.'<span class="available">';
                                echo timeAgo(strtotime(date("Y-m-d",strtotime($row['posting time'])))).'</span></div>';
                                echo '<div class="it500">'. ucfirst($row['title']).'</div>';
                                echo '<div class="des700"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($row['introduction']).'</div>';  
                                echo '<div class="des700"><strong><i>THESIS:</i></strong> &nbsp;'.ucfirst($row['thesis']).'</div>';
                                echo '<div class="des700"><strong><i>BODY:</i></strong> &nbsp;'.ucfirst($row['body']).'</div>';
                                echo '<div class="des700"><strong><i>SUMMARY:</i></strong> &nbsp;'.ucfirst($row['summary']).'</div>';
                                echo '<div class="des500"><strong><i>REFERENCES:</i></strong> &nbsp;'.ucfirst($row['reference']).'</div>';
                                echo '<div id="likebtn">';
                                $cont=$contD="";
                                $c=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$rno'");
                                if($c->num_rows)
                                {
                                    $ct=$c->fetch_array(MYSQLI_ASSOC);
                                    $cont=$ct['lcount'];
                                    $contD=$ct['dcount'];
                                }
                                $p=queryMysql("SELECT * FROM `liked research` WHERE `username`='$user' AND `research no`='$rno'");
                                if($p->num_rows)
                                {
                                    echo '<div id="lik500"><button class="heart cross" id="heart" name="unlikeR" value="'.$rno.'" onClick="unlikeR(this)">&#10084;</button><span id="countR">'.$cont.'</span></div>';
                                }
                                else{
                                    echo '<div id="lik500"><button class="heart" id="heart" name="likeR" value="'.$rno.'" onClick="likeR(this)">&#10004;</button><span id="countR">'.$cont.'</span></div>';
                                }
                                $d=queryMysql("SELECT * FROM `disliker` WHERE `username`='$user' AND `research no`='$rno'");
                                if($d->num_rows)
                                {
                                    echo '<div id="lik501"><button class="heart" name="dlikeR" value="'.$rno.'">&#10060;</button><span id="countR">'.$contD.'</span></div>';
                                }
                                else{
                                    echo '<div id="lik501"><button class="heart" name="dlikeR" value="'.$rno.'" onClick="dlikeR(this)">&#10060;</button><span id="countR">'.$contD.'</span></div>';
                                }
                                echo '<div class="tooltip1"><button id="ic" style="font-size:24px;margin-left:15px;">&#9742;</button>';
                                echo '<span class="tooltiptext2">';
                                echo "<p>http://localhost/test/yourrdcmnt.php?content=".$cnt."</p>";      
                                echo '</span></div></div>';
                            } 
                        }
                    ?>
                    <?php if($true) { if($row['username']!=$user){?>
                    <div id="copyrt">
                        <form class="c602" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post">
                            <?php echo '<input type="hidden" name="content" value='.$cnt.'>';?>
                            <label for='del600'></label><input type='submit' value='Report Copyright' name='rcopyrt' class='del600'>
                        </form>
                    </div>
                    <?php }else{$cmp=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$cnt'");if($cmp->num_rows){
                        echo '<div id="copyrt" style="color:red;font-size:20px;">Copyright Issue  &#128274;</div>';}}} ?>
                    <div id="cmnt600">
                        <?php
                            if(isset($_REQUEST['content']))
                            {
                                if($true1)
                                {
                                    for ($j = 0 ; $j < $rows ; ++$j)
                                    {
                                        $row1 = $result1->fetch_array(MYSQLI_ASSOC);
                                        $usr = $row1['username'];
                                        $cmntid=$row1['comment id'];
                                        $cmntid2=0;
                                        $rep=queryMysql("SELECT * FROM `reprcomment` WHERE `research no`='$cnt' AND `comment id`='$cmntid'");
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
                                            <div class="tooltip3"><button id ="ic" style="font-size:24px;margin-left:15px;">&#10071;</button>
                                                <span class="tooltiptext3">
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
                                if($true)
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