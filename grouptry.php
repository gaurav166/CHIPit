<?php 
if($_SESSION['userid'] == "")
  {
    header("location: index.php");
  } 
  session_start();
  include_once("configure/configure.php");
  $userid=$_SESSION['userid'];
  $user=$_SESSION['username'];
  $profile=$_SESSION['userprofile'];
  $mail=$_SESSION['usermail'];
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
      <link rel="stylesheet" type="text/css" href="js/bootstrap.js">
      <!-- <link rel="stylesheet" type="text/css" href="js/jquery-3.3.1.min.js"> -->
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
					<i class="fa fa-users bulletpt" aria-hidden="true"></i>
				</div>
				<div class="pull-left cnt-txt">groups</div>
        <button id="btnaddfrnd" class="pull-right" data-toggle="modal" data-target="#scaleModal1">+ create group</button>
      </div>
		</div>
    <!-- groups section starts here -->
		<div class=container style="margin-top:55px;">
			<div class="row">
				<div class="col-md-4 white cnt-details grp-details scrollbar scrollbar-secondary" style="height:450px;">
          <div style="width:100%;">  
            <?php group_fetch($userid); ?>
          </div>  
        </div>
        <!-- groups description starts here -->
        <div class="col-md-7 white grp-wrapper" id="grp-info">
            <label style="margin-left:252px;margin-top:205px;">No group selected</label>
        </div>
        <!-- group description ends here --> 
      </div>
      <!-- row ends here -->
    </div>
    <!-- groups section ends here -->
  </div>
</div>
<!-- Content Ends Here -->

  <?php 
    include_once("includes/addfriend.php");
    include_once("includes/creategroup.php");
    include_once("includes/addexpenses.php");
    // include_once("includes/member-dialog.php");
  ?>
</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript">
  function groupdata(gid){
    $.ajax({
    url: "ajaxcall/groupdata.php?gid="+gid,
    success: function(response) {
      $('#grp-info').html(response);
      }
    });
  }
</script>
</html>

<!-- function fetch -->
<!-- 
function groupFetch($userid){
        $conn=mysqli_connect('localhost','root','','chipit') or die("error");
      $avtar="groups/";
      $i=0;
      $show="SELECT * from groups";
      $showexe=mysqli_query($conn,$show);
      while($row =  mysqli_fetch_assoc($showexe))
      {
              
          $res=explode(',', $row['group_member']);
          foreach ($res as $value)
          {
               if($userid==$value)
               {
                echo '
                  <div onclick="groupdata('.$row['group_id'].')" class="grp-area">  
                  <div class="pull-left grp-img">
                      <img src="'.$avtar.$row['avtar'].'" width="43" height="44" class="img-circle pull-left">
                  </div>
                  <div class="pull-left grp-txt">
                    '.$row['group_name'].'
                
                  </div>
                  <div class="negative-bal grp-balance pull-right">'.$row['group_id'].'</div>
                        <div class="clearfix"></div>
              </div>
                ';

               }
          }
              
      }
  } -->