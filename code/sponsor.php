<?php
    session_start();
    $user = $_SESSION['user'];
    require_once 'functions.php';
    if (isset($_POST['sponsor']))
    {
        $sp = sanitizeString($_POST['sponsor']);
        queryMysql("INSERT INTO `sponsor`(`username`, `sponsored`, `post status`, `research status`, `issue status`, `posting time`) VALUES ('$user','$sp','1','1','1',NOW())");
        echo '<button id="bt101" class="ui-btn" name="unfollow" value="'.$sp.'" onClick="unfollow(this)">Sponsored</button>';
    }
    if(isset($_POST['unfollow']))
    {
        $sp = sanitizeString($_POST['unfollow']);
        queryMysql("DELETE FROM `sponsor` WHERE `username`='$user' AND `sponsored`='$sp'");
        echo '<button id="bt101" class="ui-btn" name="sponsor" value="'.$sp.'" onClick="sponsor(this)">Sponsor</button>';
    }
    $connection->close();
?>