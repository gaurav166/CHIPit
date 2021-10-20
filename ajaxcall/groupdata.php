<?php
	$gid=$_REQUEST['gid'];
	session_start();
	$userid=$_SESSION['userid'];
  	include_once("../configure/configure.php");
  	$infoqry="SELECT * from groups where group_id=$gid";
  	$infoexe=mysqli_query($conn,$infoqry);
  	$infotot=mysqli_num_rows($infoexe);
  	if($infotot==1)
  	{
  		$grp_fetch=mysqli_fetch_array($infoexe);
		  $grp_name=$grp_fetch['group_name'];
		  $grp_avtar=$grp_fetch['avtar'];
		  $members=$grp_fetch['group_member'];
  	} 	
?>
<div class="grp-wrapheader">
	<img src="groups/<?php echo $grp_avtar ?>" width="40" height="41" class="img-circle pull-left">
	<span class="pull-left wraptxt">
 		<?php echo $grp_name ?>
	</span>
</div>
 <div id="myDIV">
<ul class="nav nav-tabs" id="tabs">
 
  <a data-toggle="tab" href="#home"><button class="tabs pull-left btn22 active">Expenses</button></a>
  <a data-toggle="tab" href="#menu1" onclick="membersdata(<?php echo $gid ?>)"><button class="tabs pull-left btn22">group members</button></a>
  <a data-toggle="tab" href="#menu2" onclick="sharedata(<?php echo $gid ?>)"><button class="tabs pull-left btn22">friend share</button></a>

</ul>
</div>


<!-- expenses tabs -->
<div class="tab-content">
	<div id="home" class="tab-pane fade in active exppad">
	  <div class="tran-body scrollbar-secondary">
	  	<?php 
			$chat_qry="SELECT expenses.title,expenses.amt,expenses.tym,user.user_id,user.user_name,user.user_profile from expenses JOIN user on expenses.mem_id=user.user_id where expenses.group_id=$gid order by tym";
			$chat_exe=mysqli_query($conn,$chat_qry);
			$chat_count=mysqli_num_rows($chat_exe);
			if($chat_count>0)
			{
				while($chat_fetch=mysqli_fetch_array($chat_exe))
				{
					$uid = $chat_fetch['user_id'];
					$dt = $chat_fetch['tym'];
					$dtarray = explode(" ", $dt);
					$d = $dtarray[0];
					$t = $dtarray[1];
					$date = date('d-m-Y',strtotime($d));
					$time = date('h:i',strtotime($t));
					if($userid!=$uid)
					{
		?>
						<div class="msg-body">
		        			<div class="msg-img pull-left">
		        				<img class="img-circle" src="profiles/<?php echo $chat_fetch['user_profile'] ?>" width="35" height="35" />
		      				</div>
		      				<div class="msg-txt pull-left">
		        				<?php echo $chat_fetch['user_name'] ?> paid for <?php echo $chat_fetch['title'] ?>
		        				<span class="msg-money">
		          				<i class="fa fa-inr" aria-hidden="true"></i>
		          					<?php echo $chat_fetch['amt'] ?>
		        				</span>
		        				<div class="msg-time"><?php echo $date ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $time ?></div>
		      				</div>
		    			</div>
		    			<div class="clearfix"></div>
		<?php			
					}
					else
					{
		?>
						<div class="msg-body pull-right" style="margin-bottom:3px;">
      						<div class="msg-txt">
        						You paid for <?php echo $chat_fetch['title'] ?>
        						<span class="msg-money">
          							<i class="fa fa-inr" aria-hidden="true"></i>
          							<?php echo $chat_fetch['amt'] ?>
        						</span>
        						<div class="msg-time"><?php echo $date ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $time ?></div>
      						</div>
    					</div>
    					<div class="clearfix"></div>
	    <?php
					}
				}
			}
			else
			{
				echo '<label style="margin-top:115px;margin-left:220px;font-size:15px;color:#a07bb7;">Add expenses to get started</label>';
			}
		?>
	  </div>
	  <button id="btnaddexpenses" class="btn-remind tran-btn btn-dialog" data-toggle="modal" data-target="#addexpenses">+ Add Expenses</button>
	</div>
	<!-- Group Member -->
	<div id="menu1" class="tab-pane fade exppad">
		<div class="inner-mem scrollbar-secondary" style="height:285px;">
			<table class="frnd-table" id="member">
	  
			</table>
		</div>
		<button class="btn-remind btn-dialog tran-btn" data-toggle="modal" data-target="#addguest" style="float:left;width:49%;">+ Add Guest</button>
		<button class="btn-remind btn-dialog tran-btn" data-toggle="modal" data-target="#addmember" style="float:right;width:50%;">+ Add New Member</button>
	</div>
	<!-- User Share  -->
	<div id="menu2" class="tab-pane fade usershare-main">
	  <div id="fshare" class="usershare-container">
      

    </div>
	</div>
</div>


<!-- Add Member Dialog Box -->
<div class="modal fade-scale" id="addmember" tabindex="-1" role="dialog" aria-labeledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
      	<div class="log-header">Add Memeber</div>
        <form role="form" method="post">
          <div  style="margin-bottom:10px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;"></div>
          <!-- list from friends page -->
          <div class="all-members scrollbar-secondary cnt-frndlst">
                  <table class="frnd-table">
                    <?php
                      $memshow="SELECT user.user_id,friends.frnd_id,friends.frnd_mail,friends.frnd_name from user join friends on friends.frnd_mail=user.user_mail where friends.mem_id=$userid";
                      $memshow_exe=mysqli_query($conn,$memshow);
                      $memshow_tot=mysqli_num_rows($memshow_exe);
                      if($memshow_tot>0)
                      {
                        while($memfetch=mysqli_fetch_array($memshow_exe))
                        {
                    ?>
                          <tr>
                            <td style="padding-left:15px;">
                               <input type="checkbox" name="ch" value="<?php echo $memfetch['user_id']; ?>" style="margin-right:5px;"/>
                                <?php echo $memfetch['frnd_mail']; ?>
                              </label>
                            </td>
                            <td style="text-transform:capitalize;">
                              <?php echo $memfetch['frnd_name']; ?>
                            </td>
                          </tr>
                    <?php      
                        }
                      }
                      else
                      {
                    ?>
                        <div class="empty-lst" style="margin-top:60px;margin-left:70px;">Add <b>Friends</b> to get into action !!</div>
                    <?php
                      }
                    ?>
                  </table>
                </div>
           <input type="submit" class="btn-remind btn-dialog" style="width: 100%;"  value="+ Add Member" id="submem"/>
        </form>
      </div>      
    </div>
  </div>
</div>



<!-- Add Guest Dialog Box -->
<div class="modal fade-scale" id="addguest" tabindex="-1" role="dialog" aria-labeledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
      	<div class="log-header">Add Guest</div>
        <form role="form" method="post">
          <div  id="ans" style="margin-bottom:10px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;"></div>
          <label for="name" class="input-text">Guest ID</label>
          <input type="text" name="guestid" class="form-control input-sz" placeholder="Type here" autocomplete="off" id="gname"/> 
          <input type="submit" name="guestadd" class="btn-remind btn-dialog" style="width:100%;" value="+ Add Guest" id="guestsub"/>
        </form>
      </div>      
    </div>
  </div>
</div>




<!-- Add Expenses Dialog Box -->
<div class="modal fade-scale" id="addexpenses" tabindex="-1" role="dialog" aria-labeledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
      	<div class="log-header">Add Expenses</div>
        <form role="form" method="post">
          <div id="ans" style="margin-bottom:10px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;">
          </div>
          <label for="name" class="input-text">Expense Title</label>
          <!-- title text filed -->
          <input type="text" name="exptitle" class="form-control input-sz" placeholder="Type here" autocomplete="off" id="expt"/>
          <label for="name" class="input-text">Expense Amount</label>
          <!-- amount text field -->
          <input type="text" name="expamt" class="form-control input-sz" placeholder="Type here" autocomplete="off" id="eamt"/>
          <input type="submit" class="btn-remind btn-dialog" style="width:100%;" value="+ Add Expenses" id="subm"/>
        </form>
      </div>      
    </div>
  </div>
</div>
<script>
	function membersdata(gid){
	    $.ajax({
		    url: "ajaxcall/members.php?gid="+gid,
		    success: function(response) {
		      $('#member').html(response);
		    }
		});
	}
	function sharedata(gid){
	    $.ajax({
		    url: "ajaxcall/usershare.php?gid="+gid,
		    success: function(response) {
		      $('#fshare').html(response);
		    }
		});
	}
</script>
<script>
    // for add expenses
   	$(document).ready(function(){
    	$("#subm").on('click',function(){
    		   var m=$("#expt").val();
	         var n=$("#eamt").val();
	         var groupid="<?php echo $gid ?>";
	         if (m =="" || n =="") 
	         {
	          	$("#ans").html("Please fill all details");
	          	return false;
	    	   }
	    	   else
	      	 {
	      		  $.ajax({
	      			url:"ajaxcall/expenses.php",
	            	method:"post",
	            	data:{
	              		expent:m,
	              		expam:n,
	              		gt:groupid
	            	},
	            	success:function(response){
	            		alert(response);
	            	}
	      		  });
	      	  }
    	});

    	// for add guest
    	$("#guestsub").on('click',function(){
    		var gname=$("#gname").val();
    		var groupid="<?php echo $gid ?>";
    		if(gname =="")
    		{
    			$("#ans").html("Please fill all details");
    			return false;
    		}
    		else
    		{
				$.ajax({
					url:"ajaxcall/addguest.php",
					method:"post",
					data:{
						guest:gname,
						gt:groupid
					},
					success:function(response){
						alert(response);
					}
				});
    		}
    	});

    	// for add member
       $("#submem").on('click',function(){
        var favorite = [];
        $.each($("input[name='ch']:checked"), function(){
              favorite.push($(this).val());
        });
        var x = favorite.toString();
        var groupid="<?php echo $gid ?>";
        $.ajax({
          url:"ajaxcall/memupdate.php",
          method:"post",
          data:{
            gid:groupid,
            list:x
          },
          success:function(response){
            alert(response);
          }
        });
      });
    });
</script>
<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("myDIV");
var btns = header.getElementsByClassName("btn22");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("active");
  current[0].className = current[0].className.replace(" active", "");
  this.className += " active";
  });
}
</script>
