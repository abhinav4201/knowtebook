<?php
    require_once 'header.php';
    echo <<<_GUEST
        <div data-role='page' id='readme' data-url='readme'><header><div data-role="header" data-theme="a" class='info' id='header' data-fullscreen="true" data-position="fixed">
        <a href="index.php" class='icon pos01' data-role="button" data-inline="true" data-icon="back" data-iconpos="notext">&#9756;</a><div id='head' style="font-size:28px;">WHY?</div></div></header>
    _GUEST;
?>
    <main>
        <div data-role="main" id="main01" class="ui-content">
            <div id="bgimg2" style="background-image: url(images/notebook\ icon.svg);" ></div>
            <p style="text-align:center;font-size:25px;text-decoration:underline;">KNOWLEDGE TO EXCHANGE BOOK</p>
            <div class="cnt1300" style="position:relative;">
                <div id="f1">
                    <button id="bt1300" autofocus onClick="togFirst()">VISION</button>
                    <button id="bt1301" onClick="togSec()">WHO THIS FOR</button>
                    <button id="bt1302" onClick="togThird()">HOW THIS WORKS</button>
                </div>
                <div id="f5"><!-- content -->
                    <div id="f2" style="display:block;"><!--Vision-->
                        <li>To help people earn while they learn new topic.</li>
                        <li>People will learn the same topic with different perspective.</li>
                        <li>Age or other physical barrier should not stop individual from learning and moulding your career to new direction.</li>
                        <li>People will choose the best guide whose teaching will help him in improving his knowledge ( anyone can teach anyone and anyone can learn from anyone all across the globe).</li>
                        <li>Notebook will become your practice book (reducing paper work).</li>
                        <li>To make each individual independent.</li>
                        <li>Talent is nothing but daily practice, notebook will help in developing skill.</li>
                    </div>
                    <div id="f3" style="display:none;"><!--WHO-->
                        <li>Notebook aims to help homemaker who left their education and career for their family.</li>
                        <li>Who want to change their career but scared to do so.</li>
                        <li>Student who is preparing for higher education or better profession.</li>
                        <li>Another source of income for people who retired from their job.</li>
                        <li>People who are stopped for further education due to low source of income.</li>
                        <li>Professionals like scientist, doctor, officer,author, lawyer, teacher, engineer and many more, who gave his entire life dedicating to one profession, its time to pass on your emmence knowledge to next generation.</li>
                    </div>
                    <div id="f4" style="display:none;"><!--HOW-->
                        <li>You read some topic, concise that topic in your own words, publish in the home section. Once you hit the milestone (next point) you then compile these short/long/elaborated notes together into one course, set your own price for the course from insider tab which our readers will buy.</li>
                        <li>Milestone is the minimum criteria that every user need to complete before they start selling their courses. Every user should have unique number of profile visit, notes/research paper view and should comment to help other people (details in insider tab).</li>
                        <li>User will post their requirement, which will be reflected in indemand tab based on which you can either learn new topic or if you have knowledge regarding the topic you can publish notes and can comment your notes link to comment section or start group discussion in the comment section which will help increasing your milestone.</li>
                        <li>R & D tab is the section where you can learn about new research by reading the research paper.</li>
                        <li>If any note provide any knowledge to you, you support the note (clicking correct button) or if you think there is contradiction you disapprove ( by clicking wrong button).</li>
                        <li>Supported notes or research paper will be reflected in likednotes tab.</li>
                        <li>Only creator can either delete or report a comment or user.</li>
                        <li>When you report any 10 user your milestone will be reduced by 1 and when someone report you your milestone will be reduced by twice the count.</li>
                        <li>If you like someone's notes you can sponsor them and then you will get all his update.</li>
                        <li>If any user found copying some notes or using someone else notes, can report it directly and that notes will be taken down, then our team will take necessary action, failing to communicate in solving the dispute will be treated illegal.</li>
                        <li><span id='veri'>&#x2714;</span> - can sell notes. (member for min 6 month and milestone approved) </li>
                        <li><span id='verified'>&#x2714;</span> - verified - can sell notes, take live class (member for min 1 year, user verified) </li>
                    </div>
                </div>
            </div>
        </div>
    </main>
        <?php include "footer.php"; ?>
    </div>
    </body>         
    </html>