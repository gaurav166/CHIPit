<?php 
  session_start();
  include_once("../configure/configure.php");
  $userid=$_SESSION['userid'];
  $username=$_SESSION['username'];
  $profile="profiles/";
  $mail=$_SESSION['usermail'];
  $guest=$_SESSION['guest'];
  if($userid == "")
  {
    header("location: index.php");
  }
  $count=0;
  if($guest>0)
  {
    $guestqry="SELECT * from guest where guest_name='".$username."'";
    $guestexe=mysqli_query($conn,$guestqry);
    $guest_fetch=mysqli_fetch_array($guestexe);
  }
  else
  {
    $userqry="SELECT * from user where user_id=$userid";
    $userexe=mysqli_query($conn,$userqry);
    $userfetch=mysqli_fetch_array($userexe);
    $frndqry="SELECT frnd_mail from friends where mem_id=$userid";
    $frndexe=mysqli_query($conn,$frndqry);
    $frnd_count=mysqli_num_rows($frndexe);
    $grpqry="SELECT * from groups order by group_id desc";
    $grpexe=mysqli_query($conn,$grpqry);  
    while($row =  mysqli_fetch_assoc($grpexe))
    {
      $res=explode(',', $row['group_member']);
      foreach ($res as $value)
      {
        if($value==$userid)
        {
          $count=$count+1;
        }
      }
    }       
  }



  // update photo

  if (isset($_POST['file']))
  {
    $name = $_FILES['file']['name'];
    $random=rand(0000,9999);
    $file_name=$random.$name;
    $target_dir = "../profiles/";
    $target_file = $target_dir.basename($file_name);
    $upphoto="UPDATE user set user_profile='".$file_name."' where userid=$userid";
    mysqli_query($conn,$sql);
    move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$file_name);
    unset($_SESSION['userprofile']);
    $_SESSION['userprofile']=$target_file;
  }
?>

<div class="col-md-12">
  <div class="col-md-4"> 
    <div class="card card-4">
      <div class="bottom"></div>
      <input type="file" accept="image/*" name="file" id="file"  onchange="loadFile(event)" style="display: none;">
      <img id="output1" src="<?php  echo $profile.$userfetch['user_profile'] ?>" />  
      <label for="file" style="cursor: pointer;" class="ed">edit</label>
      <div class="card-text-name"><?php echo $userfetch['user_name'] ?></div>
      <div class="card-text-inner"><?php echo $mail ?></div>
      <div class="card-text-friend">
        friends :  <?php echo $frnd_count ?>
        <i class="fa fa-smile-o" style="font-weight: bold; padding-left: 5px;"></i>
      </div>
    </div>
  </div>

  <div class="col-md-8" style="margin-top:15px;">
    <div class="col-md-12 white-part" style="margin-top:20px;">
      <div class="col-md-5 white-inner-text">name</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text"><?php echo $userfetch['user_name'] ?></div>
    </div>
    <div class="col-md-12 no-part" style="margin-top:4px;">
      <div class="col-md-5 white-inner-text">email</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text" style="text-transform: lowercase;">
        <?php echo $mail ?>
      </div>
    </div>
    <div class="col-md-12 white-part" style="margin-top:4px;">
      <div class="col-md-5 white-inner-text">Friends</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text"><?php echo $frnd_count ?></div>
    </div>
    <div class="col-md-12 no-part" style="margin-top:4px;">
      <div class="col-md-5 white-inner-text">joined on</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text" ><?php echo $userfetch['user_join'] ?></div>
    </div>
    <div class="col-md-12 white-part" style="margin-top:4px;">
      <div class="col-md-5 white-inner-text">mobile no</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text" ><?php echo $userfetch['user_no'] ?></div>
    </div>
    <div class="col-md-12 no-part" style="margin-top:4px;">
      <div class="col-md-5 white-inner-text">no. of groups</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text" ><?php echo $count ?></div>
    </div>
    <div class="col-md-12 white-part" style="margin-top:10px;">
      <div class="col-md-5 white-inner-text">password</div>
      <div class="col-md-2" style="padding-top: 10px; font-weight: bolder; text-align: center;">:</div>
      <div class="col-md-5 white-inner-text" style="text-transform:none;"><?php echo $userfetch['password'] ?></div>
    </div>
  </div>
</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    var loadFile = function(event){
      var image = document.getElementById('output1');
      image.src = URL.createObjectURL(event.target.files[0]);
    };    
</script>
