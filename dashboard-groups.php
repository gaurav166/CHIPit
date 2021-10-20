<?php 
  session_start();
  include_once("configure/configure.php");
  $userid=$_SESSION['userid'];
  $user=$_SESSION['username'];
  $profile=$_SESSION['userprofile'];
  $mail=$_SESSION['usermail'];
  $disable=false;
  if($userid == "")
  {
    header("location: index.php");
  } 


?>
  <?php  
   if(isset($_SESSION['userid'])){
   $disable = true;
 }

  ?>
</script>
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
          <i class="fa fa-users bulletpt" aria-hidden="true"></i>
        </div>
        <div class="pull-left cnt-txt">groups</div>
        <button id="btnaddfrnd" class="pull-right" data-toggle="modal" data-target="#scaleModal1" value=""<?=($disable ? " disabled=\"disabled\"" : "");?>/>+ create group</button>
      </div>
    </div>
    <!-- groups section starts here -->
    <div class=container style="margin-top:55px;">
      <div class="row">
        <div class="col-md-4 white cnt-details grp-details scrollbar scrollbar-secondary" style="height:450px;">
          <div style="width:100%;" id="grp-lst">  
            
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
<script>
  $(document).ready(function(){
     $.ajax({
               url:'ajaxcall/groupfetch.php',
               type:'post',
               success:function(responsedata){
                $('#grp-lst').html(responsedata);
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