<?php
    session_start();
    $user = $_SESSION['user'];
    require_once 'functions.php';
    if (isset($_POST['ads']))
    {
        $ads = sanitizeString($_POST['ads']);
        $re=queryMysql("SELECT * FROM `adchoice` WHERE `username`='$user'");
        if($re->num_rows==0)
        {
            queryMysql("INSERT INTO `adchoice`(`username`) VALUES ('$user')");
        }
        $opt=queryMysql("SELECT `education`, `property`, `electronics`, `fashion`, `food`, `jobs`, `ticket`, `hotel`, `hospital`, `pharmacy`, `cars`, `cabs`, `artist`, `entertainment`, `grocery`, `astrology`, `marketing`, `everything` FROM `adchoice` WHERE `username`='$user'");
        $ro=$opt->fetch_array(MYSQLI_ASSOC);
        if($ads=="yes")
        {
            echo "<div id='adchoice'>";
            foreach ($ro as $key => $value)
            {
                if($value=="yes")
                {
                    echo "<label for='".$key."'>".ucfirst($key)."</label><input type='checkbox' name='".$key."' id='".$key."' value='yes' checked>";
                }
                else{
                    echo "<label for='".$key."'>".ucfirst($key)."</label><input type='checkbox' name='".$key."' id='".$key."' value='yes'>";
                }
            }unset($value);
            echo "</div>";
        }
        else{
            echo '<span class="available"><p id="ads04">* You can even select ads category</p></span>';
        }
    }
    $connection->close();
?>