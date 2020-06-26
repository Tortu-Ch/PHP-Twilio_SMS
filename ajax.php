<?php
    header('Content-Type: text/html; charset=utf-8');
    header("Access-Control-Allow-Origin: *");

    require 'SendMms.php';
    $SendMms = new sendMms();
    $toNum = null;
    $body = null;
    $file_name = null;
    $mediaUrl = null;
    $root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
    $dir = $root . '/uploads/';
    $old = umask(0);

    if( !is_dir($dir) ) {
        mkdir($dir, 0755, true);
    }
    umask($old);

    if (isset($_FILES) && !empty($_FILES)) {
        if(isset($_FILES['fileName']) && !empty($_FILES['fileName'])) {
            $file = $_FILES['fileName'];
            $file_name = $file['name'];
            $path = $file['tmp_name'];
            $mediaUrl = 'https://'.$_SERVER['HTTP_HOST']."/uploads/".$file_name;
            $uploadpath = $dir;
            $uploadpath = $uploadpath . basename($file_name);
            if (move_uploaded_file($path, $uploadpath)) {

            } else {
                echo "There was an error uploading the file, please try again!";
            }
        }
    }
    else
    {
        $mediaUrl = $mediaUrl.'test.tmp';
    }
    $toNum = $_POST['toNum'];
    $body = $_POST['body'];
    $flag = $SendMms->MessageCreat($toNum,$body,$mediaUrl);
    if($flag)echo "ok";
?>