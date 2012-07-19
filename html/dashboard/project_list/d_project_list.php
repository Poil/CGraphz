<?php
foreach ($all_project as $project) {
	if (intval(GET('f_id_config_project'))==$project->id_config_project) {
		$style=' style="font-weight: bold;" '; 
	} else { 
		$style=''; 
	}
	
	echo '<span><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$project->id_config_project.'">'.$project->project_description.'</a></span>';
}
?>
<div id="f_form_find_server">
<label for="f_find_server">Recherche :&nbsp;<input type="text" id="f_find_server" name="f_find_server" /></label>
</div>
<div class="spacer">&nbsp;</div>
<script type="text/javascript">
	jQuery('#f_form_find_server input[name="f_find_server"]').liveSearch({url: '<?php echo DIR_WEBROOT ?>/html/dashboard/project_list/ajax_server_wh_q.php' + '?f_q='});
</script>