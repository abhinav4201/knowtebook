<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
?>
<?php 
    $pvs=0;
    $pno=$rno=$ino=$c=0;
    $a=$b=$p=$r=$i=array();
    if(isset($_REQUEST['content']))
    {
        $usr= sanitizeString($_REQUEST['content']);
        $un=queryMysql("SELECT * FROM `profile viewed` WHERE `username`='$user' AND `profile username`='$usr'");
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
                    $pvs=$pvcc['profile visit']+1;
                    queryMysql("UPDATE `profile count` SET `profile visit`='$pvs' WHERE `username`='$usr'");
                    queryMysql("INSERT INTO `profile viewed`(`username`, `profile username`, `viewed on`) VALUES ('$user','$usr',NOW())");
                }
            }
        } 
        $rep= queryMysql("SELECT * FROM `profiles` WHERE username='$usr'");
        if($rep->num_rows)
        {
            $profile= $rep->fetch_array(MYSQLI_ASSOC);
        }
        $rel =queryMysql("SELECT * FROM `clocation` WHERE username='$usr'");
        if($rel->num_rows)
        {
            $cloc= $rel->fetch_array(MYSQLI_ASSOC);
        }
        $rew =queryMysql("SELECT * FROM `work` WHERE username='$usr'");
        if($rew->num_rows)
        {
            $work= $rew->fetch_array(MYSQLI_ASSOC);
        }
        $red =queryMysql("SELECT * FROM `education` WHERE username='$usr'");
        if($red->num_rows)
        {
            $edu= $red->fetch_array(MYSQLI_ASSOC);
        }
        $req =queryMysql("SELECT * FROM `requirement` WHERE username='$usr' ORDER BY `issue no` DESC");
        if($req->num_rows)
        {
            $rqs = $req->num_rows;
        }
        $res =queryMysql("SELECT * FROM `research paper` WHERE username='$usr' ORDER BY `no` DESC");
        if($res->num_rows)
        {
            $resps= $res->num_rows;
        }
        $repo =queryMysql("SELECT * FROM `post` WHERE username='$usr' ORDER BY `post no` DESC");
        if($repo->num_rows)
        {
            $posts= $repo->num_rows;
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
                <div id="cnt1000">
                    <fieldset id="pro100">
                        <div id="align100">   
                            <div id="photo301">
                                <?php 
                                    if (file_exists("uploads/$usr.jpg"))
                                    echo "<img id='photo301' src='uploads/$usr.jpg'>";
                                    else echo "<span id='pho400'>No Profile pic</span>";
                                ?>
                            </div>
                            <div id="bt100">
                                <?php
                                    if($usr!=$user)
                                    {
                                        $sp= queryMysql("SELECT * FROM `sponsor` WHERE `username`='$user' AND `sponsored`='$usr'");
                                        if($sp->num_rows)
                                        {
                                            echo '<button id="bt101" class="ui-btn" name="unfollow" value="'.$usr.'" onClick="unfollow(this)">Sponsored</button>';
                                        }
                                        else{
                                            echo '<button id="bt101" class="ui-btn" name="sponsor" value="'.$usr.'" onClick="sponsor(this)">Sponsor</button>';
                                        }
                                    }
                                ?>
                            </div>
                            <div id="nam100">
                                <?php 
                                    $verify="";
                                    $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                                    if($m->num_rows)
                                    {
                                        $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$user'");
                                        if($av->num_rows)
                                        {$verify="<span id='verified'>&#2714;</span>";}
                                        else
                                        {$verify="<span id='veri'>&#x2714;</span>";}
                                    }
                                    if($rep->num_rows)
                                    {
                                ?>
                                <p class="nam101"><b style="font-size:23px;"><?php echo ucfirst($profile['first name']).'&nbsp;&nbsp;'.ucfirst($profile['surname']).'&nbsp;'.$verify;?></b></p>
                            </div>
                            <div id="gen100"><p id="gen101"><?php echo $profile['gender']?></p></div>
                            <div id="count500">
                                <?php
                                    $co=queryMysql("SELECT * FROM `profile count` WHERE `username`='$usr'");
                                    $count=$co->fetch_array(MYSQLI_ASSOC);
                                    echo '<div id="pc500">Profile Visit &nbsp;:&nbsp;'.$count['profile visit'].'</div>';
                                    echo '<div id="poc500">Notes View &nbsp;:&nbsp;'.($count['post view']+$count['research view']+$count['issue view']).'</div>';
                                    $spc=queryMysql("SELECT * FROM `sponsor` WHERE `sponsored`='$usr'");
                                    $spcn=$spc->num_rows;
                                    echo '<div id="spc500">Total Sponsor &nbsp;:&nbsp;<span id="tc90">'.$spcn.'</span></div>'; 
                                ?>
                            </div>
                            <div id="loc200"><!--original location -->
                                <div id="loc201"><p><b style="font-size:23px;">From:</b></p></div>
                                <div id="loc202">
                                    <p class="loc202"><?php echo ucfirst($profile['city']).'&nbsp;&nbsp;'.ucfirst($profile['state']).'&nbsp;&nbsp;'.ucfirst($profile['country']);?></p>
                                </div>
                            </div><?php }if($rel->num_rows){?>
                            <div id="cloc200"><!--current location -->
                                <div id="cloc201"><p><b style="font-size:23px;">Living In:</b></p></div>
                                <div id="cloc202">
                                    <?php if((($cloc['address'])!="")&&(($cloc['zip'])!=0)){ ?><p class="cloc202"><?php if(($cloc['address'])!=""){echo ucfirst($cloc['address']);}?><br><?php if(($cloc['zip'])!=0){echo ucfirst($cloc['zip']);}?></p><?php }?>
                                    <p class="cloc202"><?php echo ucfirst($cloc['city']).'&nbsp;&nbsp;'.ucfirst($cloc['state']).'&nbsp;&nbsp;'.ucfirst($cloc['country']);?></p>
                                </div>
                            </div> <?php } if($red->num_rows){?>
                            <div id="edu100"><!--Education -->
                                <div id="edu101"><p id="edu102"><b style="font-size:23px;">Education:</b></p></div>
                                <div id="edu201">
                                    <p id="edu202">
                                        <?php
                                            if(($edu['phd'])!=""){echo 'Phd :'.ucfirst($edu['phd']).'<br>';}
                                            if(($edu['master'])!=""){echo 'Master :'.ucfirst($edu['master']).'<br>';}
                                            if(($edu['graduation'])!=""){echo 'Graduation :'.ucfirst($edu['graduation']).'<br>';}
                                            if(($edu['hsc'])!=""){echo 'HSC :'.ucfirst($edu['hsc']).'<br>';}
                                            if(($edu['ssc'])!=""){echo 'SSC :'.ucfirst($edu['ssc']).'<br>';}
                                            if($edu['achievementE']!="")
                                            {
                                                $ach=explode(",",$edu['achievementE']);
                                                if($ach)
                                                {foreach($ach as $key=>$value)
                                                echo "Achievement:&nbsp;&nbsp;". ucfirst($value)."<br>";}
                                                else{
                                                    echo "Achievement:&nbsp;&nbsp;". ucfirst($edu['achievementE'])."<br>";
                                                }
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div> <?php } if($rew->num_rows){?>
                            <div id="wr100"><!--Work-->
                                <div id="wr101"><p id="wr102"><b style="font-size:23px;">Work:</b></p></div>
                                <div id="wr201">
                                    <p id="wr202">
                                        <?php
                                            if(($work['curcomp'])!=""){echo 'Current Company :'.ucfirst($work['curcomp']).'<br>';}
                                            if(($work['crole'])!=""){echo 'Current Role :'.ucfirst($work['crole']).'<br>';}
                                            if(($work['cexp'])!=0){echo 'Current Exp :'.ucfirst($work['cexp']).'year<br>';}
                                            if(($work['precomp'])!=""){echo 'Previous Company :'.ucfirst($work['precomp']).'<br>';}
                                            if(($work['prole'])!=""){echo 'Previous Role :'.ucfirst($work['prole']).'<br>';}
                                            if(($work['cexp'])!=0){echo 'Previous Exp :'.ucfirst($work['pexp']).'year<br>';}
                                            if($work['achievement']!="")
                                            {
                                                $ach=explode(",",$work['achievement']);
                                                if($ach)
                                                {foreach($ach as $key=>$value)
                                                echo "Achievement:&nbsp;&nbsp;". ucfirst($value)."<br>";}
                                                else{
                                                    echo "Achievement:&nbsp;&nbsp;". ucfirst($work['achievement'])."<br>";
                                                }
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div> <?php }?>
                        </div>
                    </fieldset>
                    <div id="pos100">
                            <?php 
                                $cou=queryMysql("SELECT * FROM `course title` WHERE `username`='$usr'");
                                if($cou->num_rows)
                                {
                                    echo '<p id="crc200">Courses</p>';
                                    echo '<div id="cour100" style="display:grid;">';
                                    for($j=0; $j<($cou->num_rows);++$j)
                                    {
                                        $ctc=$cou->fetch_array(MYSQLI_ASSOC);
                                        $cno=$ctc['course no'];
                                        echo '<div class="ctc900"><button class="ctc901" value="'.$cno.'"name="course" onClick="content3(this)">'.$ctc['course title'].'</button></div>';
                                    }
                                    echo '</div>';
                                    echo '<div id="content1" style="display:none;">&nbsp;</div>';
                                }
                            ?>
                            <div id="post100" style="display:block;"><!--post-->
                                <?php 
                                    if($repo->num_rows)
                                    {
                                        for ($j = 0 ; $j < $posts ; ++$j)
                                        {
                                            $post=$repo->fetch_array(MYSQLI_ASSOC);
                                            $usr=$post['username'];
                                            $pno=$post['post no'];
                                            $copy=queryMysql("SELECT * FROM `copyright notes` WHERE `notes no`='$pno'");
                                            if($copy->num_rows)
                                            {
                                                continue;
                                            }
                                            $repos= queryMysql("SELECT * FROM `courses` WHERE `post no`='$pno'");
                                            if($repos->num_rows)
                                            {
                                                continue;
                                            }
                                            echo '<div class="in500"><b>Notes No.'. $post['post no'].'</b>'.'&nbsp;&nbsp;'.'</a>&nbsp;&nbsp;<span class="available">';
                                            echo timeAgo(strtotime($post['posting time'])).'</span></div>';
                                            echo '<div class="it500"><a href=postcmnt.php?content='.$post['post no'].'>'.ucfirst($post['title']).'</a></div>';
                                            echo '<div class="des400">'.ucfirst($post['metadescription']).'</div>';
                                            echo '<div class="des500">Source : '.ucfirst($post['source']).'</div>';
                                        }
                                    }
                                ?>
                            </div>
                            <?php 
                                /*ad logic*/
                                $adchoicee=queryMysql("SELECT * FROM `profiles` WHERE `username`='$user'");
                                if($adchoicee->num_rows)
                                {
                                    $adchoice=$adchoicee->fetch_array(MYSQLI_ASSOC);
                                    $adc=$adchoice['ads'];
                                    if(($adc=="yes") || ($adc=="all"))
                                    {
                                        $ad=queryMysql("SELECT `education`, `property`, `electronics`, `fashion`, `food`, `jobs`, `ticket`, `hotel`, `hospital`, `pharmacy`, `cars`, `cabs`, `artist`, `entertainment`, `grocery`, `astrology`, `marketing`, `everything` FROM `adchoice` WHERE `username`='$user'");
                                        if($ad->num_rows)
                                        {
                                            $ads=$ad->fetch_array(MYSQLI_ASSOC);
                                            $ev=$ads['everything'];
                                            if($ev=="yes")
                                            {
                                                $rand=rand(1,18);
                                                switch($rand)
                                                {
                                                    case '1': $category= "education";
                                                    break;
                                                    case '2': $category= "property";
                                                    break;
                                                    case '3': $category= "electronics";
                                                    break;
                                                    case '4': $category= "fashion";
                                                    break;
                                                    case '5': $category= "food";
                                                    break;
                                                    case '6': $category= "jobs";
                                                    break;
                                                    case '7': $category= "ticket";
                                                    break;
                                                    case '8': $category= "hotel";
                                                    break;
                                                    case '9': $category= "hospital";
                                                    break;
                                                    case '10': $category= "pharmacy";
                                                    break;
                                                    case '11': $category= "cars";
                                                    break;
                                                    case '12': $category= "cabs";
                                                    break;
                                                    case '13': $category= "artist";
                                                    break;
                                                    case '14': $category= "entertainment";
                                                    break;
                                                    case '15': $category= "grocery";
                                                    break;
                                                    case '16': $category= "astrology";
                                                    break;
                                                    case '17': $category= "marketing";
                                                    break;
                                                    case '18': $category= "other";
                                                    break;
                                                    default : $category="";
                                                    break;
                                                }
                                                $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                if($rad->num_rows)
                                                {
                                                    for($j=0; $j <($rad->num_rows);++$j)
                                                    {
                                                        $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                        $a[$j]=$rads['ad no'];
                                                    }
                                                    $len=count($a);
                                                    $random= rand(1,$len);
                                                    $ano=$a[$random-1];
                                                    $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                    if($report->num_rows)
                                                    {$ano=0;}
                                                    $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                    if($adss->num_rows)
                                                    {
                                                        $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                        $am=$adds['amount'];
                                                        if($am==0)/*$am!=0 */
                                                        {
                                                            $day=$adds['no of days'];
                                                            $strt=$adds['ad start date'];
                                                            $src=$adds['video'];
                                                            $tm=strtotime($strt);
                                                            $tmago= timeAgoo($tm);
                                                            if($tmago<=$day)
                                                            {
                                                                $view=$adds['video views'];
                                                                $vi=$view+1;
                                                                if(($adds['username'])!=$user)
                                                                {
                                                                    queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                    $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                    if(($up->num_rows)==0)
                                                                    {
                                                                        queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                    }
                                                                    $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                    $unipro=$uniprof->num_rows;
                                                                    queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                    $src=$adds['video'];
                                                                    if (file_exists($src))
                                                                    {
                                                                        echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                        echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                        echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                        if(($adds['website url'])!="")
                                                                        {
                                                                            $url=$adds['website url'];
                                                                            echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                        }
                                                                        echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                @unlink($src);
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $rand=rand(1,18);
                                                    switch($rand)
                                                    {
                                                        case '1': $category= "education";
                                                        break;
                                                        case '2': $category= "property";
                                                        break;
                                                        case '3': $category= "electronics";
                                                        break;
                                                        case '4': $category= "fashion";
                                                        break;
                                                        case '5': $category= "food";
                                                        break;
                                                        case '6': $category= "jobs";
                                                        break;
                                                        case '7': $category= "ticket";
                                                        break;
                                                        case '8': $category= "hotel";
                                                        break;
                                                        case '9': $category= "hospital";
                                                        break;
                                                        case '10': $category= "pharmacy";
                                                        break;
                                                        case '11': $category= "cars";
                                                        break;
                                                        case '12': $category= "cabs";
                                                        break;
                                                        case '13': $category= "artist";
                                                        break;
                                                        case '14': $category= "entertainment";
                                                        break;
                                                        case '15': $category= "grocery";
                                                        break;
                                                        case '16': $category= "astrology";
                                                        break;
                                                        case '17': $category= "marketing";
                                                        break;
                                                        case '18': $category= "other";
                                                        break;
                                                        default : $category="";
                                                        break;
                                                    }
                                                    $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                    if($rad->num_rows)
                                                    {
                                                        for($j=0; $j <($rad->num_rows);++$j)
                                                        {
                                                            $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                            $a[$j]=$rads['ad no'];
                                                        }
                                                        $len=count($a);
                                                        $random= rand(1,$len);
                                                        $ano=$a[$random-1];
                                                        $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                        if($report->num_rows)
                                                        {$ano=0;}
                                                        $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                        if($adss->num_rows)
                                                        {
                                                            $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                            $am=$adds['amount'];
                                                            if($am!=0)
                                                            {
                                                                $day=$adds['no of days'];
                                                                $strt=$adds['ad start date'];
                                                                $src=$adds['video'];
                                                                $tm=strtotime($strt);
                                                                $tmago= timeAgoo($tm);
                                                                if($tmago<=$day)
                                                                {
                                                                    $view=$adds['video views'];
                                                                    $vi=$view+1;
                                                                    if(($adds['username'])!=$user)
                                                                    {
                                                                        queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                        $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                        if(($up->num_rows)==0)
                                                                        {
                                                                            queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                        }
                                                                        $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                        $unipro=$uniprof->num_rows;
                                                                        queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                        $src=$adds['video'];
                                                                        if (file_exists($src))
                                                                        {
                                                                            echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                            echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                            echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                            if(($adds['website url'])!="")
                                                                            {
                                                                                $url=$adds['website url'];
                                                                                echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                            }
                                                                            echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            else{
                                                foreach($ads as $key=>$value)
                                                {
                                                    if($value=="yes")
                                                    {
                                                        $b[$c]=$key;
                                                        ++$c;
                                                    }
                                                }
                                                $length=count($b);
                                                $rand=rand(1,$length);
                                                $category=$b[$rand-1];
                                                $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                if($rad->num_rows)
                                                {
                                                    for($j=0; $j <($rad->num_rows);++$j)
                                                    {
                                                        $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                        $a[$j]=$rads['ad no'];
                                                    }
                                                    $len=count($a);
                                                    $random= rand(1,$len);
                                                    $ano=$a[$random-1];
                                                    $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                    if($report->num_rows)
                                                    {$ano=0;}
                                                    $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                    if($adss->num_rows)
                                                    {
                                                        $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                        $am=$adds['amount'];
                                                        if($am==0)/*$am!=0*/
                                                        {
                                                            $day=$adds['no of days'];
                                                            $strt=$adds['ad start date'];
                                                            $src=$adds['video'];
                                                            $tm=strtotime($strt);
                                                            $tmago= timeAgoo($tm);
                                                            if($tmago<=$day)
                                                            {
                                                                $view=$adds['video views'];
                                                                $vi=$view+1;
                                                                if(($adds['username'])!=$user)
                                                                {
                                                                    queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                    $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                    if(($up->num_rows)==0)
                                                                    {
                                                                        queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                    }
                                                                    $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                    $unipro=$uniprof->num_rows;
                                                                    queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                    $src=$adds['video'];
                                                                    if (file_exists($src))
                                                                    {
                                                                        echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                        echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                        echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                        if(($adds['website url'])!="")
                                                                        {
                                                                            $url=$adds['website url'];
                                                                            echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                        }
                                                                        echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                @unlink($src);
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $length=count($b);
                                                    $rand=rand(1,$length);
                                                    $category=$b[$rand-1];
                                                    $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                    if($rad->num_rows)
                                                    {
                                                        for($j=0; $j <($rad->num_rows);++$j)
                                                        {
                                                            $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                            $a[$j]=$rads['ad no'];
                                                        }
                                                        $len=count($a);
                                                        $random= rand(1,$len);
                                                        $ano=$a[$random-1];
                                                        $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                        if($report->num_rows)
                                                        {$ano=0;}
                                                        $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                        if($adss->num_rows)
                                                        {
                                                            $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                            $am=$adds['amount'];
                                                            if($am==0)/*$am!=0 */
                                                            {
                                                                $day=$adds['no of days'];
                                                                $strt=$adds['ad start date'];
                                                                $src=$adds['video'];
                                                                $tm=strtotime($strt);
                                                                $tmago= timeAgoo($tm);
                                                                if($tmago<=$day)
                                                                {
                                                                    $view=$adds['video views'];
                                                                    $vi=$view+1;
                                                                    if(($adds['username'])!=$user)
                                                                    {
                                                                        queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                        $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                        if(($up->num_rows)==0)
                                                                        {
                                                                            queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                        }
                                                                        $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                        $unipro=$uniprof->num_rows;
                                                                        queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                        $src=$adds['video'];
                                                                        if (file_exists($src))
                                                                        {
                                                                            echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                            echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                            echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                            if(($adds['website url'])!="")
                                                                            {
                                                                                $url=$adds['website url'];
                                                                                echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                            }
                                                                            echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                    @unlink($src);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
                            <div id="resrch100" style="display:block;"><!-- research-->
                                <?php 
                                    if($res->num_rows)
                                    { 
                                        for ($j = 0 ; $j < $resps ; ++$j)
                                        {
                                            $rq= $res->fetch_array(MYSQLI_ASSOC);
                                            $it= $rq['no'];
                                            $copy=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$it'");
                                            if($copy->num_rows)
                                            {
                                                continue;
                                            }
                                            echo '<div class="in500"><b>Research Paper.'. $rq['no'].'</b>'.'&nbsp;&nbsp;'.'<span class="available">';
                                            echo timeAgo(strtotime($rq['posting time'])).'</span></div>';
                                            echo '<div class="it500"><a href="yourrdcmnt.php?content='.$it.'">'. ucfirst($rq['title']).'</a></div>';
                                            echo '<div class="des500"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($rq['introduction']).'</div>';
                                        }
                                    }
                                ?>
                            </div>
                            <?php 
                                /*ad logic*/
                                $adchoicee=queryMysql("SELECT * FROM `profiles` WHERE `username`='$user'");
                                if($adchoicee->num_rows)
                                {
                                    $adchoice=$adchoicee->fetch_array(MYSQLI_ASSOC);
                                    $adc=$adchoice['ads'];
                                    if(($adc=="yes") || ($adc=="all"))
                                    {
                                        $ad=queryMysql("SELECT `education`, `property`, `electronics`, `fashion`, `food`, `jobs`, `ticket`, `hotel`, `hospital`, `pharmacy`, `cars`, `cabs`, `artist`, `entertainment`, `grocery`, `astrology`, `marketing`, `everything` FROM `adchoice` WHERE `username`='$user'");
                                        if($ad->num_rows)
                                        {
                                            $ads=$ad->fetch_array(MYSQLI_ASSOC);
                                            $ev=$ads['everything'];
                                            if($ev=="yes")
                                            {
                                                $rand=rand(1,18);
                                                switch($rand)
                                                {
                                                    case '1': $category= "education";
                                                    break;
                                                    case '2': $category= "property";
                                                    break;
                                                    case '3': $category= "electronics";
                                                    break;
                                                    case '4': $category= "fashion";
                                                    break;
                                                    case '5': $category= "food";
                                                    break;
                                                    case '6': $category= "jobs";
                                                    break;
                                                    case '7': $category= "ticket";
                                                    break;
                                                    case '8': $category= "hotel";
                                                    break;
                                                    case '9': $category= "hospital";
                                                    break;
                                                    case '10': $category= "pharmacy";
                                                    break;
                                                    case '11': $category= "cars";
                                                    break;
                                                    case '12': $category= "cabs";
                                                    break;
                                                    case '13': $category= "artist";
                                                    break;
                                                    case '14': $category= "entertainment";
                                                    break;
                                                    case '15': $category= "grocery";
                                                    break;
                                                    case '16': $category= "astrology";
                                                    break;
                                                    case '17': $category= "marketing";
                                                    break;
                                                    case '18': $category= "other";
                                                    break;
                                                    default : $category="";
                                                    break;
                                                }
                                                $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                if($rad->num_rows)
                                                {
                                                    for($j=0; $j <($rad->num_rows);++$j)
                                                    {
                                                        $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                        $a[$j]=$rads['ad no'];
                                                    }
                                                    $len=count($a);
                                                    $random= rand(1,$len);
                                                    $ano=$a[$random-1];
                                                    $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                    if($report->num_rows)
                                                    {$ano=0;}
                                                    $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                    if($adss->num_rows)
                                                    {
                                                        $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                        $am=$adds['amount'];
                                                        if($am==0)/*$am!=0 */
                                                        {
                                                            $day=$adds['no of days'];
                                                            $strt=$adds['ad start date'];
                                                            $src=$adds['video'];
                                                            $tm=strtotime($strt);
                                                            $tmago= timeAgoo($tm);
                                                            if($tmago<=$day)
                                                            {
                                                                $view=$adds['video views'];
                                                                $vi=$view+1;
                                                                if(($adds['username'])!=$user)
                                                                {
                                                                    queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                    $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                    if(($up->num_rows)==0)
                                                                    {
                                                                        queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                    }
                                                                    $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                    $unipro=$uniprof->num_rows;
                                                                    queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                    $src=$adds['video'];
                                                                    if (file_exists($src))
                                                                    {
                                                                        echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                        echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                        echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                        if(($adds['website url'])!="")
                                                                        {
                                                                            $url=$adds['website url'];
                                                                            echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                        }
                                                                        echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                @unlink($src);
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $rand=rand(1,18);
                                                    switch($rand)
                                                    {
                                                        case '1': $category= "education";
                                                        break;
                                                        case '2': $category= "property";
                                                        break;
                                                        case '3': $category= "electronics";
                                                        break;
                                                        case '4': $category= "fashion";
                                                        break;
                                                        case '5': $category= "food";
                                                        break;
                                                        case '6': $category= "jobs";
                                                        break;
                                                        case '7': $category= "ticket";
                                                        break;
                                                        case '8': $category= "hotel";
                                                        break;
                                                        case '9': $category= "hospital";
                                                        break;
                                                        case '10': $category= "pharmacy";
                                                        break;
                                                        case '11': $category= "cars";
                                                        break;
                                                        case '12': $category= "cabs";
                                                        break;
                                                        case '13': $category= "artist";
                                                        break;
                                                        case '14': $category= "entertainment";
                                                        break;
                                                        case '15': $category= "grocery";
                                                        break;
                                                        case '16': $category= "astrology";
                                                        break;
                                                        case '17': $category= "marketing";
                                                        break;
                                                        case '18': $category= "other";
                                                        break;
                                                        default : $category="";
                                                        break;
                                                    }
                                                    $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                    if($rad->num_rows)
                                                    {
                                                        for($j=0; $j <($rad->num_rows);++$j)
                                                        {
                                                            $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                            $a[$j]=$rads['ad no'];
                                                        }
                                                        $len=count($a);
                                                        $random= rand(1,$len);
                                                        $ano=$a[$random-1];
                                                        $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                        if($report->num_rows)
                                                        {$ano=0;}
                                                        $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                        if($adss->num_rows)
                                                        {
                                                            $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                            $am=$adds['amount'];
                                                            if($am!=0)
                                                            {
                                                                $day=$adds['no of days'];
                                                                $strt=$adds['ad start date'];
                                                                $src=$adds['video'];
                                                                $tm=strtotime($strt);
                                                                $tmago= timeAgoo($tm);
                                                                if($tmago<=$day)
                                                                {
                                                                    $view=$adds['video views'];
                                                                    $vi=$view+1;
                                                                    if(($adds['username'])!=$user)
                                                                    {
                                                                        queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                        $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                        if(($up->num_rows)==0)
                                                                        {
                                                                            queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                        }
                                                                        $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                        $unipro=$uniprof->num_rows;
                                                                        queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                        $src=$adds['video'];
                                                                        if (file_exists($src))
                                                                        {
                                                                            echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                            echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                            echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                            if(($adds['website url'])!="")
                                                                            {
                                                                                $url=$adds['website url'];
                                                                                echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                            }
                                                                            echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            else{
                                                foreach($ads as $key=>$value)
                                                {
                                                    if($value=="yes")
                                                    {
                                                        $b[$c]=$key;
                                                        ++$c;
                                                    }
                                                }
                                                $length=count($b);
                                                $rand=rand(1,$length);
                                                $category=$b[$rand-1];
                                                $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                if($rad->num_rows)
                                                {
                                                    for($j=0; $j <($rad->num_rows);++$j)
                                                    {
                                                        $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                        $a[$j]=$rads['ad no'];
                                                    }
                                                    $len=count($a);
                                                    $random= rand(1,$len);
                                                    $ano=$a[$random-1];
                                                    $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                    if($report->num_rows)
                                                    {$ano=0;}
                                                    $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                    if($adss->num_rows)
                                                    {
                                                        $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                        $am=$adds['amount'];
                                                        if($am==0)/*$am!=0*/
                                                        {
                                                            $day=$adds['no of days'];
                                                            $strt=$adds['ad start date'];
                                                            $src=$adds['video'];
                                                            $tm=strtotime($strt);
                                                            $tmago= timeAgoo($tm);
                                                            if($tmago<=$day)
                                                            {
                                                                $view=$adds['video views'];
                                                                $vi=$view+1;
                                                                if(($adds['username'])!=$user)
                                                                {
                                                                    queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                    $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                    if(($up->num_rows)==0)
                                                                    {
                                                                        queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                    }
                                                                    $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                    $unipro=$uniprof->num_rows;
                                                                    queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                    $src=$adds['video'];
                                                                    if (file_exists($src))
                                                                    {
                                                                        echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                        echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                        echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                        if(($adds['website url'])!="")
                                                                        {
                                                                            $url=$adds['website url'];
                                                                            echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                        }
                                                                        echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                    }
                                                                }
                                                            }
                                                            else{
                                                                queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                @unlink($src);
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $length=count($b);
                                                    $rand=rand(1,$length);
                                                    $category=$b[$rand-1];
                                                    $rad=queryMysql("SELECT * FROM `create ad` WHERE `category`='$category' AND `status`=0");
                                                    if($rad->num_rows)
                                                    {
                                                        for($j=0; $j <($rad->num_rows);++$j)
                                                        {
                                                            $rads=$rad->fetch_array(MYSQLI_ASSOC);
                                                            $a[$j]=$rads['ad no'];
                                                        }
                                                        $len=count($a);
                                                        $random= rand(1,$len);
                                                        $ano=$a[$random-1];
                                                        $report=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$ano'");
                                                        if($report->num_rows)
                                                        {$ano=0;}
                                                        $adss=queryMysql("SELECT * FROM `create ad` WHERE `ad no`='$ano' AND `status`=0");
                                                        if($adss->num_rows)
                                                        {
                                                            $adds=$adss->fetch_array(MYSQLI_ASSOC);
                                                            $am=$adds['amount'];
                                                            if($am==0)/*$am!=0 */
                                                            {
                                                                $day=$adds['no of days'];
                                                                $strt=$adds['ad start date'];
                                                                $src=$adds['video'];
                                                                $tm=strtotime($strt);
                                                                $tmago= timeAgoo($tm);
                                                                if($tmago<=$day)
                                                                {
                                                                    $view=$adds['video views'];
                                                                    $vi=$view+1;
                                                                    if(($adds['username'])!=$user)
                                                                    {
                                                                        queryMysql("UPDATE `create ad` SET `video views`='$vi' WHERE `ad no`='$ano'");
                                                                        $up=queryMysql("SELECT * FROM `create ad people watched` WHERE `username`='$user' AND `ad no`='$ano'");
                                                                        if(($up->num_rows)==0)
                                                                        {
                                                                            queryMysql("INSERT INTO `create ad people watched`( `username`, `ad no`, `watched date`) VALUES ('$user','$ano',NOW())");
                                                                        }
                                                                        $uniprof=queryMysql("SELECT * FROM `create ad people watched` WHERE `ad no`='$ano'");
                                                                        $unipro=$uniprof->num_rows;
                                                                        queryMysql("UPDATE `create ad` SET `people watched`='$unipro' WHERE `ad no`='$ano'");
                                                                        $src=$adds['video'];
                                                                        if (file_exists($src))
                                                                        {
                                                                            echo '<div class="vtit129">'.$adds['video title'].'</div>';
                                                                            echo '<video class="advideo" src="'.$src.'"muted autoplay controls loop></video>';
                                                                            echo '<div class="vdes129">'.ucfirst($adds['video description']).'</div>';
                                                                            if(($adds['website url'])!="")
                                                                            {
                                                                                $url=$adds['website url'];
                                                                                echo '<button class="bc90" name="vurl" value="'.$ano.'" onClick="urlV(this)"><a class="vurl129" href="'.$url.'">'.$url.'</a></button>';
                                                                            }
                                                                            echo '<button class="repad" name="repad" onClick="reportAd(this)" value="'.$ano.'">Report Ad</button>';
                                                                        }
                                                                    }
                                                                }
                                                                else{
                                                                    queryMysql("UPDATE `create ad` SET `status`='1' WHERE `ad no`='$ano'");
                                                                    @unlink($src);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            ?>
                            <div id="requi100" style="display:block;"><!-- issue -->
                                <?php 
                                    if($req->num_rows)
                                    { 
                                        for ($j = 0 ; $j < $rqs ; ++$j)
                                        {
                                            $rq= $req->fetch_array(MYSQLI_ASSOC);
                                            $it= $rq['issue no'];
                                            $time =$rq['posting time'];
                                            echo '<div class="in500"><b>Issue No.'. $rq['issue no'].'</b>'.'&nbsp;&nbsp;'.'<span class="available">';
                                            echo timeAgo(strtotime($time)).'</span></div>';
                                            echo '<div class="it500"><a href="yourrequirecmnt.php?content='.$it.'">'. $rq['issue'].'</a></div>';
                                            echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.$rq['description'].'</div>';
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