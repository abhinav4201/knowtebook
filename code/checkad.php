<?php
    require_once 'functions.php';
    if (isset($_POST['ads']))
    {
        $ads = sanitizeString($_POST['ads']);
        if ($ads=="yes")
        echo <<<_AD
            <div id='adchoice'>
                <label for='education'>Education</label><input type='checkbox' name='education' id='education' value='yes'>
                <label for='property'>Property</label><input type='checkbox' name='property' id='property' value='yes'>
                <label for='electronics'>Electronics</label><input type='checkbox' name='electronics' id='electronics' value='yes'>
                <label for='fashion'>Fashion</label><input type='checkbox' name='fashion' id='fashion' value='yes'>
                <label for='food'>Food</label><input type='checkbox' name='food' id='food' value='yes'>
                <label for='jobs'>Jobs</label><input type='checkbox' name='jobs' id='jobs' value='yes'>
                <label for='ticket'>Ticket</label><input type='checkbox' name='ticket' id='ticket' value='yes'>
                <label for='hotel'>Hotels</label><input type='checkbox' name='hotel' id='hotel' value='yes'>
                <label for='hospital'>Hospital</label><input type='checkbox' name='hospital' id='hospital' value='yes'>
                <label for='pharmacy'>Pharmacy</label><input type='checkbox' name='pharmacy' id='pharmacy' value='yes'>
                <label for='cars'>Cars</label><input type='checkbox' name='cars' id='cars' value='yes'>
                <label for='cab'>Cab</label><input type='checkbox' name='cab' id='cab' value='yes'>
                <label for='artist'>Artist</label><input type='checkbox' name='artist' id='artist' value='yes'>
                <label for='entertainment'>Entertainment</label><input type='checkbox' name='entertainment' id='entertainment' value='yes'>
                <label for='grocery'>Grocery</label><input type='checkbox' name='grocery' id='grocery' value='yes'>
                <label for='astrology'>Astrology</label><input type='checkbox' name='astrology' id='astrology' value='yes'>
                <label for='marketing'>Marketing</label><input type='checkbox' name='marketing' id='marketing' value='yes'>
                <label for='all'>All</label><input type='checkbox' name='all' id='all' value='yes'>
            </div>
        _AD;
        else
        echo "<span class='available'><p>* You can even select ads category</p></span>";
    }
    $connection->close();
?>