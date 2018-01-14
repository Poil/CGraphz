<?php
$perm = new PERMS();
$f_id_config_project=filter_input(INPUT_GET, 'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
?>
<nav class="navbar navbar-default navbar-fixed-top" style="top:50px; z-index:50">
  <div class="container-fluid" id="quickview_menu">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-inner">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-quickview">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-quickview">
    <?php
      $qv = new Form('inline');
      $qv->add('select','f_id_config_project')
         ->options($perm->perm_list_project(), 'id_config_project', 'project_description')
         ->value($f_id_config_project)
         ->formcontrol(false);

      $qv->add('html','<span class="glyphicon glyphicon-filter"></span>');

      $qv->add('text','f_regexp_server')
         ->placeholder('regexp')
         ->formcontrol(false);

      $qv->add('select','f_id_config_plugin_filter')
         ->options($perm->perm_list_plugin_filter(), 'id_config_plugin_filter', 'plugin_filter_desc')
         ->value($f_id_config_project)
         ->formcontrol(false);

      $qv->add('button','f_prepend')
         ->value(PREPEND);

      $qv->add('button','f_append_after')
         ->value(APPEND_AFTER);

      $qv->add('button','f_advanced')
         ->value(ADVANCED);

      $qv->add('button','f_edit')
         ->value(ADVANCED);


      echo $qv->bindForm();
    ?>

    </div>
  </div>
</nav>

