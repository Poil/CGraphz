<?php
$perm_mod = new PERMS();
if ($perm_mod->perm_module('dashboard','view')) {
	echo '	<p class="navbar-text" style="color: #ffffff; background-color: transparent; text-decoration: none;">Projets : </p>
			<select id="selectProject" class="nav navbar-nav demi-spacer">';
	if(!isset($_GET["f_id_config_project"])){
		echo '<option selected value=""> </option>';
	}
	foreach ($all_project as $project) {
		$selected="";
		if($_GET["f_id_config_project"]==$project->id_config_project){
			$selected="selected ";
		}
		echo '	<option '.$selected.'value="'.$project->id_config_project.'">'.$project->project_description.'</option>';
	}
	echo '</select>';
}
?>
<script type='text/javascript'>
	$('#selectProject').change(function(){
		var prj='';
        $('#selectProject option:selected').each(function(){
            prj=$(this).val();
        });
        $.ajax({
            type: 'GET',
            url: '<?php echo DIR_WEBROOT; ?>/lib/ajax/getServerByProject.ajax.php',
            data: 'f_id_config_project='+prj,
            success: function(msg){
                $('#selectServer').html(msg);
            }
        });
	});
</script>