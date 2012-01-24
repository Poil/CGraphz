<table border="0" cellpadding="0" cellspacing="0" id="table_server" class="table_admin">
<thead>
<tr>
	<th>Server</th>
	<th>Description</th>
</tr>
</thead>
<tbody>
<?php 

for ($i=0; $i<$cpt_server;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=server&amp;f_id_config_server='.$all_server[$i]->id_config_server.'">'.$all_server[$i]->server_name.'</a></td>
		<td>'.$all_server[$i]->server_description.'</td>
	</tr>';
}
?>
</tbody>
</table>