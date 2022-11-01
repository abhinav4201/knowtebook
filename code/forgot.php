<?php
    require_once 'header.php';
    $error=$error2=$email = $pass1=$pass2= $proceed=$proceed2= "";
    if ($loggedin){
        die(header('location:#index.php'));
    }
    else{
        echo <<<_GUEST
            <div data-role='page' id='forgot' data-url='forgot'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
            <a href="index.php" data-role="button" data-inline="true" class='icon pos01' data-icon="back" data-iconpos="notext">&#9756;</a><div id='head'>(Change Password)</div></div></header>
         _GUEST;
    }
?>
<?php 
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(isset($_POST['user']))
        {
            $user = sanitizeString($_POST['user']);
            $email= sanitizeString($_POST['email']);

            if ($user == "" || $email == "")
            $error = 'Not all fields were entered';
            else
            {
                $result1= queryMySQL("SELECT username, `password` FROM `members` WHERE `username`='$user'");
                $result2=queryMySQL("SELECT email FROM `profiles` WHERE `email`='$email'");
                if(($result1->num_rows && $result2->num_rows)==0)
                {
                    $error="Account not found";
                }
                else
                {
                    $proceed="Account found !";
                    if(isset($_POST['pass1']))
                    {
                        $pass1= sanitizeString($_POST['pass1']);
                        $pass2= sanitizeString($_POST['pass2']);

                        if($pass1=="" || $pass2=="")
                        $error2= "Not all fields were entered";
                        else
                        {
                            if(strlen($pass1 && $pass2) < 6 && (!preg_match("/[a-z]/", $pass1) || 
                                                        !preg_match("/[a-z]/", $pass2) ||
                                                        !preg_match("/[A-Z]/", $pass1) ||
                                                        !preg_match("/[A-Z]/", $pass2) ||
                                                        !preg_match("/[0-9]/", $pass1) ||
                                                        !preg_match("/[0-9]/", $pass2)))
                                {
                                    $error2="Passwords must be at least 6 characters<br>";
                                    $error2.="Passwords require 1 each of a-z, A-Z and 0-9<br>";
                                }
                            else{
                                if($pass1==$pass2)
                                {
                                    $pass2=password_hash($pass2,PASSWORD_DEFAULT);
                                    queryMySQL("UPDATE `members` SET `password`='$pass2' WHERE `username`='$user'");
                                    $proceed2="Update success! please <a href='index.php'>Login</a>";
                                }
                                else{
                                    $error2= "Password does not match";
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
 <main>
        <div data-role="main" id="main01" class="ui-content">
            <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);" ></div>
            <div id="cont02">
            <form data-ajax="false" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="post" id="c10">
                <div id="left07">
                    <div id="pad07" class="ui-field-contain">
                        <div id="c07">
                            <span class="error" id="e07"><?php echo $error;?></span>
                            <p id="b11">Change Password</p>
                            <label for="user07" class="ui-hidden-accessible"></label><input type="text" name="user" aria-label="username" class="input" id="user07" placeholder="Username *" onKeyup="findUser(this)" required>
                            <div id="used">&nbsp;</div>
                            <label for="email07" class="ui-hidden-accessible"></label><input type="email" name="email" aria-label="email" class="input" id="email07" placeholder="Email *" onKeyup="findEmail(this)" required>
                            <div id="used4">&nbsp;</div>            
                            <span class="available" id="e08"><?php echo $proceed;?></span>
                        </div>
                    </div>
                </div>
                <div id="rt07">
                <div id="pad08" class="ui-field-contain">
                        <div id="c08">
                            <span class="error" id="e09"><?php echo $error2;?></span>
                            <label for="pass107" class="ui-hidden-accessible"></label><input type="password" name="pass1" aria-label="new password" class="input" id="pass107" placeholder="Password *" required onKeyup="checkPass(this)" autocomplete="on" maxlength="15" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase and more than 8 character">
                            <div id="used2">&nbsp;</div>
                            <label for="pass207" class="ui-hidden-accessible"></label><input type="password" name="pass2" aria-label="confirm password" class="input" id="pass207" placeholder="Confirm Password *" required autocomplete="on" onKeyup="comparePassword()" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}">
                            <div id="used5">&nbsp;</div>
                            <input type="submit" aria-label="confirm" class="ui-btn" data-icon="check" value="Confirm" id="b12">
                            <span class="available" id="e09"><?php echo $proceed2;?></span>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
 </main>
 <?php include "footer.php"; ?>
    </div>  
    </body>         
</html>