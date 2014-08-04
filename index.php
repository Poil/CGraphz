<?php
   include('config/config.php');
   $auth = new AUTH_USER();

/*
if (stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml")) {
    header("Content-type: application/xhtml+xml");
    echo ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n");
    }
else { header("Content-type: text/html"); }
<!DOCTYPE html>
   <meta charset="UTF-8" />
*/
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery-2.1.1.min.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery-ui-1.10.4.custom.min.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.strtotime.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.liveSearch/js/jquery.liveSearch.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/js/bootstrap.min.js"></script>

   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/common.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/func.js"></script>
   <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/dateformat.js"></script>
   
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/bootstrap/css/bootstrap-theme.min.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/style/bootstrap_menu.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/style/bootstrap_extra.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.3.custom.css" />
   <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.10.3.theme.css" />

   <?php
   // Javascript and css of admin
   if (GET('module') != 'dashboard') {
      ?>
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/css/demo_table.css" />
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.uix.multiselect/js/jquery.uix.multiselect.js"></script>
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.uix.multiselect/js/locales/jquery.uix.multiselect_fr.js"></script>
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/lib/jquery.uix.multiselect/css/jquery.uix.multiselect.css" />
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/dyn_js.php"></script>
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="<?php echo DIR_WEBROOT; ?>/lib/dataTables.bootstrap.js"></script>
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo DIR_WEBROOT; ?>/style/dataTables.bootstrap.css" />
      <?php
   }
   ?>

   <?php
   if (GET('module') == 'dashboard') {
      echo '
         <link rel="stylesheet" type="text/css" media="screen" href="'.DIR_WEBROOT.'/lib/datetimepicker/css/bootstrap-datetimepicker.min.css" />

         <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/datetimepicker/js/moment.js"></script>
         <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
         <script type="text/javascript" src="'.DIR_WEBROOT.'/lib/datetimepicker/js/bootstrap-datetimepicker.en-24h.js"></script>
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
   }
   ?>

   
   <title>CGRAPHZ <?php echo CGRAPHZ_VERSION; ?></title>
</head>
<body id="id_body">
<?php
if ($auth->verif_auth()) {
   include(DIR_FSROOT.'/html/menu/nav_menu.php');

   if (GET('module') == 'dashboard' && GET('component') == 'view') {
      include(DIR_FSROOT.'/html/menu/menu_project.php');
      if (GET('f_id_config_server')) {
          include(DIR_FSROOT.'/html/menu/menu_plugin.php');
      }
      echo '<section style="margin-top: 140px">';
   } elseif (GET('module') == 'dashboard') {
      include(DIR_FSROOT.'/html/menu/menu_plugin.php');
      echo '<section style="margin-top: 90px">';
   } else {
      echo '<section style="margin-top: 60px">';
   }
?>
   <?php include(DIR_FSROOT.'/config/module.php'); ?>
   <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
       <div class="modal-content" style="display:inline-block">
          <div class="modal-body" id="popup"></div>
       </div>
     </div>
   </div>
</section>

<?php
} else {
   include(DIR_FSROOT.'/html/auth/auth/f_auth.php');
}
?> 

</body>
</html>
