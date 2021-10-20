<?php 
	$gid=$_REQUEST['gid'];
	session_start();
  	include_once("../configure/configure.php");
  	$userid=$_SESSION['userid'];
    
    $memb_qry="SELECT group_member from groups WHERE group_id=$gid";
    $memb_exe=mysqli_query($conn,$memb_qry);
    $memb_cnt=mysqli_num_rows($memb_exe);
    if($memb_cnt==1)
    {
      $memb_fetch=mysqli_fetch_array($memb_exe);
      $mems=$memb_fetch['group_member'];
      $mems_lst=explode(',', $mems);
      foreach ($mems_lst as $val) {
        $get_mem="SELECT user_name,user_mail,user_profile from user where user_id=$val";
        $get_memexe=mysqli_query($conn,$get_mem);
        $get_memtot=mysqli_num_rows($get_memexe);
        if($get_memtot==1)
        {
          $get_memfetch=mysqli_fetch_array($get_memexe);
          $mem_name=$get_memfetch['user_name'];
          $mem_mail=$get_memfetch['user_mail'];
          $mem_profile="profiles/".$get_memfetch['user_profile'];
        }
?>
      <tr>
          <td scope="row">
              <img src="<?php echo $mem_profile ?>" width="43" height="44" class="img-circle">
          </td>
          <td>
              <div><?php echo $mem_name ?></div>
          </td>
          <td class="members"><?php echo $mem_mail ?></td>
        </tr>
<?php       
      }
    }


    // calling the function made below
    guestfetch($gid);
    // passing the selected group id
    function guestfetch($gid)
    {
      // making a connection to database
      $conn=mysqli_connect('localhost','root','','chipit') or die("error");
      $guest_profile="profiles/default.png";
      $show="SELECT * from guest";
      $showexe=mysqli_query($conn,$show);
      // it brings value row by row 
      while($row =  mysqli_fetch_assoc($showexe))
      {
        // it removes the comma from string and converts into array
        $res=explode(',', $row['group_id']);
        // checking every value in res one by one
        foreach ($res as $value)
        {
         // if the given group id matches the group id in guest table does further process
          if($gid==$value)
          {
            $nominee=$row['nominee_id'];
            // checks user name from user table using nominee id
            $query="SELECT user_mail from user where user_id=$nominee";
            $execute=mysqli_query($conn,$query);
            $fetch=mysqli_fetch_array($execute);
            echo '<tr>
                   <td scope="row">
                     <img src="'. $guest_profile .'" width="43" height="44" class="img-circle">
                   </td>
                   <td>
                     <div>'. $row['guest_name'] .'</div>
                   </td>
                   <td class="members" style="text-transform:none;"> Nominated by : '.$fetch['user_mail'].'</td>
                  </tr>';
          }
        }
      }
    }
?>

 
