<?php 
  session_start();
  $userid=$_SESSION['userid'];
  $user=$_SESSION['username'];
  $profile=$_SESSION['userprofile'];
  $mail=$_SESSION['usermail'];
   if ($_SESSION['guest'] == 1) {
 $message = 'Guest cannot access this feature.  Register with chipit for more.';

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
<body id="dashboardbg" class="scrollbar-secondary">
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
            <i class="fa fa-info-circle bulletpt" aria-hidden="true"></i>
          </div>
          <div class="pull-left cnt-txt">profile</div>
          <button id="btnaddfrnd" class="pull-right" data-toggle="modal" data-target="#scaleModal3">edit</button>
        </div>  
      </div>
      <div class="container" style="margin-top:55px;">
        <div class="row" id="prof-info">
    
        </div>              
      </div>
          <!-- row ends here -->
    </div>
        <!-- container ends here -->
  </div>
	<!-- Dashboard Ends here -->


<!-- edit dialog box -->
<div class="modal fade-scale" id="scaleModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
        <div class="log-header">Edit Credentials</div>
        <form role="form" method="post" id="pform">
          <div style="margin-bottom:10px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;" id="gans"></div>
          <label for="name" class="input-text">Name</label>
          <input type="text" name="gname" class="form-control input-sz" placeholder="Type here" autocomplete="off" id="gname"/> 
          <label for="name" class="input-text">Mobile no</label>
          <input type="text" name="no" class="form-control input-sz" placeholder="Type here" autocomplete="off" maxlength="10" id="gno"/> 
          <label for="name" class="input-text">password</label>
          <input type="text" name="guestid" class="form-control input-sz" placeholder="Type here" autocomplete="off" id="gpass"/> 
          <input type="submit" name="guestadd" class="btn-remind btn-dialog" style="width:100%;" value="Update" id="usub"/>
        </form>
      </div>         
    </div>
  </div>
</div>
        
           
</body>
</html>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
  $(document).ready(function(){
     $.ajax({
        url:'ajaxcall/fetchprofile.php',
        type:'post',
        success:function(responsedata){
            $('#prof-info').html(responsedata);
        }
    });
     $.ajax({
           url:'includes/yourBalance.php',
           type:'post',
           success:function(responsedata){
              $('#yourbal').html(responsedata);
           }
    });
    $("#usub").on('click',function()
    {
        var nm=$("#gname").val();
        var mob=$("#gno").val();
        var pass=$("#gpass").val();
        if(nm=="" && mob=="" && pass=="")
        {
          $("#gans").html("All fields can't be void.");
          return false;
        }
        else
        {
            $.ajax(
            {
                url:"ajaxcall/profileupdate.php",
                method:"post",
                data:{
                  name:nm,
                  no:mob,
                  ps:pass
                },
                success:function(response){
                   alert(response);
                }
            });
        }
     });
    
     $(".modal").on("hidden.bs.modal",function(){
        $('#pform')[0].reset();
        $("#gans").html('');
     });
  });
</script>
<script type="text/javascript">
    var loadFile = function(event){
      var image = document.getElementById('output1');
      image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>