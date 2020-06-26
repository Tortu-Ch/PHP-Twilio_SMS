<?php
require 'SendMms.php';
$SendMms = new sendMms();
$messages = $SendMms->MessageRead();
$t_sid = 'AC1d9a85ec880e91f93818160bab628a58';
$t_token = '0a40e4e00137dcaa53f3beb0bd879b7f';
?>
<!doctype html>
<html lang="en">

<head>
    <title>TwilioSMS</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- Material Kit CSS -->
    <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link href="assets/demo/demo.css" rel="stylesheet" />

</head>

<body>
<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white">
        <div class="logo">
            <a class="simple-text logo-normal">
                Twilio SMS
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:sendMessage('')">
                        <i class="material-icons text-success">perm_phone_msg</i>
                        <p class="text-success">Send Message</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="content" style="margin-top: 0px">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-success row">
                                <h4 class="card-title ">Incoming Messages</h4>&nbsp;&nbsp;
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-success text-center">
                                        <th width="5%">No</th>
                                        <th width = "15%">PhoneNum</th>
                                        <th width="60%">body</th>
                                        <th width="15%">images/media</th>
                                        </thead>
                                        <tbody id = 'messageBody'>
                                        <?php
                                        $no=1;
                                        foreach ($messages as $row)
                                        {
//                                            $SendMms->MessageDelte($row->sid);
                                            if($no > 25)break;
                                            else if($row->status == 'received') {
                                                $mediaContentType = null;
                                                $mediaUri = null;
                                                $media = null;
                                                $ext = null;
                                                if ($row->numMedia > 0) {
                                                    $media = $SendMms->MediaRead($row->sid);
                                                    $mediaContentType = $media->contentType;
                                                    if ($media->contentType) {
                                                        $mediaUri = $media->uri;
                                                        $temp = explode(".", $mediaUri);
                                                        $mediaUri = 'https://api.twilio.com/' . $temp[0];
                                                        $ext = explode("/", $mediaContentType);
                                                        $ext = $ext[0];
                                                    }
                                                }
                                                $phoneNum = str_replace("+1", "", $row->from);
                                                $phoneNum = str_split($phoneNum, 3);
                                                $linkNum = $phoneNum[0] . '-' . $phoneNum[1] . '-' . $phoneNum[2] . $phoneNum[3];
                                                $phoneNum = '(' . $phoneNum[0] . ') ' . $phoneNum[1] . '-' . $phoneNum[2] . $phoneNum[3];
                                                ?>
                                                <tr id="tr_<?php echo $no ?>">
                                                    <td class="text-center text-gray"><?php echo $no ?></td>
                                                    <td class="text-center text-gray">
                                                        <a class="text-gray"
                                                           href="javascript:sendMessage('<?php echo $linkNum ?>')">
                                                            <?php echo $phoneNum ?>
                                                        </a>
                                                    </td>
                                                    <td class="text-gray"><?php echo $row->body ?></td>
                                                    <td class="text-center text-gray">
                                                        <a class="text-gray"
                                                           href="javascript:ViewMedia('<?php echo $mediaUri ?>', '<?php echo $ext ?>')">
                                                            <?php echo $mediaContentType ?>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $no++;
                                            }
                                        }

                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright float-right">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </div>
                <!-- your footer here -->
            </div>
        </footer>
    </div>
    <!--- modal box is here ---->
    <div class='modal fade bs-example-modal-sm' id='messageModal' style="margin-top: 10px">
        <div class="modal-dialog modal-sm" style="max-width: 1000px; max-height: 500px">
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title text-success'>SendMessageBox</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>
                <div class='modal-body' id='m1' style="max-height: 500px">
                    This is default text, Click Display Message.
                </div>
            </div>
        </div>
    </div><!-- end of modal -->

    <!--- modal box is here ---->
    <div class='modal fade bs-example-modal-sm' id='mediaModal' style="margin-top: 10px">
        <div class="modal-dialog modal-sm" style="max-width: 1000px; max-height: 500px">
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4 class='modal-title text-success'>MediaViewBox</h4>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                </div>
                <div class='modal-body' id='m2' style="max-height: 500px">
                    This is default text, Click Display Message.
                </div>
            </div>
        </div>
    </div><!-- end of modal -->

</div>
</body>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap-material-design.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script>
    function ViewMedia(uri, ext) {
        $('#mediaModal').modal();
        $('#m2').text('Wait..');
        $('#m2').load("media.php?uri="+uri+"&ext="+ext);
    }

    function sendMessage(phoneNum) {
        $('#messageModal').modal();
        $('#m1').text('Wait..');
        $('#m1').load("message.php?phoneNum="+phoneNum);
    }

    // $(document).ready(function () {
    //    $('#check_all').click(function (e) {
    //        if($('#check_all').prop('checked'))
    //        {
    //            $("#messageBody input").prop('checked','true');
    //            $('#check_all').val('off');
    //        }
    //        else
    //        {
    //            $("#messageBody input").prop('checked', false);
    //            $('#check_all').val('on');
    //        }
    //    });
    // });

</script>
</html>