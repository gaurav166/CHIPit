<?php
	$conn=mysqli_connect('localhost','root','','chipit') or die("error");
    session_start();
    $userid=$_SESSION['userid'];
    $mail=$_SESSION['usermail'];
    $name=$_POST['name'];
    $number=$_POST['no'];
    $pass=$_POST['ps'];
    
    
    
    if($name!="")
    {
    	echo $name;
    	$up="UPDATE user,friends set user_name='".$name."',frnd_name='".$name."' where user_mail='".$mail."' && frnd_mail='".$mail."'";
    	$exe=mysqli_query($conn,$up);
    	 if($up)
    	{
    		unset($_SESSION['username']);
    		$_SESSION['username']=$name;
    	}
    }
    if($number!="")
    {
    	$up2="UPDATE user set user_no='".$number."' where user_mail='".$mail."'";
    	$exe2=mysqli_query($conn,$up2);
    }
    if($pass!="")
    {
    	$up3="UPDATE user set password='".$pass."' where user_mail='".$mail."'";
    	$exe3=mysqli_query($conn,$up3);

    }
	echo "Profile uploaded"; 
?>