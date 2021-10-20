<?php 
  session_start();
  include_once("configure/configure.php");
  $userid=$_SESSION['userid'];
  $user=$_SESSION['username'];
  $profile=$_SESSION['userprofile'];
  $mail=$_SESSION['usermail'];
   if ($_SESSION['guest'] == 1) {
 $message = 'Guest cannot access this feature.  Get registered to CHIPit for more.';

    echo "<SCRIPT>
      
        window.location.replace('dashboard-groups.php');
          alert('$message');
    </SCRIPT>";
  }
  if($userid == "")
  {
    header("location: index.php");
  } 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
 	    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  	  	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
  		<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
  		<link rel="stylesheet" type="text/css" href="css/style.css">
	</meta>
</head>
<body id="dashboardbg">
    
    <?php
      // includes header
      include_once("includes/header.php");
      // includes navigation
      include_once("includes/side-nav.php");
    ?>

  	<!-- Dashboard Starts here -->
  	<div class="col-md-11 dbright">
  		<div class="col-md-12 contntheader">
  			<div class="row">
  				<div class="col-md-12">
  					<div class="cnt-bullet pull-left">
  						<i class="fa fa-address-book-o bulletpt" aria-hidden="true"></i>
  					</div>
  					<div class="pull-left cnt-txt">friends</div>
  					<button id="btnaddfrnd" class="pull-right" data-toggle="modal" data-target="#scaleModal">+ add new friends</button>
              
  				</div>
  			</div>
  			<!-- frnd list starts here -->
  			<div class=container style="margin-top:55px;">
  				<div class="row">
  					<div class="col-md-6 white cnt-details scrollbar scrollbar-secondary" style="height:450px;">
  						<table class="frnd-table" id="dashfrnds">
                
  						</table>
  					</div>
  					<div class="col-md-6"></div>
  				</div>
  			</div>
  		</div>
  	</div>
<!-- Content Ends Here -->

<?php 
  include_once("includes/addfriend.php");
?>

</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
  $(document).ready(function(){
    $.ajax({
      url:'ajaxcall/fetchfriends.php',
      type:'post',
      success:function(responsedata){
          $('#dashfrnds').html(responsedata);
      }
     });
    $.ajax({
           url:'includes/yourBalance.php',
           type:'post',
           success:function(responsedata){
              $('#yourbal').html(responsedata);
           }
    });
  });
</script>
</html>