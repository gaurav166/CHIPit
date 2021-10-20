<?php 
  $conn=mysqli_connect('localhost','root','','chipit') or die("error");
  session_start();
  $userid=$_SESSION['userid'];
  $user=$_SESSION['username'];
  $profile=$_SESSION['userprofile'];
  $mail=$_SESSION['usermail'];
  if($_SESSION['userid'] == "")
  {
    header("location: index.php");
  } 

  //grps has current user is in following groups
  $grps=groupList($userid);

  //function to get group members list of current user
  // userid = current user's_id
  function groupList($userid)
  {
    $conn=mysqli_connect('localhost','root','','chipit') or die("error");
    $grplst = array();
    $i=0;
    $checkqry="SELECT group_id,group_member from groups";
    $checkexe=mysqli_query($conn,$checkqry);
    $checknum=mysqli_num_rows($checkexe);
    if($checknum>0)
    {
      while($row = mysqli_fetch_assoc($checkexe))
      {
        $i++;
        $lst=explode(',', $row['group_member']);
        $gid=$row['group_id'];
        foreach($lst as $value)
        {
          if($userid == $value)
          {
            $grplst[$i]=$gid;
          }
        }
      }
    }
    return $grplst;
  }

 
  $youOwe=friendsYouOwe($grps,$userid);
  // used to update friendlist which shoows whoom you owes
  foreach ($youOwe as $key => $value) {
    $fbal = "UPDATE friends,user set balance=$value where user_id=$key && mem_id=$userid && user.user_mail=friends.frnd_mail";
    mysqli_query($conn,$fbal);
  }

  // function to get friends you owe
  // grps = current user is in following groups
  // userid = current user
  function friendsYouOwe($grps,$userid)
  {
    $arr = array();
    $conn=mysqli_connect('localhost','root','','chipit') or die("error");
    foreach ($grps as $gid) 
    {
      $qry="SELECT * FROM share where group_id=".$gid."";
        $uidexe=mysqli_query($conn,$qry);
        $getsarr = array();
        $owesarr = array();
        while($row = mysqli_fetch_array($uidexe))
        {
            
            // Put the values into the array, no other variables needed
            $getsarr[$row['mem_id']] = $row['gets'];
            $owesarr[$row['mem_id']] = $row['owes'];
            $g=$row['gets'];
        }
        // to extract 0 from the array
        $gets = array_diff($getsarr, [0]);
        $owes = array_diff($owesarr, [0]);

        // to sort gets values in decending order
        arsort($gets);
        // to sort owes values in acending order
        asort($owes);
        foreach($gets as $i => $get)
        {
            foreach($owes as $j => $owe)
            {
                $qr1="SELECT * FROM user where user_id=".$i."";
                $qr2="SELECT * FROM user where user_id=".$j."";
                $st1=mysqli_query($conn,$qr1);
                $st2=mysqli_query($conn,$qr2);
                $row1 = mysqli_fetch_array($st1);
                $row2 = mysqli_fetch_array($st2);
                if($userid == $row2['user_id'])
                {
                  if($owe > 0) 
                  {
                      if($get > $owe)
                      {
                          $get = $get - $owe;
                          $arr[$row1['user_id']] = $owe;
                          $owes[$j] = 0;
                      }
                      else if($get < $owe)
                      {
                          $owes[$j] = $owe - $get;
                          $arr[$row1['user_id']] = $get;
                          $gets[$i] = 0;
                      }
                      else
                      {
                        $arr[$row1['user_id']] = $get;
                          $gets[$i] = $owes[$j] = $get - $owe;  
                      }
                  }
              }
            }
        }
    }
    return $arr;
  }



  $show="SELECT frnd_id,mem_id,frnd_name,frnd_mail,balance,user_profile FROM user join friends on user.user_mail=friends.frnd_mail where friends.mem_id=$userid order by frnd_id desc";
  $exe=mysqli_query($conn,$show);
  $tot=mysqli_num_rows($exe);
  if($tot>0)
  {
    while($fetch=mysqli_fetch_array($exe))
    {    
?>
      <tr>
        <td scope="row">
          <img src="<?php echo "profiles/".$fetch['user_profile']; ?>" width="43" height="44" class="img-circle">
          </td>
        <td>
          <div><?php echo $fetch['frnd_name']; ?></div>
          <span class="frnd-mail">
            <?php echo $fetch['frnd_mail']; ?>
          </span>
        </td>
        <td class="negative-bal">
          <i class="fa fa-inr" aria-hidden="true"></i>
          <?php echo $fetch['balance']; ?>
        </td>
        <!-- <td>
          <button class="btn-remind pull-right" onclick="settleUp(<?php echo $fetch['mem_id']; ?>)">settle up</button>
        </td> -->
      </tr>
<?php
    }

  }
  else
  {
?>
    <div class="empty-lst" style="margin-left:115px;">Add new <b>Friends</b> to get into action !!</div>
<?php
  }
?>
  