<?php
    /*connection*/
    include 'connection.php';
    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($connection->connect_error) die("Connection Error");
    /* queryMysql*/
    function queryMysql($query)
    {
        global $connection;
        $result = $connection->query($query);
        if (!$result) die("Fatal Error");
        return $result;
    }
    /*destroy session*/
    function destroySession()
    {
        $_SESSION=array();
        if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');
        session_destroy();
    }
    /*sanitize string*/
    function sanitizeString($var)
    {
        global $connection;
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $connection->real_escape_string($var);
    }
    /*insert education*/
    function Education($ed,$user)
    {
        if(isset($_POST[$ed]))
        {
            $edu = sanitizeString($_POST[$ed]);
            if($edu==""){
                return;
            }
            else{
                $result = queryMysql("SELECT '$ed' FROM education WHERE `username`='$user'");
                if($result->num_rows){
                    queryMysql("UPDATE `education` SET `$ed`='$edu' WHERE `username`='$user'");
                }
                else{
                    queryMysql("INSERT INTO `education`(`$ed`) VALUES ('$edu')WHERE `username`='$user'");
                }
            }
        }
    }
    /*insert work*/
    function Work($wrk,$user)
    {
        if(isset($_POST[$wrk]))
        {
            $work = sanitizeString($_POST[$wrk]);
            if($work==""){
                return;
            }
            else{
                $result = queryMysql("SELECT '$wrk' FROM work WHERE `username`='$user'");
                if($result->num_rows){
                    queryMysql("UPDATE `work` SET `$wrk`='$work' WHERE `username`='$user'");
                }
                else{
                    queryMysql("INSERT INTO `work`(`$wrk`) VALUES ('$work')WHERE `username`='$user'");
                }
            }
        }
    }
    /*update profile*/
    function profile($pr,$user)
    {
        if(isset($_POST[$pr]))
        {
            $work = sanitizeString($_POST[$pr]);
            if($work==""){
                return;
            }
            else{
                $result = queryMysql("SELECT '$pr' FROM profiles WHERE `username`='$user'");
                if($result->num_rows){
                    queryMysql("UPDATE `profiles` SET `$pr`='$work' WHERE `username`='$user'");
                }
            }
        }
    }
    /*update username*/
    function username($pr,$user)
    {
        if(isset($_POST[$pr]))
        {
            $work = sanitizeString($_POST[$pr]);
            if($work==""){
                return;
            }
            else{
                queryMysql("UPDATE `profiles` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `adchoice` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `comment` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `education` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `members` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `rcomment` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `requirement` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `research paper` SET `$pr`='$work' WHERE `username`='$user'");
                queryMysql("UPDATE `work` SET `$pr`='$work' WHERE `username`='$user'");
            }
        }
    }
    /*adchoice*/
    function adchoice($wrk,$user)
    {
        if(isset($_POST[$wrk]))
        {
            $work = sanitizeString($_POST[$wrk]);
            $result = queryMysql("SELECT '$wrk' FROM adchoice WHERE `username`='$user'");
            if($result->num_rows){
                queryMysql("UPDATE `adchoice` SET `$wrk`='$work' WHERE `username`='$user'");
            }
        }
    }
    /*update current location*/
    function cLoc($pr,$user)
    {
        if(isset($_POST[$pr]))
        {
            $work = sanitizeString($_POST[$pr]);
            if($work==""){
                return;
            }
            else{
                $result = queryMysql("SELECT '$pr' FROM clocation WHERE `username`='$user'");
                if($result->num_rows){
                    queryMysql("UPDATE `clocation` SET `$pr`='$work' WHERE `username`='$user'");
                }
                else{
                    queryMysql("INSERT INTO `clocation`(`$pr`) VALUES ('$work')WHERE `username`='$user'");
                }
            }
        }
    }
    /*convert to time ago*/
    function timeAgo($time){
        date_default_timezone_set("Asia/Kolkata");
        $diff = time() - $time;
        $sec = $diff;
        $min = round($diff/60);
        $hrs = round($diff/3600);
        $days= round($diff/86400);
        $weeks=round($diff/604800);
        $mnths=round($diff/2600640);
        $yrs=round($diff/31207680);
        if($sec<=60){
            echo "$sec seconds ago";
        }
        elseif($min<=60){
            if($min==1){
                echo "1 minute ago";
            }
            else{
                echo "$min minutes ago";
            }
        }
        elseif ($hrs<=24) {
            if($hrs==1){
                echo "an hour ago";
            }
            else{
                echo "$hrs hours ago";
            }
        }
        elseif ($days<=7) {
            if($days==1){
                echo "Yesterday";
            }
            else{
                echo "$days days ago";
            }
        }
        elseif ($weeks <= 4.3) {
            if($weeks ==1){
                echo "a week ago";
            }
            else{
                echo "$weeks week ago";
            }
        }
        elseif ($mnths<=12) {
            if($mnths==1){
                echo "a month ago";
            }
            else{
                echo "$mnths months ago";
            }
        }
        else{
            if($yrs==1){
                echo "1 year ago";
            }
            else{
                echo "$yrs years ago";
            }
        }
    }
    /*notification*/
    function Notification($table,$user,$tab,$tuser)
    {
        $cnt = 0;
        $is="";
        $resultU = queryMysql("SELECT * FROM `$table` WHERE `username`= '$user'");
        if($resultU->num_rows)
        {
            $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
            $is = $rowU['username'];
        }
        $resultN = queryMysql("SELECT * FROM `$tab` WHERE `status`=0 AND `$tuser`='$is'");
        $cnt += $resultN->num_rows;
        return $cnt;
    }
    /*convert to time ago and return value*/
    function timeAgoo($time){
        date_default_timezone_set("Asia/Kolkata");
        $diff = time() - $time;
        $days= round($diff/86400);      
        return $days;
    }
    /*convert to timeago for milestone no of month*/
    function timeAgoR($time){
        date_default_timezone_set("Asia/Kolkata");
        $diff = time() - $time;
        $mnths=round($diff/2600640);     
        return $mnths;
    }
    /*send otp 
    function sendOTP($email,$otp){
        $message = "OTP: ".$otp."";
        $to=$email;
        $subject = "OTP";
        $headers = "From: abhinav445.aa@gmail.com";
        if(mail($to,$subject,$message,$headers))
        return FALSE;
        else 
        return FALSE;
    }*/
    /*getting ip address*/
    function getIPAddress() { 
        //whether ip is from the share internet 
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) { 
            $ip = $_SERVER['HTTP_CLIENT_IP']; 
        } 
        //whether ip is from the proxy 
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } 
       //whether ip is from the remote address 
        else{ 
        $ip = $_SERVER['REMOTE_ADDR']; 
        } 
        return $ip; 
    }
?>