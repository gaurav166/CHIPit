
<?php 
    // this function calculates total expenses in group
    function groupBalance($gid)
    {   
        $sum=0;
        $conn=mysqli_connect('localhost','root','','chipit') or die("error");
        $checkqry="SELECT amt from expenses where group_id=$gid"; 
        $checkexe=mysqli_query($conn,$checkqry);
        //returns sum all the values in the array
        while($row =  mysqli_fetch_assoc($checkexe))
        {
            $sum=$sum+$row['amt'];
        }
        $qry="UPDATE groups set group_balance='".$sum."' where group_id=$gid";
        $exe=mysqli_query($conn,$qry);
        
    }


    //this function is to fetch members in group
    function groupMembers($gid)
    {
        $conn=mysqli_connect('localhost','root','','chipit') or die("error");
        $qry="SELECT group_member from groups where group_id=$gid";
        $exe=mysqli_query($conn,$qry);
        $fetch=mysqli_fetch_array($exe);
        $res=explode(',', $fetch['group_member']);
        return $res;
    }



    // this function is to fetch guest in group
    function guestMembers($gid)
    {
        $count=0;
        $conn=mysqli_connect('localhost','root','','chipit') or die("error");
        $qry="SELECT * from guest";
        $exe=mysqli_query($conn,$qry);
        while($row =  mysqli_fetch_assoc($exe))
        {
            $lst=explode(',', $row['group_id']);
            foreach ($lst as $value) {
                if($gid == $value)
                {
                    $count=$count+1;
                }
            }
        }
        return $count;
    }

    // this function calculates share on basis of thier guest count
    function calculateShare($gid,$userid,$amt,$mem_lst,$grp_mem_count)
    {
        $conn=mysqli_connect('localhost','root','','chipit') or die("error");
        $count=1;
        $amtpaid=$amt;
        $balance=0;
        $pershare=0;
        $new_bal=0;
        $share=0;
        $pershare=$amtpaid/$grp_mem_count;
        foreach ($mem_lst as $uid) 
        {
            if($userid == $uid)
            {
                $checkqry="SELECT group_id,nominee_id from guest where nominee_id=$uid";
                $checkexe=mysqli_query($conn,$checkqry);
                $checknum=mysqli_num_rows($checkexe);
                if($checknum>0) 
                {
                    while($row =  mysqli_fetch_assoc($checkexe))
                    {
                       $glst=explode(',', $row['group_id']);
                        foreach ($glst as $value) 
                        {
                            if($gid==$value)
                            {
                                $count=$count+1;
                            }
                        } 
                    }
                }
                $share=$count*$pershare;
                $balance=($balance+$amtpaid)-$share;
                $getbal="select pos_share from share where group_id=$gid && mem_id=$uid";
                $getexe=mysqli_query($conn,$getbal);
                $fetch=mysqli_fetch_array($getexe);
                $prev=$fetch['pos_share'];
                $new_bal=$balance+$prev;
                $up="UPDATE share set pos_share='".$new_bal."' where group_id=$gid && mem_id=$uid";
                $upexe=mysqli_query($conn,$up);

            }
            else
            {
                $checkqry="SELECT group_id,nominee_id from guest where nominee_id=$uid";
                $checkexe=mysqli_query($conn,$checkqry);
                $checknum=mysqli_num_rows($checkexe);
                if($checknum>0) 
                {
                    while($row =  mysqli_fetch_assoc($checkexe)) 
                    {
                       $glst=explode(',', $row['group_id']); 
                        foreach ($glst as $value) 
                        {
                            if($gid == $value)
                            {
                                $count=$count+1;
                            }
                        } 
                    }
                }
                $share=$count*$pershare;
                $getbal="select neg_share from share where group_id=$gid && mem_id=$uid";
                $getexe=mysqli_query($conn,$getbal);
                $fetch=mysqli_fetch_array($getexe);
                $prev=$fetch['neg_share'];
                $new_bal=$share+$prev;
                $up="UPDATE share set neg_share='".$new_bal."' where group_id=$gid && mem_id=$uid";
                $upexe=mysqli_query($conn,$up);
            }
            $balance=0;
            $count=1;
        }
    }



     // this function is to calculate owes and give amount
    function shareDifference($gid)
    {
        $conn=mysqli_connect('localhost','root','','chipit') or die("error");
        $checkqry="SELECT mem_id,pos_share,neg_share from share where group_id=$gid";
        $checkexe=mysqli_query($conn,$checkqry);
        $checknum=mysqli_num_rows($checkexe);
        if($checknum>0) 
        {
            while($row =  mysqli_fetch_assoc($checkexe)) 
            {
                $up_share=0;
                $set_share=0;
                $uid=$row['mem_id'];
                $pos_share=$row['pos_share'];
                $neg_share=$row['neg_share'];
                if($pos_share>$neg_share)
                {
                    $up_share=$pos_share-$neg_share;
                    $set_share=0;
                    $qry="UPDATE share set gets='".$up_share."',owes='".$set_share."' where group_id=$gid && mem_id=$uid";
                    $exe=mysqli_query($conn,$qry);
                }
                else if($neg_share>$pos_share)
                {
                    $up_share=$neg_share-$pos_share;
                    $set_share=0;
                    $qry="UPDATE share set gets='".$set_share."',owes='".$up_share."' where group_id=$gid && mem_id=$uid";
                    $exe=mysqli_query($conn,$qry);
                }
                else
                {
                    $up_share=0;
                    $set_share=0;
                    $qry="UPDATE share set gets='".$up_share."',owes='".$set_share."' where group_id=$gid && mem_id=$uid";
                    $exe=mysqli_query($conn,$qry);
                }
            }
        }
    }
?>