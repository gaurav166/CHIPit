<?php 
	$conn=mysqli_connect('localhost','root','','chipit') or die("error");
	session_start();
	$name=$_POST['guestname'];
  $current_date = date("Y-m-d");
  $file_name="default.png";
  $target_file="profiles/".$file_name;
  $random=rand(000,999);
  $guest="Guest".$random;
	    	$qry="INSERT into guest set guest_name='".$guest.$name."',
	                             		guest_profile='".$file_name."',
	                             		guest_join='".$current_date."'";
	        mysqli_query($conn,$qry);
	        $_SESSION['username']=$guest.$name;
	        $_SESSION['userprofile']=$target_file;
	        $_SESSION['usermail']=" ";
	        $_SESSION['guest']=1;
	        $uidqry="SELECT * FROM guest WHERE guest_name='".$guest.$name."'";
	        $uidexe=mysqli_query($conn,$uidqry);
	        $uidfetch=mysqli_fetch_array($uidexe);
	        $_SESSION['userid']=$uidfetch['guest_id'];
	        if($qry)
		      {
            echo '<script>window.location="dashboard-groups.php"</script>';
		      }
?>