<?php
    session_start();
    $user = $_SESSION['user'];
    require_once 'functions.php';
    if (isset($_POST['likeR']))
    {
        $sp = sanitizeString($_POST['likeR']);
        queryMysql("INSERT INTO `liked research`VALUES (NULL,'$user','$sp')");
        $c=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$sp'");
        if($c->num_rows)
        {
            $ct=$c->fetch_array(MYSQLI_ASSOC);
            $cn=$ct['lcount'];
            $cn=$cn + 1;
            queryMysql("UPDATE `rcount` SET `lcount`= '$cn'  WHERE `research no`='$sp'");

        }
        else{
            queryMysql("INSERT INTO `rcount`(`research no`, `lcount`) VALUES ('$sp','1')");
        }
        $d=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$sp'");
        if($d->num_rows)
        {
            $cd=$d->fetch_array(MYSQLI_ASSOC);
            $cont=$cd['lcount'];
        }
        echo '<button class="heart cross" id="heart" name="unlikeR" value="'.$sp.'" onClick="unlikeR(this)">&#10084;</button><span id="countR">'.$cont.'</span>';
    }
    if (isset($_POST['unlikeR']))
    {
        $sp = sanitizeString($_POST['unlikeR']);
        queryMysql("DELETE FROM `liked research` WHERE `username`='$user' AND `research no`='$sp'");
        $c=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$sp'");
        if($c->num_rows)
        {
            $ct=$c->fetch_array(MYSQLI_ASSOC);
            $cn=$ct['lcount'];
            $cn=$cn - 1;
            queryMysql("UPDATE `rcount` SET `lcount`= '$cn'  WHERE `research no`='$sp'");

        }
        $d=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$sp'");
        if($d->num_rows)
        {
            $cd=$d->fetch_array(MYSQLI_ASSOC);
            $cont=$cd['lcount'];
        }
        echo '<button class="heart" id="heart" name="likeR" value="'.$sp.'" onClick="likeR(this)">&#10004;</button><span id="countR">'.$cont.'</span>';
    }
    if (isset($_POST['dlikeR']))
    {
        $sp = sanitizeString($_POST['dlikeR']);
        queryMysql("INSERT INTO `disliker` VALUES (NULL,'$user','$sp')");
        $c=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$sp'");
        if($c->num_rows)
        {
            $ct=$c->fetch_array(MYSQLI_ASSOC);
            $cn=$ct['dcount'];
            $cn=$cn + 1;
            queryMysql("UPDATE `rcount` SET `dcount`= '$cn'  WHERE `research no`='$sp'");

        }
        else{
            queryMysql("INSERT INTO `rcount`(`research no`, `dcount`) VALUES ('$sp','1')");
        }
        $d=queryMysql("SELECT * FROM `rcount` WHERE `research no`='$sp'");
        if($d->num_rows)
        {
            $cd=$d->fetch_array(MYSQLI_ASSOC);
            $cont=$cd['dcount'];
        }
        echo '<button class="heart" name="dlikeR" value="'.$sp.'">&#10060;</button><span id="countR">'.$cont.'</span>';
    }
    if (isset($_POST['likeP']))
    {
        $sp = sanitizeString($_POST['likeP']);
        queryMysql("INSERT INTO `liked post`VALUES (NULL,'$user','$sp')");
        $c=queryMysql("SELECT * FROM `pcount` WHERE `post no`='$sp'");
        if($c->num_rows)
        {
            $ct=$c->fetch_array(MYSQLI_ASSOC);
            $cn=$ct['lcount'];
            $cn=$cn + 1;
            queryMysql("UPDATE `pcount` SET `lcount`= '$cn'  WHERE `post no`='$sp'");

        }
        else{
            queryMysql("INSERT INTO `pcount`(`post no`, `lcount`) VALUES ('$sp','1')");
        }
        $d=queryMysql("SELECT * FROM `pcount` WHERE `post no`='$sp'");
        if($d->num_rows)
        {
            $cd=$d->fetch_array(MYSQLI_ASSOC);
            $cont=$cd['lcount'];
        }
        echo '<button class="heart cross" id="heart" name="unlikeP" value="'.$sp.'" onClick="unlikeP(this)">&#10084;</button><span id="countR">'.$cont.'</span>';
    }
    if (isset($_POST['unlikeP']))
    {
        $sp = sanitizeString($_POST['unlikeP']);
        queryMysql("DELETE FROM `liked post` WHERE `username`='$user' AND `post no`='$sp'");
        $c=queryMysql("SELECT * FROM `pcount` WHERE `post no`='$sp'");
        if($c->num_rows)
        {
            $ct=$c->fetch_array(MYSQLI_ASSOC);
            $cn=$ct['lcount'];
            $cn=$cn - 1;
            queryMysql("UPDATE `pcount` SET `lcount`= '$cn'  WHERE `post no`='$sp'");

        }
        $d=queryMysql("SELECT * FROM `pcount` WHERE `post no`='$sp'");
        if($d->num_rows)
        {
            $cd=$d->fetch_array(MYSQLI_ASSOC);
            $cont=$cd['lcount'];
        }
        echo '<button class="heart" id="heart" name="likeP" value="'.$sp.'" onClick="likeP(this)">&#10004;</button><span id="countR">'.$cont.'</span>';
    }
    if (isset($_POST['dlikeP']))
    {
        $sp = sanitizeString($_POST['dlikeP']);
        queryMysql("INSERT INTO `dislikep` VALUES (NULL,'$user','$sp')");
        $c=queryMysql("SELECT * FROM `pcount` WHERE `post no`='$sp'");
        if($c->num_rows)
        {
            $ct=$c->fetch_array(MYSQLI_ASSOC);
            $cn=$ct['dcount'];
            $cn=$cn + 1;
            queryMysql("UPDATE `pcount` SET `dcount`= '$cn'  WHERE `post no`='$sp'");

        }
        else{
            queryMysql("INSERT INTO `pcount`(`post no`, `dcount`) VALUES ('$sp','1')");
        }
        $d=queryMysql("SELECT * FROM `pcount` WHERE `post no`='$sp'");
        if($d->num_rows)
        {
            $cd=$d->fetch_array(MYSQLI_ASSOC);
            $cont=$cd['dcount'];
        }
        echo '<button class="heart" name="dlikeP" value="'.$sp.'">&#10060;</button><span id="countR">'.$cont.'</span>';
    }
    $connection->close();
?>