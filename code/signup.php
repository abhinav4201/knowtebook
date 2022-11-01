<?php
    require_once 'header.php';
    $error = $user = $pass =$fname=$sname=$email=$city=$state=$country=$gender=$ads=$edu=$pro=$elec=$fas=$food=$jobs=$tick=$hot=$hos=$pha=$cars=$cab=$art=$ent=$gro=$ast=$mark=$all= "";
    if (isset($_SESSION['user'])) destroySession();
    if ($loggedin){
        die(header('location:search.php'));
    }
    else{
        echo <<<_GUEST
            <div data-role='page' id='term' data-url='term'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
            <a href="index.php" class='icon pos01' data-role="button" data-inline="true" data-icon="back" data-iconpos="notext">&#9756;</a><div id='head'>(Sign up to Search Notes)</div></div></header>
         _GUEST;
    }
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if(empty($_SESSION['6_letters_code'] ) ||
	            strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
            {
                $error="Number does not match";
        }else {
        if (isset($_POST['user']))
        {
            $user = sanitizeString($_POST['user']);
            $pass = sanitizeString($_POST['pass']);
            $pass = password_hash($pass,PASSWORD_DEFAULT);
            $fname= sanitizeString($_POST['fname']);
            $sname= sanitizeString($_POST['surname']);
            $email= sanitizeString($_POST['email']);
            $city = sanitizeString($_POST['city']);
            $state= sanitizeString($_POST['state']);
            $country=sanitizeString($_POST['country']);
            if(isset($_POST['gender']))
            $gender=sanitizeString($_POST['gender']);
            $ads = sanitizeString($_POST['ads']);
            if(isset($_POST['education']))
            $edu = sanitizeString($_POST['education']);
            if(isset($_POST['property']))
            $pro = sanitizeString($_POST['property']);
            if(isset($_POST['electronics']))
            $elec= sanitizeString($_POST['electronics']);
            if(isset($_POST['fashion']))
            $fas = sanitizeString($_POST['fashion']);
            if(isset($_POST['food']))
            $food= sanitizeString($_POST['food']);
            if(isset($_POST['jobs']))
            $jobs= sanitizeString($_POST['jobs']);
            if(isset($_POST['ticket']))
            $tick=sanitizeString($_POST['ticket']);
            if(isset($_POST['hotel']))
            $hot = sanitizeString($_POST['hotel']);
            if(isset($_POST['hospital']))
            $hos = sanitizeString($_POST['hospital']);
            if(isset($_POST['pharmacy']))
            $pha = sanitizeString($_POST['pharmacy']);
            if(isset($_POST['cars']))
            $cars= sanitizeString($_POST['cars']);
            if(isset($_POST['cab']))
            $cab = sanitizeString($_POST['cab']);
            if(isset($_POST['artist']))
            $art = sanitizeString($_POST['artist']);
            if(isset($_POST['entertainment']))
            $ent = sanitizeString($_POST['entertainment']);
            if(isset($_POST['grocery']))
            $gro = sanitizeString($_POST['grocery']);
            if(isset($_POST['astrology']))
            $ast = sanitizeString($_POST['astrology']);
            if(isset($_POST['marketing']))
            $mark= sanitizeString($_POST['marketing']);
            if(isset($_POST['all']))
            $all = sanitizeString($_POST['all']);
            if ($user == "" || $pass == "")
            $error = 'Not all fields were entered<br><br>';
            else
            {
                $result = queryMysql("SELECT * FROM members WHERE username='$user'");
                if ($result->num_rows)
                {$error = 'That username already exists<br><br>';}
                else 
                {$result2= queryMysql("SELECT * FROM `profiles` WHERE email='$email'");
                if($result2->num_rows)
                {$error='That email is already registered';}
                else
                {
                    if(strlen($pass) < 6 && (!preg_match("/[a-z]/", $pass) ||
                                             !preg_match("/[A-Z]/", $pass) ||
                                             !preg_match("/[0-9]/", $pass)))
                    {
                        $error="Passwords must be at least 6 characters<br>";
                        $error.="Passwords require 1 each of a-z, A-Z and 0-9<br>";
                    }
                    elseif(!((strpos($email, ".") > 0) &&
                            (strpos($email, "@") > 0)) ||
                             preg_match("/[^a-zA-Z0-9.@_-]/", $email))
                    {
                        $error="The Email address is invalid<br>";
                    }
                    else
                    {
                        /*check ip */
                        $ip = getIPAddress();
                        $ips=queryMysql("SELECT * FROM `ip address` WHERE `address`='$ip'");
                        if($ips->num_rows==0)
                        {
                            /*queryMysql("INSERT INTO `otp_expiry`(`username`, `otp`, `is_expired`, `create_at`) VALUES ('$user','$otp','0',NOW())");*/
                            queryMysql("INSERT INTO `ip address`( `username`, `address`) VALUES ('$user','$ip')");
                            if(isset($_POST['coupon']))
                            {
                                $cop=sanitizeString($_POST['coupon']);
                                if($cop!="")
                                {
                                    queryMysql("INSERT INTO `coupon used`( `username`, `coupon`, `used date`) VALUES ('$user','$cop',NOW())");
                                }
                            }
                            $ran=rand(0,10000);
                            $copn=$user.$ran;
                            $re=queryMysql("SELECT * FROM `coupon` WHERE `username`='$user'");
                            if(($re->num_rows)==0)
                            {
                                queryMysql("INSERT INTO `coupon`( `username`, `coupon`, `create date`) VALUES ('$user','$copn',NOW())");
                            }
                            queryMysql("INSERT INTO members VALUES(NULL,'$user', '$pass')");
                            queryMysql("INSERT INTO profiles VALUES ('$user','$fname','$sname','$email','$city','$state','$country','$gender','$ads',NOW())");
                            queryMysql("INSERT INTO `profile count`(`username`) VALUES ('$user')");
                            queryMysql("INSERT INTO `clocation`(`username`, `city`, `state`, `country`) VALUES('$user','$city','$state','$country')");
                            if($ads=='yes')
                            {
                                if(($edu == "") && ($pro == "") && ($elec=="") && ($fas == "") && ($food== "") && ($jobs== "") && ($tick== "") && ($hot == "") && ($hos == "") && ($pha =="") && ($cars=="") && ($cab == "") && ($art == "") && ($ent == "") && ($gro == "") && ($ast == "") && ($mark== "") && ($all =="")) 
                                {
                                    queryMysql("INSERT INTO `adchoice`(`username`,`everything`) VALUES ('$user','yes')");
                                }
                                else{
                                    queryMysql("INSERT INTO `adchoice`(`username`, `education`, `property`, `electronics`, `fashion`, `food`, `jobs`, `ticket`, `hotel`, `hospital`, `pharmacy`, `cars`, `cabs`, `artist`, `entertainment`, `grocery`, `astrology`, `marketing`, `everything`) VALUES ('$user','$edu','$pro','$elec','$fas','$food','$jobs','$tick','$hot','$hos','$pha','$cars','$cab','$art','$ent','$gro','$ast','$mark','$all')");
                                }
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
                                queryMysql("INSERT INTO `adchoice`(`username`,`everything`) VALUES ('$user','yes')");/*remove when subscription is activated */
                                $_SESSION['user'] = $user;
                                $_SESSION['pass'] = $pass;
                                /*die(header('location:subscription.php')); payment method*/
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
                        }
                        else{
                            $error="One IP One Account Policy.";
                        }
                    }
                }
                }
            }
        }}
    }
?>
    <main>
    <div data-role="main" id="main01" class="ui-content">
        <div id="bgimg2" style="background-image: url(images/notebook\ icon.svg);" ></div>
        <div class="cnt05">
            <div id="head04">
                <p id="top05">
                    <a href=""> SiGn Up </a>
                </p>
            </div> 
            <div id="body05">
                <form data-ajax="false" class="c05" onLoad="clearForm()" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="POST"><?php echo "<div class='error'>$error</div>"; ?>
                    <div class="pad04" id="flx05">
                        <input type="text" name="fname" id="nam05" class="input" aria-label="first name" placeholder="First Name" required autofocus>
                        <input type="text" name="surname" id="sname05" class="input" aria-label="surname" placeholder="Surname" required>
                    </div>
                    <div class="inf04">
                        <input type="text" name="user" id="user02" class="input" aria-label="username" placeholder="Username *" required onKeyup="checkUser(this)" maxlength="50">
                        <input type="password" name="pass" id="pass02" class="input" aria-label="password" placeholder="Password *" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" required autocomplete="on" onKeyup="checkPass(this)" maxlength="15" title="Must contain at least one number and one uppercase and lowercase and more than 6 character">
                        <div id="used">&nbsp;</div>
                        <div id="used2">&nbsp;</div>
                        <input type="email" name="email" id="eml05" class="input" aria-label="email" placeholder="Email *" required onKeyup="checkEmail(this)">
                        <div id="used3"><span>Keep id safe for Clean slate update</span></div>
                    </div>
                    <div id="loc03" aria-label="location">Location *</div>
                    <div id="loc02">
                        <input type="text" aria-label="city" name="city" id="city02" class="input" placeholder="City" required>
                        <input type="text" name="state" aria-label="state" id="state02" class="input" placeholder="State" required>
                        <select id="country" name="country" class="input">
                            <?php 
                                $op=array("Afghanistan","Åland Islands","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Congo, The Democratic Republic of The","Cook Islands","Costa Rica","Cote D'ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-bissau","Guyana","Haiti","Heard Island and Mcdonald Islands","Holy See (Vatican City State)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran, Islamic Republic of","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of","Kuwait","Kyrgyzstan","Lao People's Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, The Former Yugoslav Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestinian Territory, Occupied","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and The Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and The South Sandwich Islands","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan, Province of China","Tajikistan","Tanzania, United Republic of","Thailand","Timor-leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Viet Nam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");
                                $re="India";
                                foreach($op as $c)
                                {
                                    if($re==$c){
                                        echo '<option value="'.$c.'"selected>'.$c.'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$c.'">'.$c.'</option>';
                                    }
                                }
                            ?> 
                        </select>
                    </div>
                    <fieldset data-role="controlgroup" data-type="horizontal" id="gndr">
                        <legend aria-label="select gender"> Gender</legend>
                        <label for="gen05">Purusha</label><input type="radio" aria-label="purusha" name="gender" id="gen05" value="Purusha">
                        <label for="gen06">Prakriti</label><input type="radio" name="gender" aria-label="prakriti" id="gen06" value="Prakriti">
                        <label for="gen07">Ardhanarishvara</label><input type="radio" name="gender" aria-label="ardhanarishvara" id="gen07" value="Ardhanarishvara">
                    </fieldset>
                    <div id="ads02">
                        <div aria-label="select advertisment choice">Advertisement *</div>
                        <select name="ads" id="ads02" data-role="flipswitch" class="input" onChange="checkAd(this)">
                            <option value="yes" aria-label="yes">Category</option>
                            <!--<option value="no" selected aria-label="no">No</option>-->
                            <option value="all" selected aria-label="all">All</option>
                        </select>
                    </div>
                    <div id="ads03"><span class="available"><p id="ads04">* You can even select ads category</p></span></div>
                    <div id="cpcha400"><label for="cpcha401"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ></label><input type="text" name="6_letters_code" id="cpcha401" class="input" placeholder="Captcha" required>
                        <small>click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small>
                    </div>
                    <div id="coup1"><label for="coup2"></label><input type="text" name="coupon" aria-label="coupon" id="coup2" class="input" placeholder="Coupon Code"></div>
                    <div id="term05"><p>By clicking sign up, you agree to our <a href="term.php?content=term">Terms</a>.</p></div>
                    <button id="b09" name="submit" class="ui-btn" data-role="button" data-icon="plus" type="submit" aria-label="signup">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
    </main>
        <?php include "footer.php"; ?>
    </div>
    </body>         
</html>
