<?php
	include('config/config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type" />
	
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/style/000.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/style/menu.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/css/redmond/jquery-ui-1.8.10.custom.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/css/jquery-ui-timepicker-addon.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/css/dataTable.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/multiselect/css/common.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/multiselect/css/ui.multiselect.css" />	 
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery-ui-1.8.10.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery-ui-timepicker-addon.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.strtotime.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.localisation.min.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/multiselect/js/jquery.tmpl.1.1.1.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/multiselect/js/ui.multiselect.js"></script>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.liveSearch.js"></script>
	
	<?php
	/* If Lang defined, erase default jquery regional */
	if (DEF_LANG!='') {
		echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/development-bundle/ui/i18n/jquery.ui.datepicker-'.DEF_LANG.'.js"></script>';
		//echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/development-bundle/ui/i18n/jquery.ui.timepicker-'.DEF_LANG.'.js"></script>';
		echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/development-bundle/ui/i18n/jquery.ui.timepicker-addon-'.DEF_LANG.'.js"></script>';
	}
	?>
	<script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/func.js"></script>
	
	
	<title>CGRAPHZ <?php echo CGRAPHZ_VERSION; ?></title>
</head>
<body id="id_body">
<div id="content">
<?php
$auth = new AUTH_USER();
if ($auth->verif_auth()) {
	include(DIR_FSROOT.'/html/menu/menu.php');
	include(DIR_FSROOT.'/config/module.php');
} else {
	include(DIR_FSROOT.'/html/auth/auth/f_auth.php');
}

?> 
</div>

<div id="mask" style="display: none;"></div>
<div id="popup" style="display: none;"></div>

</body>
</html>
