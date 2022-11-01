<?php //
    session_start();
        echo <<<_INIT
            <!DOCTYPE html>
            <html>
            <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <link rel='stylesheet' href='css/styles.css'>
            <script src='js/javascript.js'></script>           
            <script src='js/jquery-3.5.1.min.js'></script>           
            <script src='js/signup.js'></script>
        _INIT;
    require_once 'functions.php';
    $userstr = 'Welcome Guest';
    if (isset($_SESSION['user']))
    {
        $user = $_SESSION['user'];
        $loggedin = TRUE;
        $userstr =  ucfirst(strtolower($user));
    }
    else $loggedin = FALSE;
    echo <<<_MAIN
        <title>Notebook: $userstr</title>
        </head>
        <body>
     _MAIN;
?>
