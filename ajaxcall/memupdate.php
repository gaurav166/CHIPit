<?php
	$conn=mysqli_connect('localhost','root','','chipit') or die("error");
    session_start();
    if($_SESSION['userid'] == "")
	{
	  header("location: index.php");
	} 
    $ch=$_POST['list'];
    $gid=$_POST['gid'];
    $arr="";
    $nam="";
	
	// explode se string ko array bna rha hai 
	$lst_mem=explode(',', $ch);
	$up_sel="SELECT group_member from groups where group_id=$gid";
	$up_exe=mysqli_query($conn,$up_sel);
	$up_fetch=mysqli_fetch_array($up_exe);
	
	// database me se vbalue aa rhi hai string form me
  	$up_mem=$up_fetch['group_member'];

  	// database se jo value aa rhi hai string me usko array me covert through explode
  	$lst_up=explode(',', $up_mem);

  	// returns what is same in both 
  	$ans=array_intersect($lst_up, $lst_mem);
	foreach ($ans as $value) {
		$arr=explode(',', $value);
	}

	if(!$arr)
	{
		
		$new_mem=$up_mem.",".$ch;
		$new_qry="UPDATE groups set group_member='".$new_mem."' where group_id=$gid";
		mysqli_query($conn,$new_qry);
		echo "Member added";
		initializeShare($gid,$lst_mem);
	}
	else
	{
		echo "Member you have selected is already in group.\nPlease try again.";
	}

	// function to initialize all members in selected group for share table
	function initializeShare($gid,$lst_mem)
	{
		$conn=mysqli_connect('localhost','root','','chipit') or die("error");
		foreach ($lst_mem as $value) {
		    $qry="INSERT into share set group_id=$gid,
		                                mem_id=$value";
		    $exe=mysqli_query($conn,$qry);
		}
	}
?>
