<?php
 require_once 'header.php';
 if (isset($_SESSION['user']))
 {
 destroySession();
 if(isset($_COOKIE['post'])){
    $cnt= sanitizeString($_COOKIE['post']);
    setcookie('post',$cnt,time()-60*15,'/');
 }
 if(isset($_COOKIE['research'])){
    $cnt= sanitizeString($_COOKIE['research']);
    setcookie('research',$cnt,time()-60*15,'/');
 }
 die(header('location:index.php'));
 }
 else echo "<div class='center'>You cannot log out because
 you are not logged in</div>";
?>
 </div>
 </body>
</html>