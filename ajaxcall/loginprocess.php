<?php 
  $conn=mysqli_connect('localhost','root','','chipit') or die("error");
  session_start();
  if($_SESSION['userid'] == "")
  {
    header("location: index.php");
  } 
  $email=$_POST['emailphp'];
  $password=$_POST['pasphp'];
      $qry="SELECT * from user where user_mail='$email' and password='$password'";
      $exe=mysqli_query($conn,$qry);
      $tot=mysqli_num_rows($exe);
      if($tot>0)
      {
         $fetch=mysqli_fetch_array($exe);
        $file=$fetch['user_profile'];
        $target_dir = "profiles/";
        $_SESSION['userid']=$fetch['user_id'];
        $_SESSION['username']=$fetch['user_name'];
        $_SESSION['userprofile']=$target_dir.$file;
        $_SESSION['usermail']=$fetch['user_mail'];
        $_SESSION['guest']=0;
      echo '<script>window.location="dashboard.php"</script>';
      }
      else
      {
        echo "Invalid credientials";
      }

 ?>