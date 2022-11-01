<?php 
    require_once 'functions.php';
    if(isset($_POST['course']))
    {
        $cno=sanitizeString($_POST['course']);
        $cou=queryMysql("SELECT * FROM `course title` WHERE `course no`='$cno'");
        if($cou->num_rows)
        {
            $cour=$cou->fetch_array(MYSQLI_ASSOC);
            $usr=$cour['username'];
            $ct=$cour['course title'];
            echo '<a href="javascript:void(0)" onClick="closeCon()" class="closecon">&times;</a>';
            $co=queryMysql("SELECT * FROM `courses` WHERE `course title`='$ct'");
            if($co->num_rows)
            {
                for($j=0;$j<($co->num_rows);++$j)
                {
                    $con=$co->fetch_array(MYSQLI_ASSOC);
                    $pno=$con['post no'];
                    $cont=queryMysql("SELECT * FROM `post` WHERE `post no`='$pno'");
                    if($cont->num_rows)
                    {
                        $conte=$cont->fetch_array(MYSQLI_ASSOC);
                        $ctt=$conte['title'];
                        $cdes=$conte['metadescription'];
                        echo '<div class="ctl900" aria-label="content">'.($j+1).'&nbsp;'.$ctt.'&nbsp;- '.$cdes.'</div>';
                    }
                }
                echo '<button class="addtocrt" aria-label="buy" name="addtocart" value="'.$cno.'" onClick="addTo(this)">Buy</button>';
            }
        }
    }
    $connection->close();
?>