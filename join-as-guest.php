<!-- Join As Guest Dialog Box -->
<div class="modal fade" id="popUpWindow2" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content add-dialogbox">
      <div class="modal-body">
      <div class="log-header">Join To CHIPit</div>
        <form role="form" method="post" id="gform">
          <div style="margin-top:30px;margin-left:25px;margin-right:25px;color:#c54a4a;text-transform:initial;text-align:justify;" id="ans">
          </div>
          <div class="form-group">
            <input type="text" name="gname" class="form-control input-size" placeholder="Guest Nickname" autocomplete="off" id="gnames" />
            <input type="button" name="gsubmit" value="Join As Guest" class="btn-remind btn-dialog btn-block" id="gsub" style="margin-left:25px;width:87%;margin-top:20px;" />
          </div> 
        </form>
      </div>         
    </div>
  </div>
</div>

<script>
  $(document).ready(function()
  {
     $("#gsub").on('click',function()
     {
      var name=$("#gnames").val();
      if (name =="") {
          $("#ans").html("Please fill all details");
      }
      else
      {
        $.ajax(
        {
            url:"ajaxcall/guestprocess.php",
            method:"post",
            data:{
              guestname:name,
            },
            success:function(response){
               $("#ans").html(response);
            }
        });
      }

     });
     $(".modal").on("hidden.bs.modal",function(){
        $('#gform')[0].reset();
        $("#ans").html('');
     });
  });
</script>
