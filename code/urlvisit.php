<?php
    session_start();
    require_once 'functions.php';
    $user=$_SESSION['user'];
    if(isset($_POST['vurl']))
    {
        $ano=sanitizeString($_POST['vurl']);
        $cu=queryMysql("SELECT * FROM `create ad url visited` WHERE `username`='$user'");
        if($cu->num_rows==0)
        {
            queryMysql("INSERT INTO `create ad url visited`(`username`, `ad no`, `visited count`) VALUES ('$user','$ano','1')");
        }
        else{
            $cute=$cu->fetch_array(MYSQLI_ASSOC);
            $vc=$cute['visited count'];
            $vco=$vc+1;
            queryMysql("UPDATE `create ad url visited` SET `visited count`= '$vco' WHERE `username`='$user'");
        }
        echo '&nbsp;';
    }
    if(isset($_POST['repad']))
    {
        $rno=sanitizeString($_POST['repad']);
        $ch=queryMysql("SELECT * FROM `ad reported` WHERE `ad no`='$rno'");
        if($ch->num_rows==0)
        {
            queryMysql("INSERT INTO `ad reported`(`username`, `ad no`, `reported on`) VALUES ('$user','$rno',NOW())");
        }
        echo '&nbsp;';
    }
    $connection->close();
?>