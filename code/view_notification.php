<?php
	session_start();
	require_once 'functions.php';
	$user = $_SESSION['user'];
	$resultU = queryMysql("SELECT * FROM `requirement` WHERE `username`= '$user'");
    if($resultU->num_rows)
    {
        $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
        $is = $rowU['username'];
		$result= queryMysql("SELECT * FROM `comment` WHERE `status`=0 AND `issue username`='$is' ORDER BY `comment id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['issue no'];
			$usr=$row['username'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>New comment on Issue # &nbsp;<a href='yourrequirecmnt.php?content=".$it."'>".$row['issue no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["username"] . "</a></div>";
			echo "</div>";
		}
		queryMysql("UPDATE comment SET status=1 WHERE `issue username`='$is'");
	}
	$resultU = queryMysql("SELECT * FROM `research paper` WHERE `username`= '$user'");
    if($resultU->num_rows)
    {
        $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
        $is = $rowU['username'];
		$result= queryMysql("SELECT * FROM `rcomment` WHERE `status`=0 AND `research username`='$is' ORDER BY `comment id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['research no'];
			$usr=$row['username'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>New comment on Research Paper # &nbsp;<a href='yourrdcmnt.php?content=".$it."'>".$row['research no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["username"] . "</a></div>";
			echo "</div>";
		}
		queryMysql("UPDATE rcomment SET status=1 WHERE `research username`='$is'");
	}
	$resultU = queryMysql("SELECT * FROM `post` WHERE `username`= '$user'");
    if($resultU->num_rows)
    {
        $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
        $is = $rowU['username'];
		$result= queryMysql("SELECT * FROM `pcomment` WHERE `status`=0 AND `post username`='$is' ORDER BY `comment id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['post no'];
			$usr=$row['username'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>New comment on Note # &nbsp;<a href='postcmnt.php?content=".$it."'>".$row['post no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["username"] . "</a></div>";
			echo "</div>";
		}
		queryMysql("UPDATE pcomment SET status=1 WHERE `post username`='$is'");
	}
	/* post status */
	$resultU = queryMysql("SELECT * FROM `sponsor` WHERE `username`= '$user'");
	if($resultU->num_rows)
	{
		$result= queryMysql("SELECT * FROM `sponsor` WHERE `post status`=0 AND `username`='$user' ORDER BY `sp id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['post no'];
			$usr=$row['sponsored'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>New Note # &nbsp;<a href='postcmnt.php?content=".$it."'>".$row['post no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["sponsored"] . "</a></div>";
			echo "</div>";
		}
		queryMysql("UPDATE `sponsor` SET `post status`='1' WHERE `username`='$user'");
	}
	/* research status */
	$resultU = queryMysql("SELECT * FROM `sponsor` WHERE `username`= '$user'");
	if($resultU->num_rows)
	{
		$result= queryMysql("SELECT * FROM `sponsor` WHERE `research status`=0 AND `username`='$user' ORDER BY `sp id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['research no'];
			$usr=$row['sponsored'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>New Research Paper # &nbsp;<a href='yourrdcmnt.php?content=".$it."'>".$row['research no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["sponsored"] . "</a></div>";
			echo "</div>";
		}
		queryMysql("UPDATE `sponsor` SET `research status`='1' WHERE `username`='$user'");
	}
	/* issue status */
	$resultU = queryMysql("SELECT * FROM `sponsor` WHERE `username`= '$user'");
	if($resultU->num_rows)
	{
		$result= queryMysql("SELECT * FROM `sponsor` WHERE `issue status`=0 AND `username`='$user' ORDER BY `sp id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['issue no'];
			$usr=$row['sponsored'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>New Issue # &nbsp;<a href='yourrequirecmnt.php?content=".$it."'>".$row['issue no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["sponsored"] . "</a></div>";
			echo "</div>";
		}
		queryMysql("UPDATE `sponsor` SET `issue status`='1' WHERE `username`='$user'");
	}

	/*ALL NOtification*/

	$resultU = queryMysql("SELECT * FROM `requirement` WHERE `username`= '$user'");
    if($resultU->num_rows)
    {
        $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
        $is = $rowU['username'];
		$result= queryMysql("SELECT * FROM `comment` WHERE `status`=1 AND `issue username`='$is' ORDER BY `comment id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['issue no'];
			$usr=$row['username'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>Comment on Issue # &nbsp;<a href='yourrequirecmnt.php?content=".$it."'>".$row['issue no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["username"] . "</a></div>";
			echo "</div>";
		}
	}
	$resultU = queryMysql("SELECT * FROM `research paper` WHERE `username`= '$user'");
    if($resultU->num_rows)
    {
        $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
        $is = $rowU['username'];
		$result= queryMysql("SELECT * FROM `rcomment` WHERE `status`=1 AND `research username`='$is' ORDER BY `comment id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['research no'];
			$usr=$row['username'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>Comment on Research Paper # &nbsp;<a href='yourrdcmnt.php?content=".$it."'>".$row['research no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["username"] . "</a></div>";
			echo "</div>";
		}
	}
	$resultU = queryMysql("SELECT * FROM `post` WHERE `username`= '$user'");
    if($resultU->num_rows)
    {
        $rowU = $resultU->fetch_array(MYSQLI_ASSOC);
        $is = $rowU['username'];
		$result= queryMysql("SELECT * FROM `pcomment` WHERE `status`=1 AND `post username`='$is' ORDER BY `comment id` DESC");
		while($row=mysqli_fetch_array($result)) 
		{
			$it= $row['post no'];
			$usr=$row['username'];
			echo "<div class='notification-item'>";
			echo "<div class='notification-subject'>Comment on Note # &nbsp;<a href='postcmnt.php?content=".$it."'>".$row['post no']."</a>";
			echo "<br>FROM : &nbsp;<a href='member.php?content=".$usr."'>". $row["username"] . "</a></div>";
			echo "</div>";
		}
	}
	$connection->close();
?>