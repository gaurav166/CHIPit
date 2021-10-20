<?php
	session_start();
	include_once("configure/configure.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
   <link rel="stylesheet" type="text/css" href="css/style.css">
</meta>
<script src="js/jquery-3.3.1.min.js"></script>
</head>
<body class="scrollbar-secondary">
	
	<!-- header part -->
	<div class="container-fluid headertop">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-3 header-logo">
						<img src="images/chipit-logo.png" width="170" height="40">
					</div>
					<div class="col-md-9">
						<div class="row">
			 				<ul class="nav navbar-nav navigation pull-right">
                   				<li>
  									<button type='button' class="btn-back" data-toggle="modal" data-target="#popUpWindow">Log in</button>
                  				</li>
			                   	<li>
  									<button type='button' class="btn-back" data-toggle="modal" data-target="#popUpWindow1">Sign up</button>
  								</li>
  								<li>
  									<button type='button' class="btn-back btn-back-guest" data-toggle="modal" data-target="#popUpWindow2">Join As Guest</button>
  								</li>
                   			</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- slider -->
 <div class="container-fluid space">
	<div id="myslide" class="carousel slide" data-ride="carousel"  data-interval="3000">		

		<!-- - slides -->
		 <div class="carousel-inner carousel-height" role="listbox"
		>
			<div class="item active">
				<img src="images/fog-4529616_1920.jpg" width="100%">
					<div class="carousel-caption">
						<div class="carousel-text">"good accounting makes<br> good friends"</div>
						<img src="images\img1.png" class="carousel-img">
					</div>
				</div>
			<div class="item"> 
				<img src="images/m7IS9R.png" width="100%">
				<div class="carousel-caption">
						<div class="carousel-text">"no more bickering over<br>the bills"</div>
						
						<img src="images\img2.png" class="carousel-img">
					</div>
			</div>
			<div class="item active">
				<img src="images/cover.jpg" width="100%">
					<div class="carousel-caption">
						<div class="carousel-text">"now manage accounts<br> more easier"</div>
						
						<img src="images\img2.png" class="carousel-img">
					</div>
				</div>
		</div> 
		<a class="left carousel-control" href="#myslide" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myslide" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a> 

	</div>
	<a href="#expenses" >
	<div class="arrow">
		
                <span></span>
                <span></span>
                <span></span>
  
</div>
</a>
</div> 
<!-- end -->


	
<!-- expenses part -->
<a name="expenses"></a>
<div class="container-fluid back-expenses">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 banner-text">
							expenses
						</div>
						<div class="col-md-12 banner-inner-text">
							Chipit is the easiest way to share expenses <br>with friends and family without stressing<br> about <span style="color: black">"who owes who."</span>
						</div>
					</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<img src="images/laptop.png" width="450" height="450" class="banner-img">
						<img src="images/download.png" width="300" height="200" class="exp-img">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- end -->


<div class="container-fluid back-bills">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
					<div class="row">
					<div class="col-md-12">
						<img src="images/laptop.png" width="450" height="450" class="banner-img">
						<img src="images/download (1).png" width="300" height="200" class="exp-img">
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
						<div class="col-md-12 banner-text">
							bills
						</div>
						<div class="col-md-12 banner-inner-text">
							no more disputes over the bills<br>
							chipit shows who pays next 
							<br>and minimize the transcation.
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
</div>

<!-- end bills part -->

<div class="container-fluid back-grps">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 banner-text">
							groups
						</div>
						<div class="col-md-12 banner-inner-text">
							 create the group and enjoy the<br>
							  <span style="color: black">"moment."</span>
							 together
						</div>
					</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<img src="images/laptop.png" width="450" height="450" class="banner-img">
						<img src="images/download.png" width="300" height="200" class="exp-img">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>


<div class="container-fluid back-set">
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
					<div class="row">
						<div class="col-md-12 banner-text">
							you're all set 
						</div>
						<div class="col-md-12 banner-inner-text">
							 
							  <span style="color: black">register</span>
							 or  <span style="color: black">login</span>
							 to get started.
						</div>
					</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<img src="images/laptop.png" width="450" height="450" class="banner-img">
						<img src="images/registration-login-keyboard-hand.jpg" width="300" height="200" class="exp-img">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php
	include_once("signup.php");
	include_once("login.php");
	include_once("join-as-guest.php");
	mysqli_close($conn);
?>

</body>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script type="text/javascript">
    var loadFile = function(event){
      var image = document.getElementById('output');
      image.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
</html>



