<?php
$perm = new PERMS();
$f_id_config_project=filter_input(INPUT_GET, 'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
$f_id_config_role=filter_input(INPUT_GET, 'f_id_config_role',FILTER_SANITIZE_NUMBER_INT);
$f_id_config_environment=filter_input(INPUT_GET, 'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);
$f_id_config_server=filter_input(INPUT_GET, 'f_id_config_server',FILTER_SANITIZE_NUMBER_INT);
?>
<nav class="navbar navbar-default navbar-fixed-top" style="top:50px; z-index:50">
  <div class="container-fluid" id="project_menu">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-inner">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-project">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-navbar-collapse-project">
      <form class="form-inline" role="form">
      <div class="form-group">
        <select name="f_id_config_project" id="f_id_config_project">
          <option disabled="disabled" selected="selected"><?php echo PROJECT; ?></option>
          <?php
          foreach ($perm->perm_list_project() as $cur_project) {
            if ($f_id_config_project==$cur_project->id_config_project) {
              echo '<option value="'.$cur_project->id_config_project.'" selected="selected">'.$cur_project->project_description.'</option>';
            } else {
              echo '<option value="'.$cur_project->id_config_project.'">'.$cur_project->project_description.'</option>';
            }
          }
          ?>
        </select>
      </div>
      <span class="glyphicon glyphicon-chevron-right"></span>
      <div class="form-group">
        <select name="f_id_config_environment" id="f_id_config_environment">
          <option><?php echo ENV; ?></option>
          <?php
          if (!empty($f_id_config_project)) {
            $project=new PROJECT($f_id_config_project);
            $environments=$project->get_servers_environments($f_id_config_role);
            foreach ($environments as $cur_environment) {
              if (count($environments)==1 || ($f_id_config_environment==$cur_environment->id_config_environment && $f_id_config_environment!=0)) {
                echo '<option value="'.$cur_environment->id_config_environment.'" selected="selected">'.$cur_environment->environment_description.'</option>';
              } else {
                echo '<option value="'.$cur_environment->id_config_environment.'">'.$cur_environment->environment_description.'</option>';
              }
            } 
          }
          ?>
        </select>
      </div>
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="glyphicon glyphicon-chevron-right"></span>
      <div class="form-group">
        <select name="f_id_config_role" id="f_id_config_role">
          <option><?php echo ROLE; ?></option>
          <?php
          if (!empty($f_id_config_project)) {
            $project=new PROJECT($f_id_config_project);
            foreach ($project->get_servers_roles($f_id_config_environment) as $cur_role) {
              if ($f_id_config_role==$cur_role->id_config_role && $f_id_config_role!=0) {
                echo '<option value="'.$cur_role->id_config_role.'" selected="selected">'.$cur_role->role_description.'</option>';
              } else {
                echo '<option value="'.$cur_role->id_config_role.'">'.$cur_role->role_description.'</option>';
              }
            } 
          }
          ?>
        </select>
      </div>
      <span class="glyphicon glyphicon-filter"></span>
      <div class="form-group">
        <select name="f_id_config_server" id="f_id_config_server">
          <option><?php echo SERVER; ?></option>
          <?php
          if (!empty($f_id_config_project)) {
            $project=new PROJECT($f_id_config_project);
              foreach ($project->get_servers($f_id_config_environment, $f_id_config_role) as $cur_server) {
                if ($f_id_config_server==$cur_server->id_config_server) {
                  echo '<option value="'.$cur_server->id_config_server.'" selected="selected">'.$cur_server->server_name.'</option>';
                } else {
                  echo '<option value="'.$cur_server->id_config_server.'">'.$cur_server->server_name.'</option>';
                }
              } 
            }
            ?>
        </select>
      </div>
      </form>
    </div>
  </div>
</nav>

<script type="text/javascript">
$(document).ready(function(){
    $('#f_id_config_project').on('change', function (){
        $.getJSON('ajax/json_server.php', {f_id_config_project: $(this).val()}, function(data){
            var options = '<option selected="selected"><?php echo SERVER; ?></option>';
            for (var x = 0; x < data.length; x++) {
                options += '<option value="' + data[x]['id_config_server'] + '">' + data[x]['server_name'] + '</option>';
            }
            $('#f_id_config_server').html(options);
        }),
        $.getJSON('ajax/json_environment.php', {f_id_config_project: $(this).val()}, function(data){
            var options = '<option selected="selected"><?php echo ENV; ?></option>';
            for (var x = 0; x < data.length; x++) {
                options += '<option value="' + data[x]['id_config_environment'] + '">' + data[x]['environment_description'] + '</option>';
            }
            $('#f_id_config_environment').html(options);
        }),
        $.getJSON('ajax/json_role.php', {f_id_config_project: $(this).val()}, function(data){
            var options = '<option selected="selected"><?php echo ROLE; ?></option>';
            for (var x = 0; x < data.length; x++) {
                options += '<option value="' + data[x]['id_config_role'] + '">' + data[x]['role_description'] + '</option>';
            }
            $('#f_id_config_role').html(options);
        });
    });

    $('#f_id_config_environment').on('change', function (){
	if ($('#f_id_config_role').val()!="") { var role=$('#f_id_config_role option:selected').text(); }
        $.getJSON('ajax/json_server.php', {
		f_id_config_project: $('#f_id_config_project').val(),
		f_id_config_role: $('#f_id_config_role').val(),
		f_id_config_environment: $(this).val()
	}, function(data){
            var options = '<option selected="selected"><?php echo SERVER; ?></option>';
            for (var x = 0; x < data.length; x++) {
                options += '<option value="' + data[x]['id_config_server'] + '">' + data[x]['server_name'] + '</option>';
            }
            $('#f_id_config_server').html(options);
        }),
        $.getJSON('ajax/json_role.php', {
		f_id_config_project: $('#f_id_config_project').val(),
		f_id_config_environment: $(this).val()
	}, function(data){
            var options = '<option><?php echo ROLE; ?></option>';
            for (var x = 0; x < data.length; x++) {
		if (role ==  data[x]['role_description']) {
                	options += '<option value="' + data[x]['id_config_role'] + '" selected="selected">' + data[x]['role_description'] + '</option>';
		} else {
                	options += '<option value="' + data[x]['id_config_role'] + '">' + data[x]['role_description'] + '</option>';
		}
            }
            $('#f_id_config_role').html(options);
        });
    });

    $('#f_id_config_role').on('change', function (){
	if ($('#f_id_config_environment').val()!="") { var environment=$('#f_id_config_environment option:selected').text(); }
        $.getJSON('ajax/json_server.php', {
		f_id_config_project: $('#f_id_config_project').val(),
		f_id_config_environment: $('#f_id_config_environment').val(),
		f_id_config_role: $(this).val()
	}, function(data){
            var options = '<option selected="selected"><?php echo SERVER; ?></option>';
            for (var x = 0; x < data.length; x++) {
               	options += '<option value="' + data[x]['id_config_server'] + '">' + data[x]['server_name'] + '</option>';
            }
            $('#f_id_config_server').html(options);
        }),
        $.getJSON('ajax/json_environment.php', {
		f_id_config_project: $('#f_id_config_project').val(),
		f_id_config_role: $(this).val()
	}, function(data){
            var options = '<option><?php echo ENV; ?></option>';
            for (var x = 0; x < data.length; x++) {
		if (environment ==  data[x]['environment_description']) {
                	options += '<option value="' + data[x]['id_config_environment'] + '" selected="selected">' + data[x]['environment_description'] + '</option>';
		} else {
                	options += '<option value="' + data[x]['id_config_environment'] + '">' + data[x]['environment_description'] + '</option>';
		}
            }
            $('#f_id_config_environment').html(options);
        });
    });

    $('#f_id_config_server').on('change', function (){
       window.location = 'index.php?module=dashboard&component=view'
		+'&f_id_config_project=' + $('#f_id_config_project').val()
		+'&f_id_config_environment=' + $('#f_id_config_environment').val()
		+'&f_id_config_role=' + $('#f_id_config_role').val()
		+'&f_id_config_server=' + $(this).val();
    });

});
</script>
