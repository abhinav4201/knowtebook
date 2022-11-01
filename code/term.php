<?php
    require_once 'header.php';
    if(isset($_REQUEST['content']))
    {
        $cnt= sanitizeString($_REQUEST['content']);
    }
    if($cnt=="term")/*term */
    {
        echo <<<_GUEST
            <div data-role='page' id='signup' data-url='signup'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
            <a href="signup.php" class='icon pos01' data-role="button" data-inline="true" data-icon="back" data-iconpos="notext">&#9756;</a><div id='head' style="font-size:28px;">RULEBOOK</div></div></header>
        _GUEST;
    }
    elseif($cnt=="data")/*data policy */
    {
        echo <<<_GUEST
            <div data-role='page' id='signup' data-url='signup'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
            <a href="signup.php" class='icon pos01' data-role="button" data-inline="true" data-icon="back" data-iconpos="notext">&#9756;</a><div id='head'>DATA POLICY</div></div></header>
        _GUEST;
    }
    else /*cookie policy */
    {
        echo <<<_GUEST
            <div data-role='page' id='signup' data-url='signup'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
            <a href="signup.php" class='icon pos01' data-role="button" data-inline="true" data-icon="back" data-iconpos="notext">&#9756;</a><div id='head'>COOKIE POLICY</div></div></header>
        _GUEST;
    }
?>
<?php if($cnt=="data")/*data*/
    { ?>
    <main>
        <div data-role="main" id="main01" class="ui-content">
            <div id="bgimg2" style="background-image: url(images/notebook\ icon.svg);" ></div>
            <div class="cnt1200">
                <section id="dt1200">

                </section>
            </div>
        </div>
    </main>
        <?php include "footer.php"; ?>
    </div>
    </body>         
    </html>
    <?php }
?>
<?php if($cnt=="cookie")/*cookie*/
    { ?>
    <main>
        <div data-role="main" id="main01" class="ui-content">
            <div id="bgimg2" style="background-image: url(images/notebook\ icon.svg);" ></div>
            <div class="cnt1200">
                
            </div>
        </div>
    </main>
        <?php include "footer.php"; ?>
    </div>
    </body>         
    </html>
    <?php }
?>
<?php if($cnt=="term")/*term*/
    { ?>
    <main>
        <div data-role="main" id="main01" class="ui-content">
            <div id="bgimg2" style="background-image: url(images/notebook\ icon.svg);" ></div>
            <div class="cnt1200">
                <fieldset id="tm1200">
                    <p style="font-size:20px;text-shadow: 1px 0px 2px black;">DATA POLICY</p>
                    <ul id="tm1201">
                        <li>Every action taken is stored in the database (for ex- support, disapproved, comment, sponsor, purchased item etc), and will be reflected in the profile.</li>
                        <li>Personal information can be removed from database, except email id as it is the only means of communication.</li>
                        <li>You are not allowed to delete your profile as the data collected from each profile is used to help other.</li>
                        <li>We don't collect your device and other privacy information.</li>
                    </ul>
                    <p style="font-size:20px;text-shadow: 1px 0px 2px black;">COOKIE POLICY</p>
                    <ul id="tm1202">
                        <li>Cookies are used to store your login information and to redirect url.</li>
                    </ul>
                    <p style="font-size:20px;text-shadow: 1px 0px 2px black;">TERM</p>
                    <ul id="tm1203">
                        <li>This is a one way networking website, you can not undo your error.</li>
                        <li>Copy paste of notes are not allowed.</li>
                        <li>Purchasing some notes or studying in institute does not give you right to sell their notes on this platform.</li>
                        <li>Notes published should be original content without any copyright issue.</li>
                        <li>If anyone found using someone else notes can be reported using the tool provided and will be removed instantly.</li>
                        <li>Reporting tool should be used with proper reason as failing may cause legal issue.</li>
                        <li>1 Ip is allowed to make 1 account linked with unique email and username (making different account to increase views will be treated illegal).</li>
                        <li>Every user need to complete the criteria to start selling their notes (compiled together in the form of course).</li>
                    </ul>
                </fieldset>
            </div>
        </div>
    </main>
        <?php include "footer.php"; ?>
    </div>
    </body>         
    </html>
    <?php }
?>