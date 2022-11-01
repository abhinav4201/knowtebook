<?php
    require_once 'header.php';
    if (!$loggedin)
        die(header('location:index.php'));
        $error="";
?>
<?php 
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        if (isset($_POST['change']))
        {
            $un = sanitizeString($_POST['user']);
            /*$em = sanitizeString($_POST['email']);*/
            $re = queryMysql("SELECT * FROM `profiles` WHERE `username`='$un'");
            if($re->num_rows){
                $error= "That username already exists";
            }
            else {
                /*$re = queryMysql("SELECT * FROM `profiles` WHERE `email`='$em'");
                if($re->num_rows){
                $error= "That email is already registered";
                }
                else{ uncomment when the email changing will be given*/
                    profile("first name",$user);
                    profile("surname",$user);
                    /*profile("email",$user);*/
                    cLoc("city",$user);
                    cLoc("state",$user);
                    cLoc("country",$user);
                    profile("gender",$user);
                    cLoc("address",$user);
                    cLoc("zip",$user);
                    /*username("user",$user); */
                }
            /*} after changing email option will be given*/
            die(header('location:setting.php'));
        }
        if (isset($_POST['update']))
        {
            $ad = sanitizeString($_POST['ads']);
            if($ad=="yes")
            {
                profile("ads",$user);
                /*queryMysql("DELETE FROM `adchoice` WHERE `username`='$user'"); for allowing remove choices*/
                $re=queryMysql("SELECT * FROM `adchoice` WHERE `username`='$user'");
                if($re->num_rows==0)
                {
                    queryMysql("INSERT INTO `adchoice`(`username`) VALUES ('$user')");
                }
                adchoice("education",$user);
                adchoice("property",$user);
                adchoice("electronics",$user);
                adchoice("fashion",$user);
                adchoice("food",$user);
                adchoice("jobs",$user);
                adchoice("ticket",$user);
                adchoice("hotel",$user);
                adchoice("hospital",$user);
                adchoice("pharmacy",$user);
                adchoice("cars",$user);
                adchoice("cabs",$user);
                adchoice("artist",$user);
                adchoice("entertainment",$user);
                adchoice("grocery",$user);
                adchoice("astrology",$user);
                adchoice("marketing",$user);
                adchoice("everything",$user);
            }
            else
            {
                profile("ads",$user);
                queryMysql("DELETE FROM `adchoice` WHERE `username`='$user'");
                queryMysql("INSERT INTO `adchoice`(`username`,`everything`) VALUES ('$user','yes')");/*remove when subscription is activated */
                /*queryMysql("DELETE  FROM `adchoice` WHERE `username`='$user'");
                die(header('location:subscription.php'));*/
            }
            die(header('location:setting.php'));
        }
    }
?>
<?php
    $resultP = queryMysql("SELECT * FROM `profiles` WHERE `username`='$user'");
    if($resultP->num_rows)
    {
        $rowP = $resultP->fetch_array(MYSQLI_ASSOC);
    }
    $resultL = queryMysql("SELECT * FROM `clocation` WHERE `username`='$user'");
    if($resultL->num_rows)
    {
        $rowL = $resultL->fetch_array(MYSQLI_ASSOC);
    }
?>
    <div data-role="page" id="" data-url="">
        <header><div data-role="header" data-fullscreen="true" class="info" id="header" data-position="fixed">
            <h1 id="hh1"><?php echo $userstr;?></h1>
            <a href="javascript:void(0)" onClick="openNav()" aria-label="menu" class="icon pos01" data-icon="bars" data-iconpos="notext">&#9776;</a>
            </div>
        </header>
        <main>      
            <div data-role="main" id="main01" class="ui-content jqm-fullwidth jqm-content">
                <div id='bgimg2' style="background-image: url(images/notebook\ icon.svg);"></div>
                <div class="overlay" data-theme="a" id="myNav">
                    <div class="overlay2">
                        <a href="javascript:void(0)" onClick="closeNav()" class="closebtn">&times;</a>
                        <div id="photo301"><?php if (file_exists("uploads/$user.jpg"))
                                                    echo "<img id='photo301' src='uploads/$user.jpg'>";
                                                else echo "<span id='pho302'>Please upload pic</span>";?></div>
                        <div><h1><?php echo $user;?></h1></div>
                        <a href="editprofile.php" aria-label="edit profile" data-icon="edit">Edit Profile</a>
                        <a href="home.php" aria-label="home" data-icon="home">Home</a>
                        <a href="search.php" aria-label="search" data-icon="search">search Notes</a>
                        <a href="postrequire.php" aria-label="post requirement" data-icon="edit">Post Requirement</a>
                        <a href="yourrequire.php" aria-label="your requirement" data-icon="comment">Your Requirement</a>
                        <a href="indemand.php" aria-label="In Demand" data-icon="search">In Demand</a>
                        <a href="rd.php" aria-label="R&D" data-icon="search">R & D</a>
                        <a href="postrd.php" aria-label="post research" data-icon="edit">Post Research</a>
                        <a href="yourrd.php" aria-label="your research paper" data-icon="comment">Your Research Paper</a>
                        <a href="likednotes.php" aria-label="liked notes" data-icon="heart">Liked Notes</a>
                        <a href="purchased.php" aria-label="purchased courses" data-icon="heart">Purchased Courses</a>
                        <a href="insider.php"  aria-label="insider"data-icon="info">Insider</a>
                        <a href="setting.php" aria-label="setting" data-icon="gear">Setting</a>
                        <a href="createad.php" aria-label="create ad" data-icon="check">Create Ad</a>
                        <a href="logout.php" aria-label="logout" data-icon="refresh">Logout</a>
                    </div>
                </div>
                <div id="fakebox3">
                    <form data-ajax="false" class="c05 c100" action="<?php echo sanitizeString(htmlspecialchars($_SERVER['PHP_SELF']));?>" method="POST"><?php echo "<div class='error'>$error</div>"; ?>
                        <div class="pad04" id="flx06">
                            <input type="text" name="first name" id="nam05" class="input" aria-label="first name" placeholder="<?php echo $rowP['first name'];?>">
                            <input type="text" name="surname" id="sname05" class="input" aria-label="surname" placeholder="<?php echo $rowP['surname'];?>">
                        </div>
                        <!--<div class="inf04"> uncomment when email changing will be allowed
                            <input type="email" name="email" id="eml05" class="input" aria-label="email" placeholder="<?php /*echo $rowP['email'];*/?>" onKeyup="checkEmail(this)">
                            <div id="used3"><span>Keep id safe for Clean slate update</span></div>
                        </div>-->
                        <div id="loc03" aria-label="location">Location</div>
                        <div id="loc02"><!--this is disabled -->
                            <input type="text" aria-label="city" name="city" disabled id="city02" class="input" placeholder="<?php echo $rowP['city']?>">
                            <input type="text" name="state" aria-label="state" disabled id="state02" class="input" placeholder="<?php echo $rowP['state']?>">
                            <select id="country" name="country" disabled class="input">
                                <?php 
                                    $op=array("Afghanistan","Åland Islands","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Congo, The Democratic Republic of The","Cook Islands","Costa Rica","Cote D'ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-bissau","Guyana","Haiti","Heard Island and Mcdonald Islands","Holy See (Vatican City State)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran, Islamic Republic of","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of","Kuwait","Kyrgyzstan","Lao People's Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, The Former Yugoslav Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestinian Territory, Occupied","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and The Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and The South Sandwich Islands","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan, Province of China","Tajikistan","Tanzania, United Republic of","Thailand","Timor-leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Viet Nam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");
                                    $re=$rowP['country'];
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
                        <div id="loc03" aria-label="location">Current Location</div>
                        <div id="loc02">
                            <input type="text" aria-label="city" name="city"  id="city02" class="input" placeholder="<?php echo $rowL['city'];?>">
                            <input type="text" name="state" aria-label="state"  id="state02" class="input" placeholder="<?php echo $rowL['state'];?>">
                            <select id="country" name="country"  class="input">
                                <?php 
                                    $op=array("Afghanistan","Åland Islands","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Congo, The Democratic Republic of The","Cook Islands","Costa Rica","Cote D'ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-bissau","Guyana","Haiti","Heard Island and Mcdonald Islands","Holy See (Vatican City State)","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran, Islamic Republic of","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Korea, Democratic People's Republic of","Korea, Republic of","Kuwait","Kyrgyzstan","Lao People's Democratic Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macao","Macedonia, The Former Yugoslav Republic of","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia, Federated States of","Moldova, Republic of","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Palestinian Territory, Occupied","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Helena","Saint Kitts and Nevis","Saint Lucia","Saint Pierre and Miquelon","Saint Vincent and The Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia and The South Sandwich Islands","Spain","Sri Lanka","Sudan","Suriname","Svalbard and Jan Mayen","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan, Province of China","Tajikistan","Tanzania, United Republic of","Thailand","Timor-leste","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Viet Nam","Virgin Islands, British","Virgin Islands, U.S.","Wallis and Futuna","Western Sahara","Yemen","Zambia","Zimbabwe");
                                    $re=$rowL['country'];
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
                            <input type="text" aria-label="address" name="address" onBlur="cAdd()" onKeyUp="Address(this)" id="add02" class="input" placeholder="<?php if(($rowL['address'])==""){echo 'Address';}else{echo $rowL['address'];}?>">
                            <div id="nb100">&nbsp;</div>
                            <input type="number" aria-label="zip" name="zip"  id="zip02" class="input" placeholder="<?php if(($rowL['zip'])==0){echo 'Zip';}else{echo $rowL['zip'];}?>">
                        </div>
                        <fieldset data-role="controlgroup" data-type="horizontal" id="gndr">
                            <legend aria-label="select gender"> Gender</legend>
                            <?php 
                                $a=$b=$c="";
                                $ge = $rowP['gender'];
                                if($ge=="Purusha")
                                    { $a="checked";$b="";$c="";}
                                if ($ge=="Prakriti")
                                    {$a="";$b="checked";$c="";}
                                if ($ge=="Ardhanarishvara")
                                    {$a="";$b="";$c="checked";}
                                echo '<label for="gen05">Purusha</label><input type="radio" aria-label="purusha" name="gender" id="gen05" value="Purusha"'.$a.'>';
                                echo '<label for="gen06">Prakriti</label><input type="radio" name="gender" aria-label="prakriti" id="gen06" value="Prakriti"'.$b.'>';
                                echo '<label for="gen07">Ardhanarishvara</label><input type="radio" name="gender" aria-label="ardhanarishvara" id="gen07" value="Ardhanarishvara"'.$c.'>';
                            ?>
                        </fieldset>
                        <button id="b100" name="change" class="ui-btn" data-role="button" data-icon="plus" type="submit" aria-label="change">Change</button>
                        <div id="ads10">
                            <div aria-label="select advertisment choice">Advertisement</div>
                            <select name="ads" id="ads02" data-role="flipswitch" class="input" onChange="changeAd(this)">
                                <?php 
                                    $a=$b="";
                                    $ad= $rowP['ads'];
                                    if($ad=="yes"){
                                        $a = "selected";
                                        $b = "";
                                    }
                                    else{
                                        $a = "";
                                        $b = "selected";
                                    }
                                    echo '<option value="yes" aria-label="yes"'.$a.'>Category</option>';
                                    /*echo '<option value="no"  aria-label="no"'.$b.'>No</option>';*/
                                    echo '<option value="all"  aria-label="all"'.$b.'>All</option>';
                                ?>
                            </select>
                        </div>
                        <div id="ads03">
                            <?php 
                                $opt=queryMysql("SELECT `education`, `property`, `electronics`, `fashion`, `food`, `jobs`, `ticket`, `hotel`, `hospital`, `pharmacy`, `cars`, `cabs`, `artist`, `entertainment`, `grocery`, `astrology`, `marketing`, `everything` FROM `adchoice` WHERE `username`='$user'");
                                $ro=$opt->fetch_array(MYSQLI_ASSOC);
                                if($ad=="yes")
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
                                    echo '<span class="available"><p id="ads04">* You can even select ads category</p></span>';/*change when ads choice changed to no */
                                }
                            ?>                           
                        </div>
                        <button id="b09" name="update" class="ui-btn" data-role="button" data-icon="plus" type="submit" aria-label="update">Update</button>
                    </form>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
</div>
</body>
</html>