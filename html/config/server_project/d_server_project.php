<table border="0" cellpadding="0" cellspacing="0" id="table_server_project" class="table_admin">
<thead>
<tr>
	<th><?php echo PROJECT ?></th>
	<th><?php echo DESC ?></th>
</tr>
</thead>
<tbody>
<?php 

for ($i=0; $i<$cpt_server_project;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=server&amp;f_id_config_server='.$cur_server->id_config_server.'&amp;f_id_config_project='.$all_server_project[$i]->id_config_project.'">'.$all_server_project[$i]->project.'</a></td>
		<td><a href="index.php?module=config&amp;component=project&amp;f_id_config_server='.$cur_server->id_config_server.'&amp;f_id_config_project='.$all_server_project[$i]->id_config_project.'">'.$all_server_project[$i]->project_description.'</a></td>
	</tr>';
}
?>
</tbody>
</table>
