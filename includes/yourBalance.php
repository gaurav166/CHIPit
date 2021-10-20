<?php
	session_start();
	$userid=$_SESSION['userid'];
	$yourBalance=0;
	$total_owes=0;
  	$total_gets=0;
  	// calling groupList function and storing answer in variable
  $grps=groupList($userid);
  

  //function to get group members list of current user
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

  $owesArray=groupsYouOwe($grps,$userid);
  $owes=array_diff($owesArray, [0]);
  foreach ($owes as $id => $amt) {
    $total_owes=$total_owes+$amt;
  }
  // function to get groups you owe
  function groupsYouOwe($grps,$userid)
  {
    $conn=mysqli_connect('localhost','root','','chipit') or die("error");
    $owes = array();

    foreach ($grps as $gid) 
    {
      $qry="SELECT owes from share where group_id=$gid && mem_id=$userid";
      $exe=mysqli_query($conn,$qry);
      $num=mysqli_num_rows($exe);
        if($num>0)
        {
          while($row = mysqli_fetch_assoc($exe))
          {
            $owes[$gid] = $row['owes'];
          }
        }
    }
    return $owes;
  }



  $getsArray=groupsOweToYou($grps,$userid);
  $gets=array_diff($getsArray, [0]);
  foreach ($gets as $id => $amt) {
    $total_gets=$total_gets+$amt;
  }
  // function to get groups owe to you
  function groupsOweToYou($grps,$userid)
  {
    $conn=mysqli_connect('localhost','root','','chipit') or die("error");
    $gets = array();
    foreach ($grps as $gid) 
    {
      $qry="SELECT gets from share where group_id=$gid && mem_id=$userid";
      $exe=mysqli_query($conn,$qry);
      $num=mysqli_num_rows($exe);
        if($num>0)
        {
          while($row = mysqli_fetch_assoc($exe))
          {
            $gets[$gid] = $row['gets'];
          }
        }
    }
    return $gets;
  }


  $yourBalance=$total_gets-$total_owes;


	echo "your balance :";
	  if($yourBalance>0)
	  {
	    echo '
	      <span class="urbalance-amt positive-bal">
	        + <i class="fa fa-inr" aria-hidden="true"></i>
	        '.$yourBalance.'
	      </span>
	    ';
	  }
	  else
	  {
	    echo '
	      <span class="urbalance-amt negative-bal">
	        - <i class="fa fa-inr" aria-hidden="true"></i>
	        '.abs($yourBalance).'
	      </span>
	    ';
	  }
?>