<?php
    require_once 'header.php';
    $error=$user = $pass="";
    if ($loggedin){
        die(header('location:search.php'));
    }
    else{
        echo <<<_GUEST
            <div data-role='page' id='index'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed"><div id='head'>(You must be logged in to use this app)</div></div></header>
         _GUEST;
    }
?>
<?php
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (isset($_POST['user']))
        {
            $user = sanitizeString($_POST['user']);
            $pass = sanitizeString($_POST['pass']);

            if ($user == "" || $pass == "")
            $error = 'Not all fields were entered';
            else
            {
                $result = queryMySQL("SELECT username, `password` FROM `members` WHERE `username`='$user'");
                if ($result->num_rows == 0)
                {
                $error = "Invalid login attempt";
                }
                else
                {
                    $row=$result->fetch_array(MYSQLI_ASSOC);
                    $hash=$row['password'];
                    if (password_verify($pass, $hash)) 
                    {
                        $cc=queryMysql("SELECT * FROM `total report count` WHERE `username`='$user'");
                        if($cc->num_rows==0)
                        {
                            $_SESSION['user'] = $user;
                            $_SESSION['pass'] = $pass;
                            if(isset($_COOKIE['post']))
                            {
                                $cnt= sanitizeString($_COOKIE['post']);
                                die(header('location:postcmnt.php?content='.$cnt));
                            }
                            elseif(isset($_COOKIE['research']))
                            {
                                $cnt= sanitizeString($_COOKIE['research']);
                                die(header('location:yourrdcmnt.php?content='.$cnt));
                            }
                            else{
                                die(header('location:search.php'));
                            } 
                        }
                        else{
                            $error= "Account blocked due to exceeding report count please email us.";
                        }                       
                    }
                    else{
                        $error="Invalid password";
                        $error.=$pass;
                    }
                }
            }
        }
    }
?>
    <main>
        <div data-role="main" id="main01" class="ui-content">
            <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);" ></div>
            <?php 
                $ip = getIPAddress();
                $ips=queryMysql("SELECT * FROM `ip address` WHERE `address`='$ip'");
                if($ips->num_rows==0)
                {
            ?>
            <p style="text-align:center;font-size:30px;position:relative;">Before Signup.. <a href="readme.php" style="color: #551a8b;"> PLEASE READ ME &#10071;</a></p>
            <?php }?>
            <div id="pad01">
                <div class="body03">
                    <div id="left03"><p id="left04"><a href="www.notebook.com" aria-label="logo"> NoTeBoOk </a></p></div>
                    <div id="rt04">
                        <div id="pad02">
                            <form class="c03" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="POST">
                                <span class="error pad006 ui-field-contain"><?php echo "$error"?></span>
                                <div class="pad04 ui-field-contain"><input type="text" name="user" id="user" data-clear-btn="true" aria-label="username"placeholder="Username" required autofocus></div>
                                <div class="pad04 ui-field-contain"><input type="password" name="pass" id="pass" aria-label="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Enter password used during signup" required autocomplete="on"></div>
                                <div data-role="controlgroup" data-type="horizontal" id="control"><label for="showpass01">Show Password</label><input type="checkbox" data-mini="true" onClick="showPassword()" aria-label="show password" name="showpass01" id="showpass01"></div>
                                <div class="pad04"><button id="b07" type="submit" data-transition="pop" aria-label="login" data-icon="carat-r" data-role="ui-btn ui-btn-inline ui-corner-all ui-shadow ui-icon-left">Login</button></div>
                            </form>
                            <div id="pad05"><a href="forgot.php" aria-label="forgotten password">forgotten Password?</a></div>
                            <hr>
                            <div id="pad005"><a href="signup.php" class="ui-btn" data-transition="pop" aria-label="signup" data-role="button" data-icon="plus" data-icon-pos="left">Sign Up</a></div>  
                        </div>        
                    </div>
                </div>
            </div> 
        </div>   
    </main>
        <?php include "footer.php"; ?>
    </div>     
    </body>         
</html>
