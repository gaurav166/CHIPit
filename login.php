<!-- Login Dialog Box -->
<div class="modal fade" id="popUpWindow" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
      <div class="log-header">Login To CHIPit</div>
        <form role="form" method="post" id="cform">
          <div style="margin-top:30px;margin-left:25px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;" id="ans">
          </div>
          <div class="form-group">
            <input type="email" name="lmail" class="form-control input-size" placeholder="Email" autocomplete="off" id="emails" />
            <input type="password" name="lpass" class="form-control input-size" placeholder="Password" autocomplete="off" id="pass" />
            <input type="button" name="lsubmit" value="Login" class="btn-remind btn-dialog btn-block" id="lsub" style="margin-left:25px;width:87%;margin-top:20px;" />
          </div> 
        </form>
      </div>         
    </div>
  </div>
</div>
<script>
  $(document).ready(function()
  {
     $("#lsub").on('click',function()
     {
      var ema=$("#emails").val();
      var pas=$("#pass").val();
      var a=$("#ans").val();
      if (ema =="" || pas =="") {
          $("#ans").html("Please fill all details");
      }
      else
      {
        $.ajax(
        {
            url:"ajaxcall/loginprocess.php",
            method:"post",
            data:{
              emailphp:ema,
              pasphp:pas
            },
            success:function(response){
               $("#ans").html(response);
            
            }
        });
      }

     });
     $(".modal").on("hidden.bs.modal",function(){
        $('#cform')[0].reset();
        $("#ans").html('');
     });
  });
</script>
 