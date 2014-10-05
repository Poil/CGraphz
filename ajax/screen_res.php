<?php
include('../config/config.php');
$auth = new AUTH_USER();
// For instance, you can do something like this:
if(isset($_POST['width']) && isset($_POST['height'])) {
    $f_width = filter_input(INPUT_POST, 'width', FILTER_SANITIZE_NUMBER_INT);
    $f_height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_NUMBER_INT);

    $_SESSION['detail-width'] = $f_width;
    $_SESSION['detail-height'] = $f_height;
} 
?>
