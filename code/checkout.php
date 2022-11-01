<?php 
    require_once 'header.php';
    if(!$loggedin)
    {
        die(header('location:index.php'));
    }
?>
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
            if($qntity==0)
            continue;
            $cl= queryMysql("SELECT * FROM `course title` WHERE `course no`='$qnty'");
            $ctl=$cl->fetch_array(MYSQLI_ASSOC);
            $cp = $ctl['course price'];                               
            $sum=$sum+($qntity*$cp);
        }
    }                                        
?> 
   </body>
</html>