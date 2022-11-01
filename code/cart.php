<?php
    session_start();
    require_once 'functions.php';
    $user=$_SESSION['user'];
    if(isset($_POST['addtocart']))
    {
        $cno= sanitizeString($_POST['addtocart']);
        $ins=queryMysql("SELECT * FROM `cart` WHERE `username`='$user' AND `course no`='$cno'");
        if(($ins->num_rows)==0)
        {
            queryMysql("INSERT INTO `cart`( `username`, `course no`, `quantity`) VALUES ('$user','$cno','1')");
        }
        else{
            $qns=$ins->fetch_array(MYSQLI_ASSOC);
            $qnt=$qns['quantity'];
            $qn=$qnt+1;
            queryMysql("UPDATE `cart` SET `quantity`='$qn' WHERE `username`='$user' AND `course no`='$cno'");
        }
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
    }
    if(isset($_POST['add']))
    {
        $cno= sanitizeString($_POST['add']);
        $ins=queryMysql("SELECT * FROM `cart` WHERE `username`='$user' AND `course no`='$cno'");
        if($ins->num_rows)
        {
            $qns=$ins->fetch_array(MYSQLI_ASSOC);
            $qnt=$qns['quantity'];
            $qn=$qnt+1;
            queryMysql("UPDATE `cart` SET `quantity`='$qn' WHERE `username`='$user' AND `course no`='$cno'");
        }
        $ins=queryMysql("SELECT * FROM `cart` WHERE `username`='$user' AND `course no`='$cno'");
        if($ins->num_rows)
        {
            $qns=$ins->fetch_array(MYSQLI_ASSOC);
            $qnt=$qns['quantity'];
            echo $qnt;
        }
    }
    if(isset($_POST['subtract']))
    {
        $cno= sanitizeString($_POST['subtract']);
        $ins=queryMysql("SELECT * FROM `cart` WHERE `username`='$user' AND `course no`='$cno'");
        if($ins->num_rows)
        {
            $qns=$ins->fetch_array(MYSQLI_ASSOC);
            $qnt=$qns['quantity'];
            if($qnt!=0)
            {
                $qn=$qnt-1;
                queryMysql("UPDATE `cart` SET `quantity`='$qn' WHERE `username`='$user' AND `course no`='$cno'");
            }
        }
        $ins=queryMysql("SELECT * FROM `cart` WHERE `username`='$user' AND `course no`='$cno'");
        if($ins->num_rows)
        {
            $qns=$ins->fetch_array(MYSQLI_ASSOC);
            $qnt=$qns['quantity'];
            echo $qnt;
        }
    }
    if(isset($_POST['empty']))
    {
        $ins=queryMysql("SELECT * FROM `cart` WHERE `username`='$user'");
        if($ins->num_rows)
        {
            queryMysql("DELETE FROM `cart` WHERE `username`='$user'");
        }
    }
    if(isset($_POST['cartvalue']))
    {
?>
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
        <p id="subt" aria-label="subtotal">Your Subtotal = <span id="subto"><?php echo $sum;?></span></p>
        <?php 
            $_SESSION['cartamount']=$sum;
        ?>
    </div>
<?php
    }
?>