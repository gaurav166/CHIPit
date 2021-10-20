<?php
  $_SESSION['message']='';
  if (isset($_POST['ssubmit']))
  { 
    $user_name=$_POST['name'];
    $user_mail=$_POST['smail'];
    $user_no=$_POST['contact'];
    $password=$_POST['spass'];
    $cnf_pass=$_POST['cnfpass'];
    $current_date = date("Y-m-d");
    $name = $_FILES['file']['name'];
    if($user_name!="" && $user_mail!="" && $password!="" && $cnf_pass!="")
    {
      $sel="select user_mail from user where user_mail='$user_mail'";
      $exe=mysqli_query($conn,$sel);
      $tot=mysqli_num_rows($exe);
      if($tot>0)
      {
        $_SESSION['message'] = "Email already exists";
      }
      else
      {
        if($password != $cnf_pass)
        {
          $_SESSION['message'] = "Password does not match";
        }
        else
        {
          if (is_numeric($user_no) && strlen($user_no)===10)
          {
            $random=rand(0000,9999);
            $file_name=$random.$name;
            $target_dir = "profiles/";
            $target_file = $target_dir.basename($file_name);
            if(empty($name))
            {
              $file_name="default.png";
              $target_file="profiles/".$file_name;
            }
            $sql="INSERT into user set user_name='".$user_name."',
                           user_mail='".$user_mail."',
                           user_no=".$user_no.",
                           password='".$password."',
                           user_profile='".$file_name."',
                           user_join='".$current_date."'";
            mysqli_query($conn,$sql);
            move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$file_name);
            $_SESSION['username']=$user_name;
            $_SESSION['userprofile']=$target_file;
            $_SESSION['usermail']=$user_mail;
            $uidqry="SELECT * FROM user WHERE user_mail='$user_mail'";
            $uidexe=mysqli_query($conn,$uidqry);
            $uidfetch=mysqli_fetch_array($uidexe);
            $_SESSION['userid']=$uidfetch['user_id'];
            $_SESSION['guest']=0;
            if($sql)
            {
              echo "<script>alert('Successfully Added!')</script>";
              echo "<script>window.location.href='dashboard.php'</script>";
            }
            else{
              $_SESSION['message'] = "Could not Sign Up. Please fill all the details properly.";
            }
          }
          else
          {
            $_SESSION['message'] = "Fill number properly";
          }
        }
      }
    }
    else{
      $_SESSION['message'] = "Select profile photo";
    }
  }
?>


  <!-- Sign in Dialog Box -->
<div class="modal fade" id="popUpWindow1" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
        <div class="log-header">Sign-up To CHIPit</div>
          <form role="form" method="post" enctype='multipart/form-data'>
            <div style="margin-top:30px;margin-left:25px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;">
              <?= $_SESSION['message'] ?>
            </div>
            <div class="form-group">
              <input type="text" name="name" class="form-control input-size" placeholder="Username" autocomplete="off" required/>
              <input type="email" name="smail" class="form-control input-size" placeholder="Email" autocomplete="off" required/>
              <input type="text" name="contact" class="form-control input-size" placeholder="Number" autocomplete="off" maxlength="10" required/>
                <input type="password" name="spass" class="form-control input-size" placeholder="Password" autocomplete="off" required/>
                <input type="password" name="cnfpass" class="form-control input-size" placeholder="Confirm Password" autocomplete="off" required/>
                <input type="file" accept="image/*" name="file" id="file"  onchange="loadFile(event)" style="display: none;">
                <label for="file" style="cursor: pointer;" class="profile-pic">select profile picture</label>
                <img id="output" class="pf-pic" />  
              <div class="signup-text">Already a member?&nbsp;<a href="" data-target="#popUpWindow">login now</a></div>
              <input type="submit" name="ssubmit" value="signup" class="btn-remind btn-dialog btn-block"/>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>