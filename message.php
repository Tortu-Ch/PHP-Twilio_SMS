<?php
    $num1 = null;
    $num2 = null;
    $num3 = null;
    if(isset($_GET['phoneNum']) && !empty($_GET['phoneNum']))
    {
        $temp = explode("-", $_GET['phoneNum']);
        $num1 = $temp[0];
        $num2 = $temp[1];
        $num3 = $temp[2];
    }
?>
<script>
    $(document).ready(function () {
        $('#send_bt').click(function () {
            if($('#phone_1').val().length < 3)$('#phone_1').focus();
            else if($('#phone_2').val().length < 3)$('#phone_2').focus();
            else if($('#phone_3').val().length < 4)$('#phone_3').focus();
            else if($('#txt_message').val() == '' && $('#media_message').val() == '')$('#txt_message').focus();
            else
            {
                $('#send_bt').attr('disabled', true);
                var toNum = '+1'+$('#phone_1').val()+$('#phone_2').val()+$('#phone_3').val();
                let files = new FormData(), // you can consider this as 'data bag'
                    url = 'yourUrl';
                files.append('fileName', $('#media_message')[0].files[0]); // append selected file to the bag named
                files.append('toNum', toNum);
                files.append('body', $('#txt_message').val());
                $.ajax({
                    type: 'post',
                    url: 'ajax.php',
                    processData: false,
                    contentType: false,
                    data: files,
                    success: function (response) {
                        if(response == 'ok') {
                            $("#send_ok").fadeIn(200);
                            $("#send_ok").fadeOut(5000);
                            $('#phone_1').val('');
                            $('#phone_2').val('');
                            $('#phone_3').val('');
                            $('#txt_message').val('');
                            $('#media_message').val('');
                        }
                        else
                        {
                            $( "#send_error" ).fadeIn(200);
                            $( "#send_error" ).fadeOut(10000);
                        }
                        $('#send_bt').attr('disabled', false);
                    },
                    error: function (err) {
                        console.log(err);
                        $('#send_bt').attr('disabled', false);
                    }
                });
            }
        });
    });
</script>
<div class="header" id = "send_ok" style="display: none">
    <p class="text-success">Message transfer successful</p>
</div>
<div class="header" id = "send_error" style="display: none">
    <p class="text-warning">There was an error in transfer the Message. Try again.</p>

</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" style="margin-left: 20px;">
                        <form id="sendform" enctype="multipart/form-data" method="POST">
                        <div class="row">
                            <input type="text" disabled class="form-control text-success" value="Phone Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;(" style="width: 125px; border: 0px">
                            <input type="text" value="<?php echo $num1?>" id="phone_1" name="phone_1" class="form-control text-center" maxlength="3" style="width: 40px">
                            <input type="text" disabled class="form-control text-success" value=")" style="width: 10px; border: 0px">
                            <input type="text" value="<?php echo $num2?>" id="phone_2" name="phone_2" class="form-control text-center" maxlength="3" style="width: 40px">
                            <input type="text" disabled class="form-control text-success" value="-" style="width: 10px; border: 0px">
                            <input type="text" value="<?php echo $num3?>" id="phone_3" name="phone_3" class="form-control text-center" maxlength="4" style="width: 40px">
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <input type="text" disabled class="form-control text-success" value="Message Content:" style="width: 120px; border: 0px">
                            <textarea id = "txt_message" name = "txt_message" class="form-control rounded-0" cols="85" rows="7"></textarea>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <input type="text" disabled class="form-control text-success" value="Image/Media&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;" style="width: 120px; border: 0px">
                            <input type="file" id = "media_message" name = "media_message" class="profile-photo" style="margin-top: 5px">
                        </div>
                        </form>
                        <div class="text-center">
                            <button style="button" id = 'send_bt' class="btn btn-facebook">Send Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='modal fade bs-example-modal-sm' id='alertmodal' style="margin-top: 10px">
    <div class="modal-dialog modal-sm" style="max-width: 1000px; max-height: 500px">
        <div class='modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title text-success'>SendMessageBox</h4>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            </div>
            <div class='modal-body' id='m' style="max-height: 500px">
                This is default text, Click Display Message.
            </div>
        </div>
    </div>
</div><!-- end of modal -->
