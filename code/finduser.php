<?php
    require_once 'functions.php';
    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $result = queryMysql("SELECT * FROM members WHERE username='$user'");
        if ($result->num_rows)
        echo "<span class='available'>&nbsp;&#x2714; " . "Please enter registered email</span>";
        else
        echo "<span class='taken'>&nbsp;&#x2718; " . "Username $user not found</span>";
    }
    $connection->close();
?>