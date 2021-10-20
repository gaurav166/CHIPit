<!-- Add Member Dialog Box -->
<div class="modal fade-scale" id="addmember" tabindex="-1" role="dialog" aria-labeledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
        <div class="log-header">Add Memeber</div>
        <form role="form" method="post">
          <div  style="margin-bottom:10px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;"></div>
          <!-- list from friends page -->
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
                              <input type="checkbox" name="up[]" value="<?php echo $memfetch['user_id']; ?>" style="margin-right:5px;" id="memlst"><label for="cb1">
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
          <input type="submit" name="memadd" class="btn-remind btn-dialog" style="width:100%;" value="+ Add Member" id="memadd"/>
        </form>
      </div>      
    </div>
  </div>
</div>
