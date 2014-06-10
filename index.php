<?php
   include('config/config.php');
   $auth = new AUTH_USER();

if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
    echo ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
    }
else { header("Content-type: text/html"); }
?> 
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta charset="UTF-8" />
   
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery-1.10.2.min.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.liveSearch/js/jquery.liveSearch.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/func.js"></script>
   
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/css/bootstrap-theme.min.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/style/bootstrap_menu.css" />

   <?php
   /* If Lang defined, erase default jquery regional */
   if (DEF_LANG!='') {
   }
   ?>
   <?php
   // Javascript and css of admin
   if (GET('module') != 'dashboard') {
      ?>
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/css/demo_table.css" />
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.uix.multiselect/js/jquery.uix.multiselect.min.js"></script>
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.uix.multiselect/js/locales/jquery.uix.multiselect_fr.js"></script>
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/jquery.uix.multiselect/css/jquery.uix.multiselect.css" />
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/dyn_js.php"></script>
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.dataTables.min.js"></script>
      <?php
   }
   ?>

   <?php
   if (GET('module') == 'dashboard') {
         echo '
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/jquery-cascading-dropdown/jquery.cascadingdropdown.js"></script> 
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/sprintf.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/strftime.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/RrdRpn.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/RrdTime.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/RrdGraph.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/RrdGfxCanvas.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/binaryXHR.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/rrdFile.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/RrdDataFile.js"></script>
           <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/RrdCmdLine.js"></script>';
      if ($CONFIG['rrd_fetch_method'] == 'async') echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/get_rrd_async.js"></script>';
      else echo'<script type="text/javascript" src="'.DIR_WEBROOT.'/lib/javascriptrrd/get_rrd_sync.js"></script>';
   }
   ?>

   
   <title>CGRAPHZ <?php echo CGRAPHZ_VERSION; ?></title>
</head>
<body id="id_body">
<?php
if ($auth->verif_auth()) {
   include(DIR_FSROOT.'/html/menu/start_navmenu.php');
   include(DIR_FSROOT.'/html/menu/nav_menu.php');
   include(DIR_FSROOT.'/html/menu/end_navmenu.php');

   if (GET('module') == 'dashboard') {
      include(DIR_FSROOT.'/html/menu/menu_project.php');
   }
?>
<section style="margin-top: 110px">
   <?php include(DIR_FSROOT.'/config/module.php'); ?>
   <div id="mask" style="display: none;"></div>
   <div id="popup" style="display: none;"></div>
</section>


<?php
} else {
   include(DIR_FSROOT.'/html/auth/auth/f_auth.php');
}
?> 

</body>
</html>
