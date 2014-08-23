<?php
include('../config/config.php');
$auth = new AUTH_USER();
// For instance, you can do something like this:
if(isset($_POST['width']) && isset($_POST['height'])) {
    $f_width = filter_input(INPUT_POST, 'width', FILTER_SANITIZE_NUMBER_INT);
    $f_height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT);

    //if ($CONFIG['detail-width'] > $f_width) {
    $_SESSION['detail-width'] = $f_width;
    //} else {
    //   $_SESSION['detail-width'] = $CONFIG['detail-width'];
    //}

    //if ($CONFIG['detail-height'] > $f_height {
    $_SESSION['detail-height'] = $f_height;
    //} else {
    //   $_SESSION['detail-height'] = $CONFIG['detail-height'];
    //}

} 
?>
