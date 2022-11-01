<?php
    require_once 'header.php';
    if ($loggedin){
        echo <<<_HEAD
            <div data-role='page' id='search' data-url='search'><header><nav><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
            <div data-role='navbar' class='topnav' id='navbar'>
            <a href="home.php">HOME</a>
            <a href="search.php">SEARCH</a>
            <a href="createad.php">CREATE AD</a>
            <a href="logout.php">LOG OUT</a>
            <a href="javascript:void(0);" class="icon pos2" onClick="responseNav()">&#9776;</a>
            </div></div></nav></header>
        _HEAD;
    }
    else{
        die(header('location:index.php'));
    }
?>
<?php 
    $style=$result="";
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['query']))
        {
            $qu=sanitizeString($_POST['query']);
            if($qu!="")
            {
                $style="margin-top: 0;padding-top: 4vh;";
            }
        }   
    }
?>
<main>
    <div data-role="main" id="main01" class="ui-content">
        <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);" ></div>
        <div id="cart">
            <div id="cart2">
                <span id="cart4">
                    <?php
                        $ct = queryMysql("SELECT * FROM `cart` WHERE `username`='$user'");
                        $quantity=0;
                        if($ct->num_rows)
                        {
                            for($j=0; $j< ($ct->num_rows); ++$j)
                            {
                                $qnt = $ct->fetch_array(MYSQLI_ASSOC);
                                $qnty= $qnt['quantity'];
                                $quantity= $quantity+$qnty; 
                            }
                            echo $quantity;
                        }
                    ?>
                </span>
                <button id="cart3" name="cartvalue" onClick="showCart(this)" value="<?php echo $user;?>">&#128722;</button>
            </div>
        </div>
        <div id="showcart" style="display:none;">
            <div id="showcart2">
                <div id="cptn">Cart</div>
                <div id="showcart3">    
                <div class="gridcell" aria-label="no">No.</div>
                <div class="gridcell" aria-label="course">Course</div>
                <div class="gridcell" aria-label="price per course">Price/Course</div>
                <div class="gridcell" aria-label="quantity">Quantity</div>
                <div class="gridcell" aria-label="total amount">Total Amount</div>
                    <?php 
                        $ct = queryMysql("SELECT * FROM `cart` WHERE `username`='$user'");
                        $sum=0;
                        if($ct->num_rows)
                        {
                            for($j=0; $j< ($ct->num_rows); ++$j)
                            {
                                $qnt = $ct->fetch_array(MYSQLI_ASSOC);
                                $qnty= $qnt['course no'];
                                $qntity=$qnt['quantity'];
                                $cl= queryMysql("SELECT * FROM `course title` WHERE `course no`='$qnty'");
                                $ctl=$cl->fetch_array(MYSQLI_ASSOC);
                                $ctit=$ctl['course title'];
                                $cp = $ctl['course price'];
                                echo '<div class="gridcell">'.($j+1).'</div>';
                                echo '<div class="gridcell" aria-label="'.$ctit.'">'.$ctit.'</div>';
                                echo '<div id="gridcell5'.$qnty.'">'.$cp.'</div>';
                                echo '<div id="gridcell2"><div id="gridcell3'.$qnty.'">'.$qntity.'</div>';
                                echo '<div class="id"><button class="id1" aria-label="add" name="add" onClick="add(this)" value="'.$qnty.'">&#10133;</button><button class="id1" aria-label="subtract" name="subtract" onClick="subtract(this)" value="'.$qnty.'">&#10134;</button></div>';
                                echo '</div>';
                                echo '<div id="gridcell4'.$qnty.'">'.($qntity*$cp).'</div>';
                                $sum=$sum+($qntity*$cp);
                            }
                        }
                    ?>    
                </div>
                <div id="totalp">
                    <p id="tota">All prices are in Indian Rupee.</p>
                    <p id="subt">Your Subtotal = <span id="subto"><?php echo $sum;?></span></p>
                    <?php 
                        $_SESSION['cartamount']=$sum;
                    ?>
                </div>
            </div>
            <div id="botn"><!-- remove disabled and #-->
                <button id="cheout90" aria-label="checkout" disabled><a href="#checkout.php" style="color:black;text-decoration:none;outline:none;">Checkout</a></button>    
                <button id="emp" aria-label="empty cart" name="empty" onClick="empty(this)" value="<?php echo $user?>">Empty Cart</button>
            </div>
        </div>
        <?php 
            include("main.php");
        ?>
        <div id="result">
            <?php 
                if($_SERVER["REQUEST_METHOD"]=="POST")
                {
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
                }
                else{
                    echo $result;
                }
            ?>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>
</div>
</body>
</html>
