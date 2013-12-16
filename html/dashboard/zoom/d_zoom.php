<?php
include('../../../config/config.php');

$auth = new AUTH_USER();
if (!$auth->verif_auth()) {
        die();
}

$f_server_name=filter_input(INPUT_GET,'h',FILTER_SANITIZE_STRING);
$connSQL=new DB();
$lib='SELECT COALESCE(collectd_version,"'.COLLECTD_DEFAULT_VERSION.'") as collectd_version FROM config_server WHERE server_name=:f_server_name';
$connSQL->bind('f_server_name',$f_server_name);
$cur_server=$connSQL->row($lib);

echo '<meta name="viewport" content="width=1050, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes" />';

if (isset($_SESSION['time_start']) && $_SESSION['time_start']!='') {
	$date_start=date('Y-m-d H:i',$_SESSION['time_start']);
} else {
	$date_start=date('Y-m-d H:i',mktime() - $url_str['s'] );
}
if (isset($_SESSION['time_end']) && $_SESSION['time_end']!='') {
	$date_end=date('Y-m-d H:i',$_SESSION['time_end']);
} else {
	$date_end=date('Y-m-d H:i');
}

?>

<form onsubmit="refresh_graph('dashboard','',date_to_ts('f_time_start'),date_to_ts('f_time_end'));  Close_Popup(); return false" action="" method="post" name="f_form_time_selection">
	<img id="move_popup" alt="<->" title="Move" src="img/drag.png" />
	<img id="close_popup" onclick="Close_Popup();" alt="x" title="Fermer" src="img/close.png" />
	<label for="f_time_start"><?php echo RANGE_START ?></label>
		<input id="f_time_start" value="<?php echo $date_start ?>" type="text" maxlength="16" size="16" name="f_time_start" />
	<br />
	<label for="f_time_end"><?php echo RANGE_END ?></label>
		<input id="f_time_end" value="<?php echo $date_end ?>" type="text" maxlength="16" size="16" name="f_time_end" />
	<br />
	<input type="submit" value="<?php echo SUBMIT_TO_DASHBOARD ?>" />
</form>
<?php
	if (empty($_GET['x']))
	$_GET['x'] = $CONFIG['detail-width'];
	if (empty($_GET['y']))
	$_GET['y'] = $CONFIG['detail-height'];

	chdir(DIR_FSROOT);
	$CONFIG['version']=$cur_server->collectd_version;
	include(DIR_FSROOT.'/plugin/'.GET('p').'.php');
	echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/CGP.js"></script>';
?>
