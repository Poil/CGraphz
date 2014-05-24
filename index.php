<?php
	include('modules/config.php');
	$auth = new AUTH_USER();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />!-->
	
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/lib/css/redmond/jquery-ui-1.10.3.custom.min.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/lib/css/jquery-ui-timepicker-addon.css" />
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.strtotime.js"></script>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.liveSearch.js"></script>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.blockUI.js"></script>
	
	<?php
	/* If Lang defined, erase default jquery regional */
	if ($WEB['def_lang'] != '') {
		echo '<script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/development-bundle/ui/i18n/jquery.ui.datepicker-'.$WEB['def_lang'].'.js"></script>';
		echo '<script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/development-bundle/ui/i18n/jquery.ui.timepicker-addon-'.$WEB['def_lang'].'.js"></script>';
	}
	?>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/func.js"></script>
	<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/dateformat.js"></script>
	<?php
	// Javascript and css of admin
	if (GET('module') != 'dashboard') {
		?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/lib/css/demo_table.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/lib/multiselect/css/ui.multiselect.css" />
		<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/multiselect/js/jquery.tmpl.1.1.1.js"></script>
		<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.uix.multiselect/js/jquery.uix.multiselect.min.js"></script>
		<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.uix.multiselect/js/locales/jquery.uix.multiselect_fr.js"></script>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.uix.multiselect/css/jquery.uix.multiselect.css" />
		<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/dyn_js.php"></script>
		<script type="text/javascript" src="<?php echo $WEB['webroot_dir']; ?>/lib/jquery.dataTables.min.js"></script>
		<?php
	}
	?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/style/000.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $WEB['webroot_dir']; ?>/style/menu.css" />	 

	<?php
	if (GET('module') == 'dashboard') {
      	echo '<script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/sprintf.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/strftime.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/RrdRpn.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/RrdTime.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/RrdGraph.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/RrdGfxCanvas.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/binaryXHR.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/rrdFile.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/RrdDataFile.js"></script>
	        <script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/RrdCmdLine.js"></script>';
		if ($CONFIG['rrd_fetch_method'] == 'async') echo '<script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/get_rrd_async.js"></script>';
		else echo'<script type="text/javascript" src="'.$WEB['webroot_dir'].'/lib/javascriptrrd/get_rrd_sync.js"></script>';
	}
	?>

	
	<title>CGRAPHZ <?php echo $VERSION['cgraphz_version']; ?></title>
</head>
<body id="id_body">
<?php
if ($auth->verif_auth()) {
	include(DIR_FSROOT.'/html/menu/menu.php');
	echo '<div id="content">';
	include(DIR_FSROOT.'/module/module.php');
	echo '</div>
		<div id="mask" style="display: none;"></div>
		<div id="popup" style="display: none;"></div>';
} else {
	include(DIR_FSROOT.'/html/auth/auth/f_auth.php');
}
?> 

</body>
</html>
