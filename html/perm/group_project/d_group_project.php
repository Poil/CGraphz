<table border="0" cellpadding="0" cellspacing="0" id="table_group_project" class="table_admin">
<thead>
<tr>
	<th>Projets</th>
	<th>Description</th>
</tr>
</thead>
<tbody>
<?php 

for ($i=0; $i<$cpt_group_project;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=auth&amp;component=group&amp;f_id_auth_group='.$_GET['f_id_auth_group'].'&amp;f_id_config_project='.$all_group_project[$i]->id_config_project.'">'.$all_group_project[$i]->project.'</a></td>
		<td>'.$all_group_project[$i]->project_description.'</td>
	</tr>';
}
?>
</tbody>
</table>