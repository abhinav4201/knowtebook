<?php 
    session_start();
    require_once 'functions.php';
    $ct=array();
    if (isset($_POST['query']))
    {
        $query= sanitizeString($_POST['query']);
        $ccour=queryMysql("SELECT * FROM `course title` WHERE MATCH (`course title`) AGAINST ('$query')");
        if($ccour->num_rows)
        {
            for($j=0;$j<($ccour->num_rows);++$j)
            {
                $course=$ccour->fetch_array(MYSQLI_ASSOC);
                $cno=$course['course no'];
                $verify="";
                $usr= $course['username'];
                $ct=$course['course title'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                        {$verify="<span id='verified'>&#2714;</span>";}
                    else
                        {$verify="<span id='veri'>&#x2714;</span>";}
                }
                $pc=queryMysql("SELECT * FROM `purchased course count` WHERE `course no`='$cno'");
                if($pc->num_rows)
                {$cc=$pc->num_rows;}else{$cc=0;}
                echo '<div class="ccoo9">';
                echo '<div class="rtit01">'.ucfirst($course['course title']).'&nbsp;&rarr;&nbsp;<a href="member.php?content='.$course['username'].'">'.ucfirst($course['username']).'</a>&nbsp;'.$verify;
                echo '<br><br>&nbsp;&nbsp;Price&nbsp;: Rs'.$course['course price'];
                echo '&nbsp;&nbsp;<button class="addtocart" name="addtocart" value="'.$cno.'" onClick="addTo(this)">Buy</button>';
                echo '<br><br>&nbsp;Purchased count : '.$cc;
                echo '<br><br><button class="cont450" value="'.$j.'" name="cnt" onClick="content(this)">Content</button>';
                echo '<div id="cont123'.$j.'" style="display:none">';
                $con=queryMysql("SELECT * FROM `courses` WHERE `course title`='$ct'");
                if($con->num_rows)
                {
                    for($j=0;$j<($con->num_rows);++$j)
                    {
                        $cont=$con->fetch_array(MYSQLI_ASSOC);
                        $pono=$cont['post no'];
                        $conte=queryMysql("SELECT * FROM `post` WHERE `post no`='$pono'");
                        if($conte->num_rows)
                        {
                            $conten=$conte->fetch_array(MYSQLI_ASSOC);
                            $content=$conten['title'];
                            echo ($j+1).'&nbsp;'.ucfirst($content).'<br>';
                        }
                    }
                }
                echo '</div></div></div>';
            }
        }
        $resp= queryMysql("SELECT * FROM `post` WHERE MATCH (`username`,`title`,`metadescription`,`notes`,`source`) AGAINST ('$query')");
        if($resp->num_rows)
        {
            $resps=$resp->num_rows;
            for ($j=0; $j< $resps; ++$j)
            {
                $respo=$resp->fetch_array(MYSQLI_ASSOC);
                $pno=$respo['post no'];
                $cop=queryMysql("SELECT * FROM `copyright notes` WHERE `notes no`='$pno'");
                if($cop->num_rows)
                {
                    continue;
                }
                $co=queryMysql("SELECT * FROM `courses` WHERE `post no`='$pno'");
                if($co->num_rows)
                {
                    $cou=$co->fetch_array(MYSQLI_ASSOC);
                    $ctt=$cou['course title'];
                    /*$ct[$j]=$cou['course title'];
                    if($j>0)
                    {
                        if(($ct[$j])==($ct[$j-1]))
                        continue;
                    }*/
                    $cour=queryMysql("SELECT * FROM `course title` WHERE `course title`='$ctt'");
                    if($cour->num_rows)
                    {
                        $course=$cour->fetch_array(MYSQLI_ASSOC);
                        $cno=$course['course no'];
                        $ct=$course['course title'];
                        $verify="";
                        $usr= $course['username'];
                        $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                        if($m->num_rows)
                        {
                            $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                            if($av->num_rows)
                            {$verify="<span id='verified'>&#2714;</span>";}
                            else
                            {$verify="<span id='veri'>&#x2714;</span>";}
                        }
                        $pc=queryMysql("SELECT * FROM `purchased course count` WHERE `course no`='$cno'");
                        if($pc->num_rows)
                        {$cc=$pc->num_rows;}else{$cc=0;}
                        echo '<div class="rtit01">'.ucfirst($course['course title']).'&nbsp;&rarr;&nbsp;<a href="member.php?content='.$course['username'].'">'.ucfirst($course['username']).'</a>&nbsp;'.$verify;
                        echo '<br><br>&nbsp;&nbsp;Price&nbsp;: Rs'.$course['course price'];
                        echo '&nbsp;&nbsp;<button class="addtocart" name="addtocart" value="'.$cno.'" onClick="addTo(this)">Buy</button>';
                        echo '<br><br>&nbsp;Purchased count : '.$cc;
                        echo '<br><br><button class="cont450" value="'.$j.'" name="cnt" onClick="content2(this)">Content</button>';
                        echo '<div id="cont12'.$j.'" style="display:none">';
                        $con=queryMysql("SELECT * FROM `courses` WHERE `course title`='$ct'");
                        if($con->num_rows)
                        {
                            for($j=0;$j<($con->num_rows);++$j)
                            {
                                $cont=$con->fetch_array(MYSQLI_ASSOC);
                                $pono=$cont['post no'];
                                $conte=queryMysql("SELECT * FROM `post` WHERE `post no`='$pono'");
                                if($conte->num_rows)
                                {
                                    $conten=$conte->fetch_array(MYSQLI_ASSOC);
                                    $content=$conten['title'];
                                    echo ($j+1).'&nbsp;'.ucfirst($content).'<br>';
                                }
                            }
                        }
                        echo '</div></div></div>';
                    }
                }
                $verify="";
                $usr= $respo['username'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                    {$verify="<span id='verified'>&#2714;</span>";}
                    else
                    {$verify="<span id='veri'>&#x2714;</span>";}
                }
                echo '<div class="in500"><b>Notes No.'. $respo['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$respo['username'].'">'.$respo['username'].'&nbsp;'. $verify.'</a>&nbsp;&nbsp;<span class="available">';
                echo timeAgo(strtotime($respo['posting time'])).'</span></div>';
                echo '<div class="it500"><a href=postcmnt.php?content='.$respo['post no'].'>'.ucfirst($respo['title']).'</a></div>';
                echo '<div class="des400">'.ucfirst($respo['metadescription']).'</div>';
                echo '<div class="des500">Source : '.ucfirst($respo['source']).'</div>';
            }
        }
        $pcom=queryMysql("SELECT * FROM `pcomment` WHERE MATCH (`comment`) AGAINST ('$query')");
        if($pcom->num_rows)
        {
            for($j=0; $j< ($pcom->num_rows); ++$j)
            {
                $pcpo=$pcom->fetch_array(MYSQLI_ASSOC);
                $pcpno=$pcpo['post no'];
                $cop=queryMysql("SELECT * FROM `copyright notes` WHERE `notes no`='$pcpno'");
                if($cop->num_rows)
                {
                    continue;
                }
                echo '<div class="cmnt666">'.$pcpo['comment'].'</div>';
                $po=queryMysql("SELECT * FROM `post` WHERE `post no`='$pcpno'");
                $pos=$po->fetch_array(MYSQLI_ASSOC);
                $verify="";
                $usr= $pos['username'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                    {$verify="<span id='verified'>&#2714;</span>";}
                    else
                    {$verify="<span id='veri'>&#x2714;</span>";}
                }
                echo '<div class="in500"><b>Notes No.'. $pos['post no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$pos['username'].'">'.$pos['username'].'&nbsp;'.$verify.'</a>&nbsp;&nbsp;<span class="available">';
                echo timeAgo(strtotime($pos['posting time'])).'</span></div>';
                echo '<div class="it500"><a href=postcmnt.php?content='.$pos['post no'].'>'.ucfirst($pos['title']).'</a></div>';
                echo '<div class="des500">'.ucfirst($pos['metadescription']).'</div>';
            }
        }
        $rese=queryMysql("SELECT * FROM `research paper` WHERE MATCH (`title`,`introduction`,`thesis`,`body`,`summary`) AGAINST ('$query')");
        if($rese->num_rows)
        {
            for($j=0; $j<($rese->num_rows);++$j)
            {
                $research=$rese->fetch_array(MYSQLI_ASSOC);
                $rno=$research['no'];
                $verify="";
                $usr= $research['username'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                        {$verify="<span id='verified'>&#2714;</span>";}
                    else
                        {$verify="<span id='veri'>&#x2714;</span>";}
                }
                $cop=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$rno'");
                if($cop->num_rows)
                {
                    continue;
                }
                echo '<div class="in500"><b>Research Paper.'. $research['no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$research['username'].'">'.$research['username'].'&nbsp;'.$verify.'</a>&nbsp;&nbsp;<span class="available">';
                echo timeAgo(strtotime($research['posting time'])).'</span></div>';
                echo '<div class="it500"><a href="yourrdcmnt.php?content='.$research['no'].'">'. ucfirst($research['title']).'</a></div>';
                echo '<div class="des500"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($research['introduction']).'</div>';
            }
        }
        $rcom=queryMysql("SELECT * FROM `rcomment` WHERE MATCH (`comment`) AGAINST ('$query')");
        if($rcom->num_rows)
        {
            for($j=0; $j< ($rcom->num_rows); ++$j)
            {
                $rcpo=$rcom->fetch_array(MYSQLI_ASSOC);
                $rcpno=$rcpo['research no'];
                $cop=queryMysql("SELECT * FROM `copyright research` WHERE `research no`='$rcpno'");
                if($cop->num_rows)
                {
                    continue;
                }
                echo '<div class="cmnt666">'.$rcpo['comment'].'</div>';
                $ro=queryMysql("SELECT * FROM `research paper` WHERE `no`='$rcpno'");
                $ros=$ro->fetch_array(MYSQLI_ASSOC);
                $verify="";
                $usr= $ros['username'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                    {$verify="<span id='verified'>&#2714;</span>";}
                    else
                    {$verify="<span id='veri'>&#x2714;</span>";}
                }
                echo '<div class="in500"><b>Research Paper.'. $ros['no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$ros['username'].'">'.$ros['username'].'&nbsp;'.$verify.'</a>&nbsp;&nbsp;<span class="available">';
                echo timeAgo(strtotime($ros['posting time'])).'</span></div>';
                echo '<div class="it500"><a href="yourrdcmnt.php?content='.$ros['no'].'">'. ucfirst($ros['title']).'</a></div>';
                echo '<div class="des500"><strong><i>INTRODUCTION:</i></strong> &nbsp;'.ucfirst($ros['introduction']).'</div>';
            }
        }
        $iss=queryMysql("SELECT * FROM `requirement` WHERE MATCH (`issue`,`description`) AGAINST ('$query')");
        if($iss->num_rows)
        {
            for($j=0; $j<($iss->num_rows);++$j)
            {
                $rq=$iss->fetch_array(MYSQLI_ASSOC);
                $time =$rq['posting time'];
                $verify="";
                $usr= $rq['username'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                    {$verify="<span id='verified'>&#2714;</span>";}
                    else
                    {$verify="<span id='veri'>&#x2714;</span>";}
                }
                echo '<div class="in500"><b>Issue No.'. $rq['issue no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$rq['username'].'">'.$rq['username'].'&nbsp;'.$verify.'</a>&nbsp;&nbsp;<span class="available">';
                echo timeAgo(strtotime($time)).'</span></div>';
                echo '<div class="it500"><a href="yourrequirecmnt.php?content='.$rq['issue no'].'">'. $rq['issue'].'</a></div>';
                echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.$rq['description'].'</div>';
            }
        }
        $icom=queryMysql("SELECT * FROM `comment` WHERE MATCH (`comment`) AGAINST ('$query')");
        if($icom->num_rows)
        {
            for($j=0; $j< ($icom->num_rows); ++$j)
            {
                $icpo=$icom->fetch_array(MYSQLI_ASSOC);
                $icpno=$icpo['issue no'];
                echo '<div class="cmnt666">'.$icpo['comment'].'</div>';
                $io=queryMysql("SELECT * FROM `requirement` WHERE `issue no`='$icpno'");
                $rq=$io->fetch_array(MYSQLI_ASSOC);
                $time =$rq['posting time'];
                $verify="";
                $usr= $rq['username'];
                $m=queryMysql("SELECT * FROM `milestone approved` WHERE `username`='$usr'");
                if($m->num_rows)
                {
                    $av=queryMysql("SELECT * FROM `account verified` WHERE `username`='$usr'");
                    if($av->num_rows)
                    {$verify="<span id='verified'>&#2714;</span>";}
                    else
                    {$verify="<span id='veri'>&#x2714;</span>";}
                }
                echo '<div class="in500"><b>Issue No.'. $rq['issue no'].'</b>'.'&nbsp;&nbsp;'.'<a href="member.php?content='.$rq['username'].'">'.$rq['username'].'&nbsp;'.$verify.'</a>&nbsp;&nbsp;<span class="available">';
                echo timeAgo(strtotime($time)).'</span></div>';
                echo '<div class="it500"><a href="yourrequirecmnt.php?content='.$rq['issue no'].'">'. $rq['issue'].'</a></div>';
                echo '<div class="des500"><strong><i>Description:</i></strong> &nbsp;'.$rq['description'].'</div>';
            }
        }
    }
    $connection->close();
?>