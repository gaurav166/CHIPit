<?php
  $_SESSION['addmessage']=' ';
  if(isset($_POST['addfrnd']))
  {
    $frnd_name=$_POST['frndname'];
    $frnd_mail=$_POST['frndmail'];

    if($frnd_name!="" && $frnd_mail!="")
    {
      $frndqry="SELECT frnd_mail from friends where frnd_mail='$frnd_mail' && mem_id=$userid";
      $frndexe=mysqli_query($conn,$frndqry);
      $frndtot=mysqli_num_rows($frndexe);
      if($frndtot>0)
      {
        $_SESSION['addmessage'] = "Friend already exixts";
      }
      else
      {
        $usercheck="SELECT user_id,user_mail from user where user_mail='$frnd_mail'";
        $usr_exe=mysqli_query($conn,$usercheck);
        $usr_tot=mysqli_num_rows($usr_exe);
        $frnd_id=mysqli_fetch_array($usr_exe);
        if($usr_tot>0)
        {

          $frndqry="INSERT into friends set mem_id=".$userid.",
                                            frnd_name='".$frnd_name."',
                                            frnd_mail='".$frnd_mail."'";
          mysqli_query($conn,$frndqry);
          $revqry="INSERT into friends set mem_id=".$frnd_id['user_id'].",
                                             frnd_name='".$user."',
                                             frnd_mail='".$mail."'";
          mysqli_query($conn,$revqry);
          if($frndqry)
          {
            echo "<script>window.location.reload()</script>";
          }
        }
      }
    }
  }
?>
<!--add frnd dialog box -->
<div class="modal fade-scale" id="scaleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
        <div class="log-header">Add Friend</div>
         <form role="form" method="post">
            <div style="margin-bottom:10px;margin-left:25px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;">
                <?= $_SESSION['addmessage']; ?>
            </div>
            <div class="form-group">
              <label for="name" class="input-text">Friend's name:</label>
              <input type="text" name="frndname" class="form-control input-sz" placeholder="Enter the name" autocomplete="off"/>
              <label for="email" class="input-text">Friend's email:</label>
              <input type="email" name="frndmail" class="form-control input-sz" placeholder="Enter the email" autocomplete="off"/>
              <input type="submit" name="addfrnd" value="Invite or add friend" class="btn-remind btn-dialog">
            </div>
          </form>
      </div>
    </div>
  </div>
</div>