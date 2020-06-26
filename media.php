<?php
if(isset($_GET['uri']) && !empty($_GET['uri'])) {
    $url = $_GET['uri'];

    if(isset($_GET['ext']) && !empty($_GET['ext']))
    {
        if($_GET['ext'] == 'image')
        {
            echo " <center><img src=\"$url\" style='max-height: 400px'></center> ";
        }
        else if($_GET['ext'] == 'audio')
        {
            echo" <center><audio controls>
                      <source src=\"$url\">
                   </audio></center>";
        }
        else if($_GET['ext'] == 'video')
        {
            echo " <center>
                <video controls>
                      <source src=\"$url\">
                </video></center>";
        }
    }
}
?>