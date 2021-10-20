<?php
  error_reporting(0);
  $_SESSION['grpmessage']='';
  if(isset($_POST['creategroup']))
  {
    $avtar_type=".png";
    $grp_title=$_POST['gname'];
    $grp_mem_id=implode(',', $_POST['ch']);
    $grp_mem=$userid.",".$grp_mem_id;
    $mem=explode(',', $grp_mem);
    $grp_avatar=$_POST['avatar'];
    $grp_logo=$grp_avatar.$avtar_type;
    $start_date = date("Y-m-d");
    $end_date='';
    if(empty($grp_avatar))
    {
      $grp_logo="audience.png";
    }
    if($grp_title!="")
    {
        $grpcreate="INSERT into groups set group_name='".$grp_title."',
                                           group_member='".$grp_mem."',
                                           avtar='".$grp_logo."',
                                           start_date='".$start_date."',
                                           end_date='".$end_date."'";
        mysqli_query($conn,$grpcreate);  
        initializeShare($mem);   
    }
    else
    {
      $_SESSION['grpmessage']="Fill all details";
    }
  }

  // function to initialize all members in selected group for share table
  function initializeShare($mem)
  {
    $conn=mysqli_connect('localhost','root','','chipit') or die("error");
    $checkqry="SELECT max(group_id) as group_id from groups";
    $checkexe=mysqli_query($conn,$checkqry);
    $fetch=mysqli_fetch_array($checkexe);
    foreach ($mem as $value) {
        $qry="INSERT into share set group_id=".$fetch['group_id'].",
                                    mem_id=$value";
        $exe=mysqli_query($conn,$qry);
    }
  }
?>
<!-- add group dialog box -->
<div class="modal fade-scale" id="scaleModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
        <div class="log-header">Create Group</div>
         <form role="form" method="post">
            <div style="margin-bottom:10px;margin-left:25px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;">
                <?= $_SESSION['grpmessage']; ?>
            </div>
            <label for="name" class="input-text">Group Name</label>
            <input type="text" name="gname" class="form-control input-sz" placeholder="Group Name here" autocomplete="off" required/>
            <label for="name" class="input-text">Group Avatar</label>
              <div class="row avatar-mov">
                <label class="avatars" style="margin-left:55px;">
                  <input type="radio" name="avatar" value="film"/>
                  <img src="groups/film.png" width="50" height="51">
                </label>
                <label class="avatars" style="margin-left:25px;">
                  <input type="radio" name="avatar" value="gym"/>
                  <img src="groups/gym.png" width="50" height="51">
                </label>
                <label class="avatars" style="margin-left:25px;">
                  <input type="radio" name="avatar" value="campfire"/>
                  <img src="groups/campfire.png" width="50" height="51">
                </label>
                <label class="avatars" style="margin-left:25px;">
                  <input type="radio" name="avatar" value="boat"/>
                  <img src="groups/boat.png" width="50" height="51">
                </label>
              </div>    
              <div>
                <label class="avatars" style="margin-left:40px; margin-top: 10px; ">
                    <input type="radio" name="avatar" value="lunch"/>
                    <img src="groups/lunch.png" width="50" height="51">
                </label>
                <label class="avatars" style="margin-left:25px; margin-top: 10px;">
                    <input type="radio" name="avatar" value="trip"/>
                    <img src="groups/trip.png" width="50" height="51">
                </label>
                <label class="avatars" style="margin-left:25px; margin-top: 10px; ">
                    <input type="radio" name="avatar" value="flight"/>
                    <img src="groups/flight.png" width="50" height="51">
                </label>
                <label class="avatars" style="margin-left:25px; margin-top: 10px;">
                    <input type="radio" name="avatar" value="swim"/>
                    <img src="groups/swim.png" width="50" height="51">
                </label>
              </div>
             </div>
             <div class="form-group">
              <label for="name" class="input-text">Add members:</label>
                <div class="all-members scrollbar-secondary cnt-frndlst">
                  <table class="frnd-table">
                    <?php
                      $memshow="SELECT user.user_id,friends.frnd_id,friends.frnd_mail,friends.frnd_name from user join friends on friends.frnd_mail=user.user_mail where friends.mem_id=$userid";
                      $memshow_exe=mysqli_query($conn,$memshow);
                      $memshow_tot=mysqli_num_rows($memshow_exe);
                      if($memshow_tot>0)
                      {
                        while($memfetch=mysqli_fetch_array($memshow_exe))
                        {
                    ?>
                          <tr>
                            <td style="padding-left:15px;">
                              <input type="checkbox" name="ch[]" value="<?php echo $memfetch['user_id']; ?>" style="margin-right:5px;"><label for="cb1">
                                <?php echo $memfetch['frnd_mail']; ?>
                              </label>
                            </td>
                            <td style="text-transform:capitalize;">
                              <?php echo $memfetch['frnd_name']; ?>
                            </td>
                          </tr>
                    <?php      
                        }
                      }
                      else
                      {
                    ?>
                        <div class="empty-lst" style="margin-top:60px;margin-left:70px;">Add <b>Friends</b> to get into action !!</div>
                    <?php
                      }
                    ?>
                  </table>
                </div>
            </div>
            <input type="submit" name="creategroup" class="btn-remind btn-dialog" value="+ create group">
          </form>
      </div>
    </div>
  </div>
</div>



