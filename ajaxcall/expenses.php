<?php 
    require_once("calculation.php");
    $conn=mysqli_connect('localhost','root','','chipit') or die("error");
    session_start();
    if($_SESSION['userid'] == "")
  	{
    	header("location: index.php");
  	} 
    $title=$_POST['expent'];
    $amt=$_POST['expam'];
    $gid=$_POST['gt'];
    $userid=$_SESSION['userid'];
    
    $sql="INSERT into expenses set group_id=".$gid.",mem_id=".$userid.",title='".$title."',amt='".$amt."'";
    mysqli_query($conn,$sql);
	if($sql)
    {
        echo "Expense Added";
        groupBalance($gid);
    }

    // this function brings members (array) in group
    $mem_lst=groupmembers($gid);
    // counts members (array) in group 
    $tot_mem=count($mem_lst);
    // this funaction brings total no of guest in group
    $tot_guest=guestMembers($gid);
    // total no of group members
    $grp_mem_count=$tot_mem+$tot_guest;

    // this function calculates share on basis of thier guest count
    calculateShare($gid,$userid,$amt,$mem_lst,$grp_mem_count);

    // this function is to calculate owes and give amount
    shareDifference($gid);

 ?>














