<table border="0" cellpadding="0" cellspacing="0" id="table_server_role" class="table_admin">
<thead>
<tr>
	<th>Rôles</th>
	<th>Description</th>
</tr>
</thead>
<tbody>
<?php 

for ($i=0; $i<$cpt_server_role;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=server&amp;f_id_config_server='.$cur_server->id_config_server.'&amp;f_id_config_role='.$all_server_role[$i]->id_config_role.'">'.$all_server_role[$i]->role.'</a></td>
		<td><a href="index.php?module=config&amp;component=role&amp;f_id_config_server='.$cur_server->id_config_server.'&amp;f_id_config_role='.$all_server_role[$i]->id_config_role.'">'.$all_server_role[$i]->role_description.'</a></td>
	</tr>';
}
?>
</tbody>
</table>