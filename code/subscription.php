<?php
 require_once 'header.php';
 if (isset($_SESSION['user']))
 {
 destroySession();
 echo "<div data-role='page' id='subscription' data-url='subscription'><br><div class='center'> this is subscription page You have been logged out. Please
 <a data-transition='slide' href='index.php'>click here</a>
 to refresh the screen.</div>";
 }
 else echo "<div class='center'>You cannot pay because
 you are not logged in</div>";
?>
 </div>
 </body>
</html>