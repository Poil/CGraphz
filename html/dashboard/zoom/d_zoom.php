<?php
require_once('../../../config/config.php');

$auth = new AUTH_USER();
if (!$auth->verif_auth()) {
        die();
}

$f_server_name=filter_input(INPUT_GET,'h',FILTER_SANITIZE_STRING);
$connSQL=new DB();
$lib='SELECT COALESCE(collectd_version,"'.COLLECTD_DEFAULT_VERSION.'") as collectd_version FROM config_server WHERE server_name=:f_server_name';
$connSQL->bind('f_server_name',$f_server_name);
$cur_server=$connSQL->row($lib);

echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
echo '<meta name="viewport" content="width=1050, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />';

if(isset($_GET['s']) && $_GET['s']!="") {
    if (isset($_GET['e']) && $_GET['e']!="") {
        $date_start = date('Y-m-d H:i', intval($_GET['s']));
        $date_end = date('Y-m-d H:i', intval($_GET['e']));
    } else {
        $date_start = date('Y-m-d H:i', (time() - intval($_GET['s'])));
        $date_end = date('Y-m-d H:i');
    }
}else{
    $date_start = date('Y-m-d H:i', (time() - intval($CONFIG['time_range']['default'])));
    $date_end = date('Y-m-d H:i');
}
?>

<form  class="form-inline" role="form" onsubmit="refresh_graph('dashboard','',date_to_ts('f_time_start'),date_to_ts('f_time_end'));  Close_Popup(); return false" action="" method="post" name="f_form_time_selection">
  <div class="form-group">
    <label class="sr-only" for="f_time_start"><?php echo RANGE_START ?></label>
    <input type="text" value="<?php echo $date_start ?>" class="form-control" id="f_time_start" placeholder="<?php echo RANGE_START ?>"  maxlength="16" size="16" name="f_time_start">
  </div>
  <div class="form-group">
    <label class="sr-only" for="f_time_end"><?php echo RANGE_END ?></label>
    <input type="text" value="<?php echo $date_end ?>" class="form-control" id="f_time_end" placeholder="<?php echo RANGE_END ?>"  maxlength="16" size="16" name="f_time_end">
  </div>
  <button id="f_time_submit" class="btn btn-default" type="button" ><?php echo APPLY ?></button>
  <button class="btn btn-default" type="submit"><?php echo SUBMIT_TO_DASHBOARD ?></button>
</form>

<?php
if (empty($_GET['detail-width'])) $_GET['detail-width'] = $CONFIG['detail-width'];
if (empty($_GET['detail-height'])) $_GET['detail-height'] = $CONFIG['detail-height'];
$_GET['x'] = intval($_GET['detail-width']) - 150;
$_GET['y'] = intval($_GET['detail-height']) - 350;

chdir(DIR_FSROOT);
$CONFIG['version']=$cur_server->collectd_version;
include(DIR_FSROOT.'/graph.php');
echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/CGP.js"></script>';
echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/zoom.js"></script>';
?>
<script> $('#popupModal').modal('show'); </script>
