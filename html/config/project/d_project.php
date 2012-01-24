<table border="0" cellpadding="0" cellspacing="0" id="table_project" class="table_admin">
<thead>
<tr>
	<th>Projet</th>
	<th>Description</th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_project;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=project&amp;f_id_config_project='.$all_project[$i]->id_config_project.'">'.$all_project[$i]->project.'</a></td>
		<td><a href="index.php?module=config&amp;component=project&amp;f_id_config_project='.$all_project[$i]->id_config_project.'">'.$all_project[$i]->project_description.'</a></td>
	</tr>';
}
?>
</tbody>
</table>