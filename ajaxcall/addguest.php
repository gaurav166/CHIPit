<?php 
	$temp="";
	$conn=mysqli_connect('localhost','root','','chipit') or die("error");
	session_start();
	$userid=$_SESSION['userid'];
	$gid=$_POST['gt'];
	$name=$_POST['guest'];
	$qry="SELECT * from guest where guest_name='".$name."'";
	$exe=mysqli_query($conn,$qry);
	$fetch=mysqli_fetch_array($exe);
	$guest_name=$fetch['guest_name'];
	$group_id=$fetch['group_id'];
	$num=$gid.$group_id;
	$arr=str_split($num,"1");
	$new_lst=implode(",", $arr);
	$grp_arr=explode(',', $group_id);
	foreach ($grp_arr as $value) 
	{
		if($gid==$value)
		{
			echo "Guest already in group";
		}
		else
		{
			$update="UPDATE guest set nominee_id=$userid, group_id='".$new_lst."' where guest_name='".$name."'";
			mysqli_query($conn,$update);
			$temp=1;
		}
	}
	if($temp==1)
	{
		echo "Guest added to the group";
	}
?>