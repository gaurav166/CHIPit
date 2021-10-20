<?php
	$userid=$_SESSION['userid'];
	echo "current userid = $userid";
	echo "<br>";
	echo "<br>";
	echo "<hr>";


	$grps=groupList($userid);
	echo "current user is in following groups : <br>";
	foreach ($grps as $value) {
		echo $value."<br>";
	}
	echo "<hr>";

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





	$total_owes=0;
	$total_gets=0;
	$owesArray=groupsYouOwe($grps,$userid);
	$owes=array_diff($owesArray, [0]);
	echo "groups you owes<br><br>";
	foreach ($owes as $id => $amt) {
		echo "group_id = ".$id." amount  =  ".$amt."<br>";
		$total_owes=$total_owes+$amt;
	}
	echo "<br><hr>";

	// function to get groups you owe
	// grps = current user is in following groups                                                                 
	// userid = current user
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
	echo "groups owes to you<br><br>";
	foreach ($gets as $id => $amt) {
		echo "group_id = ".$id." amount  =  ".$amt."<br>";
		$total_gets=$total_gets+$amt;
	}
	echo "<br><hr>";
	// function to get groups owe to you
	// grps = current user is in following groups
	// userid = current user
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

	echo "total amount you owes  <br><br>".$total_owes;
	echo "<br><br><hr>";
	echo "total amount owes to you   <br><br>".$total_gets;
	echo "<br><br><hr>";


	echo "friends you owe <br><br>";

	$youOwe=friendsYouOwe($grps,$userid);

	foreach ($youOwe as $key => $value) {
		echo $key." amt = ".$value;
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

	echo "<br><br><hr>";


	echo "friends owe to you <br><br>";
	$oweToYou=friendsOweToYou($grps,$userid);

	foreach ($oweToYou as $key => $value) {
		echo $key." amt = ".$value."<br>";
	}

	// function to get friends owe to you
	// grps = current user is in following groups
	// userid = current user
	function friendsOweToYou($grps,$userid)
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
		            if($userid != $row2['user_id'] && $userid == $row1['user_id'])
		            {
						if($owe > 0) 
			            {
			                if($get > $owe)
			                {
			                    $get = $get - $owe;
			                    $arr[$row2['user_id']] = $owe;
			                    $owes[$j] = 0;
			                }
			                else if($get < $owe)
			                {
			                    $owes[$j] = $owe - $get;
			                    $arr[$row2['user_id']] = $get;
			                    $gets[$i] = 0;
			                }
			                else
			                {
			                	$arr[$row2['user_id']] = $get;
			                    $gets[$i] = $owes[$j] = $get - $owe;  
			                }
			            }			            
			        }
		        }
		    }
		}
		return $arr;
	}
		echo "<br><br><hr>";

?>