<?php
include('../../../config/config.php');

$auth = new AUTH_USER();
if (!$auth->verif_auth()) {
        die();
}

$f_url=filter_input(INPUT_GET,'f_url',FILTER_SANITIZE_SPECIAL_CHARS);
parse_str(parse_url(html_entity_decode($f_url), PHP_URL_QUERY), $url_str);

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
<form onsubmit="refresh_graph('popup','',date_to_ts('f_time_start'),date_to_ts('f_time_end')); return false" action="" method="post" name="f_form_time_selection">
	<img id="move_popup" alt="<->" title="Move" src="img/drag.png" />
	<img id="close_popup" onclick="Close_Popup();" alt="x" title="Fermer" src="img/close.png" />
	<label for="f_time_start"><?php echo RANGE_START ?></label>
		<input id="f_time_start" value="<?php echo $date_start ?>" type="text" maxlength="16" size="16" name="f_time_start" />
	<br />
	<label for="f_time_end"><?php echo RANGE_END ?></label>
		<input id="f_time_end" value="<?php echo $date_end ?>" type="text" maxlength="16" size="16" name="f_time_end" />
	<br />
	<input type="submit" value="<?php echo SUBMIT ?>" />
	<input type="button" onclick="refresh_graph('dashboard','',date_to_ts('f_time_start'),date_to_ts('f_time_end')); Close_Popup(); return false" value="<?php echo SUBMIT_TO_DASHBOARD ?>" />
</form>
<?php
	echo '<img class="imggraph" src="'.$f_url.'" />';
?>
