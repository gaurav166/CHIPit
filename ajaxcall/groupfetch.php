<?php
  session_start();
  $guest=$_SESSION['guest'];
  $username=$_SESSION['username'];
  if($_SESSION['userid'] == "")
  {
    header("location: index.php");
  } 
  $userid=$_SESSION['userid'];
  groupFetch($userid);
  function groupFetch($userid)
  {
      $conn=mysqli_connect('localhost','root','','chipit') or die("error");
      $avtar="groups/";
      $show="SELECT * from groups order by group_id desc";
      $showexe=mysqli_query($conn,$show);
      $num=mysqli_num_rows($showexe);
      if ($num==0) {
        echo '<label style="margin-top:185px;margin-left:50px;">create group to get started</label>';
      }
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
                    <div class="negative-bal grp-balance pull-right"><i class="fa fa-inr" aria-hidden="true"></i> '.$row['group_balance'].'</div>
                    <div class="clearfix"></div>
                </div>
              ';

             }
          }
      }
   } 
   if($guest>0)
   {
    guestgroupfetch($username);
   }

   function guestgroupfetch($username)
   {
      $conn=mysqli_connect('localhost','root','','chipit') or die("error");
      $avtar="groups/";
      $qry="SELECT * from guest where guest_name='".$username."'";
      $exe=mysqli_query($conn,$qry);
      $fetch=mysqli_fetch_array($exe);
      $res=explode(',', $fetch['group_id']);
      if ($fetch['group_id']==0) {
        echo '<label style="margin-top:185px;margin-left:50px;">create group to get started</label>';
      }
      if($fetch['group_id']>0)
      {
        foreach($res as $value)
        {
          $getqry="SELECT * from groups where group_id=$value";
          $getexe=mysqli_query($conn,$getqry);
          $get=mysqli_fetch_array($getexe);
          if($getqry)
          {
             echo '
                    <div onclick="groupdata('.$get['group_id'].')" class="grp-area">  
                       <div class="pull-left grp-img">
                          <img src="'.$avtar.$get['avtar'].'" width="43" height="44" class="img-circle pull-left">
                       </div>
                     <div class="pull-left grp-txt">
                        '.$get['group_name'].'
                      </div>
                      <div class="negative-bal grp-balance pull-right"><i class="fa fa-inr" aria-hidden="true"></i> '.$get['group_balance'].'</div>
                    <div class="clearfix"></div>
                  </div>
                ';

          }
        }
      }
   } 
?>  