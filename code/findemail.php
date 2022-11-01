<?php
    require_once 'functions.php';
    if (isset($_POST['email']))
    {
        $email = sanitizeString($_POST['email']);
        $result = queryMysql("SELECT * FROM profiles WHERE email='$email'");
        if ($result->num_rows)
        echo "<span class='available'>&nbsp;&#x2714; " . "Continue with password</span>";
        else
        echo "<span class='taken'>&nbsp;&#x2718; " . "Email $email not found</span>";
    }
    $connection->close();
?>