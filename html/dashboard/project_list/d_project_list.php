<?php
$perm_mod = new PERMS();
if ($perm_mod->perm_module('dashboard','view')) {
	echo '	<p class="navbar-text" style="color: #ffffff; background-color: transparent; text-decoration: none;">Projets : </p>
			<select class="nav navbar-nav demi-spacer">';
	if(!isset($_GET["f_id_config_project"])){
		echo '<option selected value=""> </option>';
	}
	foreach ($all_project as $project) {
		$selected="";
		if($_GET["f_id_config_project"]==$project->id_config_project){
			$selected="selected ";
		}
		echo '	<option '.$selected.'value="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$project->id_config_project.'">'.$project->project_description.'</option>';
	}
	echo '</select>';
}
if ($perm_mod->perm_module('dashboard','search')) {
?>
<?php } ?>