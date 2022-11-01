<?php
    if(!$loggedin)
    {
        die(header('location:index.php'));
    }
?>
<div id="cont01">
    <div id="left06">
        <div id="pad06" class="ui-field-contain">
            <form data-ajax="false" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" id="c06" enctype="multipart/form-data"> 
                <label for="tit06" class="ui-hidden-accessible"></label><input type="text" aria-label="title" name="title" class="input" id="tit06" placeholder="Title *" maxlength="110" required>
                <label for="meta06" class="ui-hidden-accessible"></label><input type="text" aria-label="describe your notes" name="metadescription" class="input" id="meta06" placeholder="Metadescription *" maxlength="200" required>
                <label for="note06" class="ui-hidden-accessible"></label><textarea name="notes" aria-label="notes" class="input" id="note06" cols="50" rows="10" placeholder="Notes *" required></textarea>
                <label for="sour06" class="ui-hidden-accessible"></label><textarea name="source" aria-label="source of notes" class="input" id="sour06" cols="50" rows="10"  placeholder="Source/Book reference *"  required></textarea>
                <button id="b10" data-role="ui-btn ui-btn-inline " name="publish" class="ui-btn" aria-label="publish" data-icon="comment" type="submit">Publish</button>
            </form>
            <div id="showpost">
                <button id="showpost2" aria-label="your notes" onClick="showpost()">Your Notes </button>
            </div>
        </div>
    </div>
    <div id="rt06">
        <div id="post900" style="display:block;">
            <?php
                $pno=$rno=$ino=$c=0;
                $a=$b=$p=$r=$i=array();
                /*recent post*/
                $rcnt= queryMysql("SELECT * FROM `sponsor` WHERE `username`='$user' ORDER BY `posting time` DESC");
                if($rcnt->num_rows)
                {
                    $rw=$rcnt->num_rows;
                    for ($j = 0 ; $j < $rw ; ++$j)
                    {
                        $rws=$rcnt->fetch_array(MYSQLI_ASSOC);
                        $pno=$rws['post no'];
                        $p[$j]=$pno;
                        if($pno==0)
                        {
                            $rno=$rws['research no'];
                            if($rno==0)
                            {
                                $ino=$rws['issue no'];
                                if($ino==0)
                                continue;
                                $prcnt=queryMysql("SELECT * FROM `requirement` WHERE `issue no`='$ino'");
                                if($prcnt->num_rows)
                                {
                                    $rpost=$prcnt->fetch_array(MYSQLI_ASSOC);
                                    $it= $rpost['issue no'];
                                    $time =$rpost['posting time'];
                                    echo '<div class="in500"><b>Issue No.'. $rpost['issue no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$rpost['username'].'">'.$rpost['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                    echo timeAgo(strtotime($time)).'</span></div>';
                                    echo '<div class="it500"><a href="yourrequirecmnt.php?content='.$it.'">'. $rpost['issue'].'</a></div>';
                                    echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.$rpost['description'].'</div>';
                                }
                                
                            }
                            else
                            {
                                $prcnt=queryMysql("SELECT * FROM `research paper` WHERE `no`='$rno'");
                                if($prcnt->num_rows)
                                {
                                    $rpost=$prcnt->fetch_array(MYSQLI_ASSOC);
                                    $it= $rpost['no'];
                                    $usr=$rpost['username'];
                                    $cop=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$it'");
                                    if($cop->num_rows)
                                    {
                                        continue;
                                    }
                                    echo '<div class="in500"><b>Research Paper.'. $rpost['no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$rpost['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                    echo timeAgo(strtotime($rpost['posting time'])).'</span></div>';
                                    echo '<div class="it500"><a href="yourrdcmnt.php?content='.$it.'">'. ucfirst($rpost['title']).'</a></div>';
                                    echo '<div class="des500"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($rpost['introduction']).'</div>';
                                }
                            }
                        }else{
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
                            $prcnt=queryMysql("SELECT * FROM `post` WHERE `post no`='$pno'");
                            if($prcnt->num_rows)
                            {
                                $rpost=$prcnt->fetch_array(MYSQLI_ASSOC);
                                $usr=$rpost['username'];
                                echo '<div class="in500"><b>Notes No.'. $rpost['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$rpost['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                echo timeAgo(strtotime($rpost['posting time'])).'</span></div>';
                                echo '<div class="it500"><a href=postcmnt.php?content='.$rpost['post no'].'>'.ucfirst($rpost['title']).'</a></div>';
                                echo '<div class="des500">'.ucfirst($rpost['metadescription']).'</div>';
                            }
                        }
                    }
                }
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
                /* recent research 
                $rcnt= queryMysql("SELECT * FROM `sponsor` WHERE `username`='$user' ORDER BY `posting time` DESC");
                if($rcnt->num_rows)
                {
                    $rw=$rcnt->num_rows;
                    for ($j = 0 ; $j < $rw ; ++$j)
                    {
                        $rws=$rcnt->fetch_array(MYSQLI_ASSOC);
                        $rno=$rws['research no'];
                        $r[$j]=$rno;
                        if($rno==0)
                        continue;
                        $prcnt=queryMysql("SELECT * FROM `research paper` WHERE `no`='$rno'");
                        if($prcnt->num_rows)
                        {
                            $rpost=$prcnt->fetch_array(MYSQLI_ASSOC);
                            $it= $rpost['no'];
                            $usr=$rpost['username'];
                            echo '<div class="in500"><b>Research Paper.'. $rpost['no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$rpost['username'].'</a>&nbsp;&nbsp;<span class="available">';
                            echo timeAgo(strtotime($rpost['posting time'])).'</span></div>';
                            echo '<div class="it500"><a href="yourrdcmnt.php?content='.$it.'">'. ucfirst($rpost['title']).'</a></div>';
                            echo '<div class="des500"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($rpost['introduction']).'</div>';
                        }
                    }
                }
                /* recent issue 
                $rcnt= queryMysql("SELECT * FROM `sponsor` WHERE `username`='$user' ORDER BY `posting time` DESC");
                if($rcnt->num_rows)
                {
                    $rw=$rcnt->num_rows;
                    for ($j = 0 ; $j < $rw ; ++$j)
                    {
                        $rws=$rcnt->fetch_array(MYSQLI_ASSOC);
                        $ino=$rws['issue no'];
                        $i[$j]=$ino;
                        if($ino==0)
                        continue;
                        $usr=$rpost['username'];
                        $prcnt=queryMysql("SELECT * FROM `requirement` WHERE `issue no`='$ino'");
                        if($prcnt->num_rows)
                        {
                            $rpost=$prcnt->fetch_array(MYSQLI_ASSOC);
                            $it= $rpost['issue no'];
                            $time =$rpost['posting time'];
                            echo '<div class="in500"><b>Issue No.'. $rpost['issue no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$rpost['username'].'</a>&nbsp;&nbsp;<span class="available">';
                            echo timeAgo(strtotime($time)).'</span></div>';
                            echo '<div class="it500"><a href="yourrequirecmnt.php?content='.$it.'">'. $rpost['issue'].'</a></div>';
                            echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.$rpost['description'].'</div>';
                        }
                    }
                }*/
                echo '<div id="blank555"></div>';
                $po= queryMysql("SELECT * FROM `post` WHERE `username`='$user' ORDER BY `post no` DESC");
                if($po->num_rows)
                {
                    /*$pos=$po->num_rows;
                    for ($j = 0 ; $j < $pos ; ++$j)
                    {*/
                        $post=$po->fetch_array(MYSQLI_ASSOC);
                        /*if($pno==$post['post no'])
                        continue;*/
                        $usr=$post['username'];
                        echo '<div class="in500"><b>Notes No.'. $post['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$post['username'].'</a>&nbsp;&nbsp;<span class="available">';
                        echo timeAgo(strtotime($post['posting time'])).'</span></div>';
                        echo '<div class="it500"><a href=postcmnt.php?content='.$post['post no'].'>'.ucfirst($post['title']).'</a></div>';
                        echo '<div class="des500">'.ucfirst($post['metadescription']).'</div>';
                    /*}*/
                }
                $spon=queryMysql("SELECT * FROM `sponsor` WHERE `username`='$user' ORDER BY `posting time` DESC");
                if($spon->num_rows)
                {
                    $spons=$spon->num_rows;
                    while($spons>0)
                    {
                        $sponsor=$spon->fetch_array(MYSQLI_ASSOC);
                        $usr=$sponsor['sponsored'];
                        $req =queryMysql("SELECT * FROM `requirement` WHERE username='$usr' ORDER BY `issue no` DESC");
                        if($req->num_rows)/*requirement*/
                        {
                            $rqs = $req->num_rows;
                            for ($j = 0 ; $j < $rqs ; ++$j)
                            {
                                $rq= $req->fetch_array(MYSQLI_ASSOC);
                                $it= $rq['issue no'];
                                if($ino==$rq['issue no'])
                                continue;
                                $time =$rq['posting time'];
                                echo '<div class="in500"><b>Issue No.'. $rq['issue no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$rq['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                echo timeAgo(strtotime($time)).'</span></div>';
                                echo '<div class="it500"><a href="yourrequirecmnt.php?content='.$it.'">'. $rq['issue'].'</a></div>';
                                echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.$rq['description'].'</div>';
                            }
                        }
                        $res =queryMysql("SELECT * FROM `research paper` WHERE username='$usr' ORDER BY `no` DESC");
                        if($res->num_rows)/*research paper*/
                        {
                            $resps= $res->num_rows;
                            for ($j = 0 ; $j < $resps ; ++$j)
                            {
                                $rq= $res->fetch_array(MYSQLI_ASSOC);
                                $it= $rq['no'];
                                $cop=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$it'");
                                if($cop->num_rows)
                                {
                                    continue;
                                }
                                if($rno==$rq['no'])
                                continue;
                                echo '<div class="in500"><b>Research Paper.'. $rq['no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$rq['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                echo timeAgo(strtotime($rq['posting time'])).'</span></div>';
                                echo '<div class="it500"><a href="yourrdcmnt.php?content='.$it.'">'. ucfirst($rq['title']).'</a></div>';
                                echo '<div class="des500"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($rq['introduction']).'</div>';
                            }
                        }
                        $po= queryMysql("SELECT * FROM `post` WHERE `username`='$usr' ORDER BY `post no` DESC");
                        if($po->num_rows)/*post*/
                        {
                            $pos=$po->num_rows;
                            for ($j = 0 ; $j < $pos ; ++$j)
                            {
                                $post=$po->fetch_array(MYSQLI_ASSOC);
                                if($pno==$post['post no'])
                                continue;
                                $pnoo=$post['post no'];
                                $cop=queryMysql("SELECT * FROM `copyright notes` WHERE `notes no`='$pnoo'");
                                if($cop->num_rows)
                                {
                                    continue;
                                }
                                $repos= queryMysql("SELECT * FROM `courses` WHERE `post no`='$pnoo'");
                                if($repos->num_rows)
                                {
                                    continue;
                                }
                                echo '<div class="in500"><b>Notes.'. $post['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$post['username'].'</a>&nbsp;&nbsp;<span class="available">';
                                echo timeAgo(strtotime($post['posting time'])).'</span></div>';
                                echo '<div class="it500"><a href=postcmnt.php?content='.$post['post no'].'>'.ucfirst($post['title']).'</a></div>';
                                echo '<div class="des500">'.ucfirst($post['metadescription']).'</div>';
                            }
                        }
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
                            --$spons;
                        }
                    }
            ?>
        </div>
        <div id="post901" style="display:none;">
            <?php 
                $po= queryMysql("SELECT * FROM `post` WHERE `username`='$user' ORDER BY `post no` DESC");
                if($po->num_rows)
                {
                    $pos=$po->num_rows;
                    for ($j = 0 ; $j < $pos ; ++$j)
                    {
                        $post=$po->fetch_array(MYSQLI_ASSOC);
                        if($pno==$post['post no'])
                        continue;
                        $usr=$post['username'];
                        echo '<div class="in500"><b>Notes No.'. $post['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$usr.'">'.$post['username'].'</a>&nbsp;&nbsp;<span class="available">';
                        echo timeAgo(strtotime($post['posting time'])).'</span></div>';
                        echo '<div class="it500"><a href=postcmnt.php?content='.$post['post no'].'>'.ucfirst($post['title']).'</a></div>';
                        echo '<div class="des500">'.ucfirst($post['metadescription']).'</div>';
                    }
                }
            ?>
        </div>
    </div>
</div>