<script type="text/javascript">
  function logo()
  {
    window.location="dashboard.php";
  }
</script>
<!-- Header Starts Here -->
  <div class="container-fluid dbhmargin fixed" style="background-color:#ffffff;">
  		<img src="images/chipit-logo.png" width="170" height="40" id="dblogo" onclick="logo()" style="cursor:pointer;">
  		<div class="dbprofile pull-right">
  			<a href="dashboard-profile.php" class="pull-left">
  			<img src="<?php echo $profile;?>" width="43" height="44" class="img-circle pull-left">
  			<div class="profiledetail pull-left">
  				<div><?php echo $user;?></div>
  				<span class="profileno"><?php echo $mail; ?></span>
  			</div>
  			</a>
  		</div>
  		<button id="btnaddfrnd" class="pull-right text-center" data-toggle="modal" data-target="#scaleModal">+ Add Friend</button>
  		<div class="urbalance pull-right" id="yourbal">
  			
      			
  		</div>
  </div>

  <!-- for equalising height same as header -->
  <div style="height:70px;"></div>