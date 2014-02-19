<table border="0" cellpadding="0" cellspacing="0" id="table_project_group" class="table_admin">
<thead>
<tr>
	<th><?php echo GROUP ?></th>
	<th><?php echo DESC ?></th>
</tr>
</thead>
<tbody>
<?php 

for ($i=0; $i<$cpt_project_group;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=project&amp;f_id_config_project='.$_GET['f_id_config_project'].'&amp;f_id_auth_group='.$all_project_group[$i]->id_auth_group.'">'.$all_project_group[$i]->group.'</a></td>
		<td>'.$all_project_group[$i]->group_description.'</td>
	</tr>';
}
?>
</tbody>
</table>
