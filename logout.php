<?php
	session_start();
	if($_SESSION['userid'] == "")
  	{
    	header("location: index.php");
  	} 
	unset($_SESSION['username']);
	unset($_SESSION['userprofile']);
	unset($_SESSION['usermail']);
	unset($_SESSION['userid']);
	unset($_SESSION['guest']);
	echo '<script>window.location="index.php"</script>';
?>