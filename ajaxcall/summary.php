<?php
	$conn=mysqli_connect('localhost','root','','chipit') or die("error");
	session_start();
	$userid=$_SESSION['userid'];
	if($userid == "")
    {
      header("location: index.php");
    }
    $total_owes=0;
	$total_gets=0;
	$sum=0;
	$sum1=0;
	$tot=0;
	$tot1=0;

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


	$youOwe=friendsYouOwe($grps,$userid);
	// function to get friends you owe
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



	$oweToYou=friendsOweToYou($grps,$userid);
	// function to get friends owe to you
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


?>


<div class="row white cnt-details">
	<div class="col-md-4 ">
		total summary
		<div class="cnt-subhead">Total amount you owe</div>
		<div class="cnt-amt">
			<font style="color:#c54a4a">- <i class="fa fa-inr" aria-hidden="true"></i>
			<?php echo $total_owes ?></font>
		</div>
	</div>
	<div class="col-md-4 ">
		&nbsp;
		<div class="cnt-subhead">Total amount owe to you</div>
		<div class="cnt-amt">
			<font style="color:#5bb96d">+ <i class="fa fa-inr" aria-hidden="true"></i>
			<?php echo $total_gets ?></font>
		</div>
	</div>
	<div class="col-md-4 ">
		&nbsp;
		<div class="cnt-subhead">Total outstanding balance</div>
		<div class="cnt-amt">
			<i class="fa fa-inr" aria-hidden="true"></i>
			<?php echo $total_gets-$total_owes ?>
		</div>
	</div>
</div>


<!-- friends summary -->

<div class="row white cnt-details" style="margin-top:40px;">
	<div class="col-md-4 ">
		friends summary
		<div class="cnt-subhead">Friends you owe</div>
		<div class="cnt-frndlst scrollbar-secondary" style="overflow-y:auto;width:95%;">
			<table class="frnd-table" style="width:90%;">
			<?php
				if(count($youOwe)>0)
				{
					foreach ($youOwe as $id => $amt) {
						$qry="SELECT user_profile,user_name from user where user_id=$id";
						$exe=mysqli_query($conn,$qry);
						$fetch=mysqli_fetch_array($exe);
						$sum1=$sum1+$amt;
						echo '
							<tr>
								<td style="padding:5px;padding-left:2px;">
									<img src="profiles/'.$fetch['user_profile'].'" width="43" height="44" class="img-circle">
								</td>
								<td>'.$fetch['user_name'].'</td>
								<td class="negative-bal">
									- <i class="fa fa-inr" aria-hidden="true"></i>'.$amt.'
								</td>
							</tr>
						';
					}
				}
				else
				{
					echo '
						<div style="margin-top:18px;margin-left:12px;">You don\'t owes to any one</div>
					';
				}
			?>
			</table>
		</div>
		<!-- <div class="cnt-viewall">view all</div> -->
	</div>
	<div class="col-md-4 ">
		&nbsp;
		<div class="cnt-subhead">Friends owe to you</div>
		<div class="cnt-frndlst scrollbar-secondary" style="overflow-y:auto;width:95%;">
			<table class="frnd-table" style="width:90%;">
			<?php
				if(count($oweToYou)>0)
				{
					foreach ($oweToYou as $id => $amt) {
						$qry="SELECT user_profile,user_name from user where user_id=$id";
						$exe=mysqli_query($conn,$qry);
						$fetch=mysqli_fetch_array($exe);
						$sum=$sum+$amt;
						echo '
							<tr>
								<td style="padding:5px;padding-left:2px;">
									<img src="profiles/'.$fetch['user_profile'].'" width="43" height="44" class="img-circle">
								</td>
								<td>'.$fetch['user_name'].'</td>
								<td class="positive-bal">
									+ <i class="fa fa-inr" aria-hidden="true"></i>'.$amt.'
								</td>
							</tr>
						';
					}
				}
				else
				{
					echo '
						<div style="margin-top:18px;margin-left:12px;">No one owes you</div>
					';
				}
			?>
			</table>
		</div>
		<!-- <div class="cnt-viewall">view all</div> -->
	</div>
	<div class="col-md-4 ">
		&nbsp;
		<div class="cnt-subhead">Total outstanding balance</div>
		<div class="cnt-frndlst scrollbar-secondary" style="overflow-y:auto;width:95%;">
	     <?php 
            if($sum1>$sum)
            {
                 $cal=$sum1-$sum;	
            	echo '<div class="negative-bal" style="margin-top:15px>+<i class="fa fa-inr" aria-hidden="true"></i>'.$cal.'</div>';
            }
            else if($sum1<$sum)
               {
            	$cal1=$sum-$sum1;
       echo '<div class="positive-bal" style="margin-top:15px">+<i class="fa fa-inr" aria-hidden="true"></i>'.$cal1.'</div>';
          
				}
				else
				{
					echo '
						<div style="margin-top:18px;margin-left:12px;">No outstanding balance</div>
					';
				}
	     ?>
		</div>
		<!-- <div class="cnt-viewall">view all</div> -->
	</div>
</div>


<!-- group summary -->

<div class="row white cnt-details" style="margin-top:40px;margin-bottom:40px;">
	<div class="col-md-4">
		group summary
		<div class="cnt-subhead">Groups you owe</div>
		<div class="cnt-frndlst scrollbar-secondary" style="overflow-y:auto;width:95%;">
			<table class="frnd-table" style="width:90%;">
			<?php
				if(count($owes)>0)
				{
					foreach ($owes as $id => $amt) {
						$qry="SELECT avtar,group_name from groups where group_id=$id";
						$exe=mysqli_query($conn,$qry);
						$fetch=mysqli_fetch_array($exe);
						echo '
							<tr>
								<td style="padding:5px;padding-left:2px;">
									<img src="groups/'.$fetch['avtar'].'" width="43" height="44" class="img-circle">
								</td>
								<td>'.$fetch['group_name'].'</td>
								<td class="negative-bal">
									- <i class="fa fa-inr" aria-hidden="true"></i>'.$amt.'
								</td>
							</tr>
						';
					}
				}
				else
				{
					echo '
						<div style="margin-top:18px;margin-left:12px;">You don\'t owes to any one</div>

					';
				}
			?>
			</table>
		</div>
	</div>
	<div class="col-md-4">
		&nbsp;
		<div class="cnt-subhead">Groups owe to you</div>
		<div class="cnt-frndlst scrollbar-secondary" style="overflow-y:auto;width:95%;">
			<table class="frnd-table" style="width:90%;">
			<?php
				if(count($gets)>0)
				{
					foreach ($gets as $id => $amt) {
						$qry="SELECT avtar,group_name from groups where group_id=$id";
						$exe=mysqli_query($conn,$qry);
						$fetch=mysqli_fetch_array($exe);
						echo '
							<tr>
								<td style="padding:5px;padding-left:2px;">
									<img src="groups/'.$fetch['avtar'].'" width="43" height="44" class="img-circle">
								</td>
								<td>'.$fetch['group_name'].'</td>
								<td class="positive-bal">
									+ <i class="fa fa-inr" aria-hidden="true"></i>'.$amt.'
								</td>
							</tr>
						';
					}	
				}
				else
				{
					echo '
						<div style="margin-top:18px;margin-left:12px;">No one owes to you</div>
					';
				}
				
			?>
			</table>
		</div>
	</div>
	<div class="col-md-4">
		&nbsp;
		<div class="cnt-subhead">Total outstanding balance</div>
		<div class="cnt-frndlst scrollbar-secondary" style="overflow-y:auto;width:95%;">
			 <?php 
            if($total_gets<$total_owes)
            {
                $tot=$total_owes-$total_gets;
            	echo '<div class="negative-bal" style="margin-top:15px>-<i class="fa fa-inr" aria-hidden="true"></i>'.$tot.'</div>';
            }
            else if($total_gets>$total_owes)
               {
            	$tot1=$total_gets-$total_owes;
       echo '<div class="positive-bal" style="margin-top:15px">+<i class="fa fa-inr" aria-hidden="true"></i>'.$tot1.'</div>';
          
				}
				else
				{
					echo '
						<div style="margin-top:18px;margin-left:12px;">No outstanding balance</div>
					';
				}
	     ?>
		</div>
			  <?php 
             /* 
              echo $tot;*/


	     ?>
		</div>
	</div>
</div>