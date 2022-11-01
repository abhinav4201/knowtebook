<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php 
    $macap="";
    $rpc=$rpc1=$rpc2=0;
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (isset($_POST['submit']))
        {
            $ct= sanitizeString($_POST['ctitle']);
            queryMysql("INSERT INTO `course title`( `username`, `course title`, `requested time`) VALUES ('$user','$ct',NOW())");
            $q= queryMysql("SELECT `post no`, `title` FROM `post` WHERE `username`='$user'");
            $pos=$q->num_rows;
            for($j=0; $j<$pos;++$j)
            {
                $po=$q->fetch_array(MYSQLI_ASSOC);
                $pon=$po['post no'];
                if(isset($_POST['p'.$pon]))
                {
                    if(($_POST['p'.$pon])!="")
                    {
                        $pono= sanitizeString($_POST['p'.$pon]);
                        queryMysql("INSERT INTO `courses`(`username`, `course title`, `post no`, `requested time`) VALUES ('$user','$ct','$pono',NOW())");
                    }
                }
            }
            die(header('location:insider.php'));
        }
        $cou=queryMysql("SELECT * FROM `course title` WHERE `username`='$user'");
        for($j=0; $j<($cou->num_rows);++$j)
        {
            $ctt=$cou->fetch_array(MYSQLI_ASSOC);
            $con=$ctt['course no'];
            if(isset($_POST['cc'.$con]))/*cc.$con is the value of submit button */
            {
                $cp= sanitizeString($_POST['c'.$con]);/*c.$con is the value of course no */
                queryMysql("UPDATE `course title` SET `course price`= '$cp' WHERE `course no`='$con'");
                die(header('location:insider.php'));
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
                <div id="cont10">
                    <div id="fakebox4">
                        <?php 
                            $rc=queryMysql("SELECT * FROM `milestone` WHERE `username`='$user'");
                            if($rc->num_rows)
                            {
                                $mac=queryMysql("SELECT * FROM `milestone approved` WHERE `username`= '$user'");
                                if($mac->num_rows)
                                {
                                    $maca=$mac->fetch_array(MYSQLI_ASSOC);
                                    $macap=$maca['approved'];
                                }
                                if($macap=="yes")
                                {
                                    echo '<p style="font-size:24px;margin:0 0 12px">* Congratulation on Completing Milestone<br>Please select Notes for particular course.&nbsp;<button onClick="Notes()" id="dropdown">&#9914;</button></p>';
                                    echo '<p style="font-size:24px;margin:0 0 12px">* Your courses&nbsp;&nbsp;<button onClick="course()" id="dropdwn">&#9914;</button></p>';
                                    echo '<p style="font-size:24px;margin:0 0 12px">* Purchased history&nbsp;&nbsp;<button onClick="pcount()" id="drpdwn">&#9914;</button></p>';
                                    echo '<div id="cour" style="display:none;">';
                                    echo '<div id="cour2">';
                                    $c= queryMysql("SELECT * FROM `course title` WHERE `username`='$user'");
                                    for($j=0; $j<($c->num_rows);++$j)
                                    {
                                        $co=$c->fetch_array(MYSQLI_ASSOC);
                                        $cpp=$co['course price'];
                                        echo '<form method="post" action="'.sanitizeString(htmlspecialchars($_SERVER['PHP_SELF'])).'">';
                                        echo '<a href="course.php?content='.$co['course no'].'">'.$co['course title'].'</a>';
                                        echo '<input type="number" name="c'.$co['course no'].'" class="input icp" placeholder="';
                                        if($cpp!=0)
                                        {
                                            echo 'Rs &nbsp;'.$cpp.'">';
                                        }else{
                                            echo 'Enter Price">';
                                        }
                                        echo '<input type="submit" name="cc'.$co['course no'].'" value="Add">';
                                        echo '</form>'; 
                                    }
                                    echo '</div></div>';
                                    echo '<div id="pcount"style="display:none;">';
                                    echo '<div id="pcount2">';
                                    $pc= queryMysql("SELECT * FROM `course title` WHERE `username`='$user'");
                                    for($j=0; $j<($c->num_rows);++$j)
                                    {
                                        $pcc=$pc->fetch_array(MYSQLI_ASSOC);
                                        $cno=$pcc['course no'];
                                        $re=queryMysql("SELECT * FROM `purchased course count` WHERE `course no`='$cno'");
                                        if($re->num_rows)
                                        {
                                            $cnt=$re->fetch_array(MYSQLI_ASSOC);
                                            $count=$cnt['count'];
                                        }else{
                                            $count=0;
                                        }
                                        echo ucfirst($pcc['course title']).'&nbsp; : &nbsp;'.$count.'<br>';
                                    }
                                    echo '</div></div>';
                                    echo '<div id="choices" style="display:none;">';
                                    echo '<form method="post" action="'.sanitizeString(htmlspecialchars($_SERVER['PHP_SELF'])).'">';
                                    echo '<input type="text" name="ctitle" required id="ct100" class="input" placeholder="Enter course Title*">';
                                    echo '<div id="checbox">';
                                    $p= queryMysql("SELECT `post no`, `title` FROM `post` WHERE `username`='$user'");
                                    $pos=$p->num_rows;
                                    for($j=0; $j<$pos;++$j)
                                    {
                                        $po=$p->fetch_array(MYSQLI_ASSOC);
                                        $pon=$po['post no'];
                                        $cop=queryMysql("SELECT * FROM `copyright notes` WHERE `notes no`='$pon'");
                                        if($cop->num_rows)
                                        {continue;}
                                        $cop2=queryMysql("SELECT * FROM `courses` WHERE `post no`='$pon'");
                                        if($cop2->num_rows)
                                        {continue;}
                                        echo $po['title'].'<input type="checkbox" name="p'.$pon.'" value="'.$pon.'">';
                                    }
                                    echo '</div>';
                                    echo '<br><input type="submit" class="ui-btn" name="submit" value="Submit">';
                                    echo '</form></div>';
                                }
                            }
                        ?>
                        <div id="tcc200">
                            <p style="font-size:24px;margin:0 0 12px">Every User need to complete <i style="color:chocolate;">milestone</i> , <i style="color:chocolate;">total sponsor count</i> and <i style="color:chocolate;">a minimum of 6 months from date of joining</i> in order to start selling their courses.<br>Once completed, your account will be approved.<br><br> Milestone = TC-YR-YRC-TS-YS </p>
                            <?php
                                $result=queryMysql("SELECT * FROM `profile count` WHERE `username`='$user'");
                                $row=$result->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <table id="tc100">
                                <caption>Total Count</caption>
                                <tr>
                                    <th class="th5">Profile Visit</th>
                                    <td><?php echo $row['profile visit'] ?></td>
                                </tr>
                                <tr>
                                    <th class="th5">Notes View</th>
                                    <td><?php echo $row['post view'] ?></td>
                                </tr>
                                <tr>
                                    <th class="th5">Research View</th>
                                    <td><?php echo $row['research view'] ?></td>
                                </tr>
                                <tr>
                                    <th class="th5">Requirement View</th>
                                    <td><?php echo $row['issue view'] ?></td>
                                </tr> 
                                <tr>
                                    <th class="th5">Total Comment</th>
                                    <td><?php echo $row['pcomment']+$row['rcomment']+$row['icomment'] ?></td>
                                </tr>
                                <tr>
                                    <th class="th5"><button id="btyr" class="input" onClick="Yr()">You Reported</button></th>
                                    <td>
                                        <?php 
                                            $rep=queryMysql("SELECT * FROM `reppcomment` WHERE `username`='$user'");
                                            $rp=$rep->num_rows;
                                            $rer=queryMysql("SELECT * FROM `reprcomment` WHERE `username`='$user'");
                                            $rr=$rer->num_rows;
                                            $rei=queryMysql("SELECT * FROM `repicomment` WHERE `username`='$user'");
                                            $ri=$rei->num_rows;
                                            echo $rp+$rr+$ri; 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="th5"><button id="btyrc" class="input" onClick="Yrc()">Your Report Count</button></th>
                                    <td>
                                        <?php 
                                            $repu=queryMysql("SELECT * FROM `reppcomment` WHERE `comment username`='$user'");
                                            $rpu=$repu->num_rows;
                                            $reru=queryMysql("SELECT * FROM `reprcomment` WHERE `comment username`='$user'");
                                            $rru=$reru->num_rows;
                                            $reiu=queryMysql("SELECT * FROM `repicomment` WHERE `comment username`='$user'");
                                            $riu=$reiu->num_rows;
                                            echo $rpu+$rru+$riu; 
                                        ?>
                                    </td>
                                </tr>  
                                <tr>
                                    <th class="th5">Total Sponsor</th>
                                    <td>
                                        <?php 
                                            $tsp=queryMysql("SELECT * FROM `sponsor` WHERE `sponsored`='$user'");
                                            echo $tsp->num_rows; 
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="th5"><button id="btsp" class="input" onClick="Ysp()">You Sponsored</button></th>
                                    <td>
                                        <?php 
                                            $ysp=queryMysql("SELECT * FROM `sponsor` WHERE `username`='$user'");
                                            echo $ysp->num_rows; 
                                        ?>
                                    </td>
                                </tr>
                            </table>
                            <table id="tsp100">
                                <caption class="capysp"> Sponsored &nbsp;<a href="javascript:void(0)" onClick="closeYsp()" class="closebtn">&times;</a> </caption>
                                <?php 
                                    for($j=0; $j< ($ysp->num_rows); ++$j)
                                    {
                                        $yspn=$ysp->fetch_array(MYSQLI_ASSOC);
                                        $ur=$yspn['sponsored'];
                                        echo '<tr><th class="th2"><a href="member.php?content='.$yspn['sponsored'].'">'.ucfirst($yspn['sponsored']).'</a></th>';
                                        if (file_exists("uploads/$ur.jpg"))
                                        echo "<td class='td2'><img id='photoi01' src='uploads/$ur.jpg'>";
                                        echo '</td></tr>';
                                    }
                                ?>
                            </table>
                            <table id="yr100">
                                <caption class="capysp"> You Reported &nbsp;<a href="javascript:void(0)" onClick="closeYr()" class="closebtn">&times;</a> </caption>
                                <?php 
                                    for($j=0; $j< ($rp); ++$j)
                                    {
                                        $rpn=$rep->fetch_array(MYSQLI_ASSOC);
                                        $ur=$rpn['comment username'];
                                        echo '<tr><th class="th3"><a href="member.php?content='.$rpn['comment username'].'">'.ucfirst($rpn['comment username']).'</a></th>';
                                        echo "<td class='td2'>".$rpn['comment'];
                                        echo '</td></tr>';
                                    }
                                    for($j=0; $j< ($rr); ++$j)
                                    {
                                        $rpn=$rer->fetch_array(MYSQLI_ASSOC);
                                        $ur=$rpn['comment username'];
                                        echo '<tr><th class="th3"><a href="member.php?content='.$rpn['comment username'].'">'.ucfirst($rpn['comment username']).'</a></th>';
                                        echo "<td class='td2'>".$rpn['comment'];
                                        echo '</td></tr>';
                                    }
                                    for($j=0; $j< ($ri); ++$j)
                                    {
                                        $rpn=$rei->fetch_array(MYSQLI_ASSOC);
                                        $ur=$rpn['comment username'];
                                        echo '<tr><th class="th3"><a href="member.php?content='.$rpn['comment username'].'">'.ucfirst($rpn['comment username']).'</a></th>';
                                        echo "<td class='td2'>".$rpn['comment'];
                                        echo '</td></tr>';
                                    }
                                ?>
                            </table>
                            <table id="yrc100">
                                <caption class="capysp"> Your Report Count &nbsp;<a href="javascript:void(0)" onClick="closeYrc()" class="closebtn">&times;</a> </caption>
                                <?php 
                                    for($j=0; $j< ($rpu); ++$j)
                                    {
                                        $rpn=$repu->fetch_array(MYSQLI_ASSOC);
                                        $ur=$rpn['username'];
                                        echo '<tr><th class="th3"><a href="member.php?content='.$rpn['comment username'].'">'.ucfirst($rpn['comment username']).'</a></th>';
                                        echo "<td class='td2'>".$rpn['comment'];
                                        echo '</td></tr>';
                                    }
                                    for($j=0; $j< ($rru); ++$j)
                                    {
                                        $rpn=$reru->fetch_array(MYSQLI_ASSOC);
                                        $ur=$rpn['username'];
                                        echo '<tr><th class="th3"><a href="member.php?content='.$rpn['comment username'].'">'.ucfirst($rpn['comment username']).'</a></th>';
                                        echo "<td class='td2'>".$rpn['comment'];
                                        echo '</td></tr>';
                                    }
                                    for($j=0; $j< ($riu); ++$j)
                                    {
                                        $rpn=$reiu->fetch_array(MYSQLI_ASSOC);
                                        $ur=$rpn['username'];
                                        echo '<tr><th class="th3"><a href="member.php?content='.$rpn['comment username'].'">'.ucfirst($rpn['comment username']).'</a></th>';
                                        echo "<td class='td2'>".$rpn['comment'];
                                        echo '</td></tr>';
                                    }
                                ?>
                            </table>
                            <p style="font-size:24px">
                                <?php 
                                    $m=$row['profile visit']+$row['post view']+$row['research view']+$row['issue view']+$row['pcomment']+$row['rcomment']+$row['icomment']-(round(($rp+$rr+$ri)/10)+2*($rpu+$rru+$riu));
                                    $rpc= $rpu+$rru+$riu;
                                    $ts=$tsp->num_rows;
                                    if($m>5000 && $ts>2000)
                                    {
                                        $rd=queryMysql("SELECT * FROM `profiles` WHERE `username`='$user'");
                                        if($rd->num_rows)
                                        {
                                            $rda=$rd->fetch_array(MYSQLI_ASSOC);
                                            $rdat=$rda['registration date'];
                                            $tm=strtotime($rdat);
                                            $tmago= timeAgoR($tm);
                                        }
                                        if($tmago>=6)
                                        {
                                            $mc=queryMysql("SELECT * FROM `milestone` WHERE `username`='$user'");
                                            if($mc->num_rows==0)
                                            {
                                                queryMysql("INSERT INTO `milestone`(`username`, `milestone`, `total sponsor`, `completing date`) VALUES ('$user','$m','$ts',NOW())");
                                            }
                                            else{
                                                queryMysql("UPDATE `milestone` SET `milestone`='$m',`total sponsor`='$ts' WHERE `username`='$user'");
                                            }
                                            $ma=queryMysql("SELECT * FROM `milestone approved` WHERE `username`= '$user'");
                                            if($ma->num_rows==0)
                                            {
                                                queryMysql("INSERT INTO `milestone approved`( `username`) VALUES ('$user')");
                                            }
                                        }
                                    }
                                    elseif($m>10000 && $ts>7000)
                                    {
                                        $rd=queryMysql("SELECT * FROM `profiles` WHERE `username`='$user'");
                                        if($rd->num_rows)
                                        {
                                            $rda=$rd->fetch_array(MYSQLI_ASSOC);
                                            $rdat=$rda['registration date'];
                                            $tm=strtotime($rdat);
                                            $tmago= timeAgoR($tm);
                                        }
                                        if($tmago>=12)
                                        {
                                            $mc=queryMysql("SELECT * FROM `milestone` WHERE `username`='$user'");
                                            if($mc->num_rows==0)
                                            {
                                                queryMysql("INSERT INTO `milestone`(`username`, `milestone`, `total sponsor`, `completing date`) VALUES ('$user','$m','$ts',NOW())");
                                            }
                                            else{
                                                queryMysql("UPDATE `milestone` SET `milestone`='$m',`total sponsor`='$ts' WHERE `username`='$user'");
                                            }
                                            $ma=queryMysql("SELECT * FROM `account verified` WHERE `username`= '$user'");
                                            if($ma->num_rows==0)
                                            {
                                                queryMysql("INSERT INTO `account verified`( `username`) VALUES ('$user')");
                                            }
                                        }
                                    }
                                ?>
                                Your Milestone = <?php echo $m;?>/5000
                                <br>
                                Total Sponsor = <?php echo $ts;?>/2000
                            </p>
                            <p style="font-size:24px">* To get verified <br>
                                Milestone = 10,000 <br>
                                Total Sponsor = 7,000 <br> and
                                member for atleast 1 year and need to submit their document when asked
                            </p>
                            <p style="font-size:24px">Joined On : 
                                <?php
                                    $rd=queryMysql("SELECT * FROM `profiles` WHERE `username`='$user'");
                                    if($rd->num_rows)
                                    {
                                        $rda=$rd->fetch_array(MYSQLI_ASSOC);
                                        $rdat=$rda['registration date'];
                                        $tm=strtotime($rdat);
                                        echo date(('Y-m-d'),$tm);
                                    }
                                ?>
                            </p>
                            <p style="font-size:24px"> Your Coupon : 
                                <?php 
                                    $coup=queryMysql("SELECT * FROM `coupon` WHERE `username`='$user'");
                                    if($coup->num_rows)
                                    {
                                        $coupon=$coup->fetch_array(MYSQLI_ASSOC);
                                        $coupno= $coupon['coupon'];
                                        echo $coupon['coupon'];
                                    }
                                ?>
                            </p>
                            <p style="font-size:24px">
                                <?php 
                                    $copp=queryMysql("SELECT * FROM `coupon used` WHERE `coupon`='$coupno'");
                                    if($copp->num_rows)
                                    {
                                        echo 'Coupon Used : '.($copp->num_rows);
                                    }
                                    else{
                                        echo 'Coupon Used : 0';
                                    }
                                ?>
                            </p>
                            <p style="font-size:24px">* Coupon Used is the number of coins that can be used to buy course during <em style="color:red">Resale Season.</em></p>
                            <?php
                                $cup=queryMysql("SELECT * FROM `create ad` WHERE `username`='$user'");
                                if($cup->num_rows)
                                {
                                    echo '<p id="adst11" style="font-size:30px">Advertisement Statistics</p>';
                                    for($j=0;$j<($cup->num_rows);++$j)
                                    {
                                        $ad=$cup->fetch_array(MYSQLI_ASSOC);
                                        $ano=$ad['ad no'];
                                        $strt=$ad['ad start date'];
                                        $tm=strtotime($strt);
                                        $tmago= timeAgoo($tm);
                                        if($tmago<=30)
                                        {                                        
                            ?>
                            <p class="adst12" style="font-size:24px">
                                Title : <?php echo $ad['video title'];?><br>
                                Unique Views : <?php echo $ad['video views']; ?><br>
                                Unique User : <?php echo $ad['people watched']; ?><br>
                                <?php 
                                    $rcup=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                    if($rcup->num_rows)
                                    {
                                        $report=$rcup->fetch_array(MYSQLI_ASSOC);
                                ?>
                                Advertisement Reported By : <?php echo '<a style="text-decoration:none;color:darkblue;" href="member.php?content='.$report['username'].'">'.ucfirst($report['username']).'</a>'; ?>
                            </p>
                            <?php }}}}?>
                            <?php /*notes */
                                $cup=queryMysql("SELECT * FROM `copyright notes` WHERE `reported username`='$user'");
                                $rpc1=$cup->num_rows;
                                if($cup->num_rows)
                                {
                                    echo '<p id="cprt11" style="font-size:30px">Copyright Issue - NOTES</p>';
                                    for($j=0;$j<($cup->num_rows);++$j)
                                    {
                                        $ad=$cup->fetch_array(MYSQLI_ASSOC);
                                        $ano=$ad['notes no'];
                                        
                            ?>
                            <p class="adst12" style="font-size:24px">
                                NOTES : <?php echo '<a style="text-decoration:none;color:darkblue;" href="postcmnt.php?content='.$ad['notes no'].'">'.$ad['notes no'].'</a>';?><br>
                                Reported By : <?php echo '<a style="text-decoration:none;color:darkblue;" href="member.php?content='.$ad['reporting username'].'">'.ucfirst($ad['reporting username']).'</a>'; ?>
                            </p>
                            <?php }}?>
                            <?php /*research */
                                $cup=queryMysql("SELECT * FROM `copyright research` WHERE `reported username`='$user'");
                                $rpc2=$cup->num_rows;
                                if($cup->num_rows)
                                {
                                    echo '<p id="cprt11" style="font-size:30px">Copyright Issue - RESEARCH</p>';
                                    for($j=0;$j<($cup->num_rows);++$j)
                                    {
                                        $ad=$cup->fetch_array(MYSQLI_ASSOC);
                                        $ano=$ad['research no'];
                                        
                            ?>
                            <p class="adst12" style="font-size:24px">
                                RESEARCH PAPER : <?php echo '<a style="text-decoration:none;color:darkblue;" href="yourrdcmnt.php?content='.$ad['research no'].'">'.$ad['research no'].'</a>';?><br>
                                Reported By : <?php echo '<a style="text-decoration:none;color:darkblue;" href="member.php?content='.$ad['reporting username'].'">'.ucfirst($ad['reporting username']).'</a>'; ?>
                            </p>
                            <?php }}?>
                            <?php
                                $rpc=$rpc+$rpc1+$rpc2;
                                if($rpc>100)
                                {
                                    $cc=queryMysql("SELECT * FROM `total report count` WHERE `username`='$user'");
                                    if($cc->num_rows==0)
                                    {
                                        queryMysql("INSERT INTO `total report count`( `username`, `count`, `blocked on`) VALUES ('$user','$rpc',NOW())");
                                    }
                                    else{
                                        queryMysql("UPDATE `total report count` SET `count`= '$rpc',`blocked on`=NOW() WHERE `username`='$user'");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>