<?php 
$conn=mysqli_connect('localhost','root','','chipit') or die("error");
    session_start();
    // $grp_id=$_REQUEST['gid'];
    $grp_id=1;
    $tot=0;
	// if($_SESSION['userid'] == "")
 //    {
 //      header("location: index.php");
    // } 


    $qryy="SELECT * FROM expenses where group_id=".$grp_id."";
     $uidexe=mysqli_query($conn,$qryy);
     $num_rows = mysqli_num_rows($uidexe);
     if($num_rows > 0)
     {
    	while($rows = mysqli_fetch_array($uidexe)) 
    	{
      		$tot=$tot+$rows['amt'];
      	}
	}
	else 
	{  
?>
		<div class="pull-left">no share yet</div>
<?php  
	}

	$qry="SELECT * FROM share where group_id=".$grp_id."";
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
      		if($owe > 0) 
      		{
      			if($get > $owe)
      			{
        			$get = $get - $owe;
        			echo $row2['user_name']." should pay to ".$row1['user_name']." amount = ".$owe;
          			echo "<br>";
        			$owes[$j] = 0;
			    }
      			else if($get < $owe)
      			{
        			$owes[$j] = $owe - $get;
        			echo $row2['user_name']." shoulds pay to ".$row1['user_name']." amount = ".$get;
          			echo "<br>";
        			$gets[$i] = 0;
			    }
		        else
		        {
			        echo $row2['user_name']." should pay to ".$row1['user_name']." amount = ".$get;
			        echo "<br>";
			        $gets[$i] = $owes[$j] = $get - $owe;  
			    }
      		}
    	}
    }
?>
	<div class="pull-left">total expenses:<?php echo $tot ?></div>

