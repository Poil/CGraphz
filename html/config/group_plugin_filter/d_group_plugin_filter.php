<table border="0" cellpadding="0" cellspacing="0" id="table_group_plugin_filter" class="table_admin">
<thead>
<tr>
	<th>Filtre</th>
	<th>Ordre d'affichage</th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_plugin_filter_group;$i++) {

	echo '
	<tr>
		<td><a href="index.php?module=auth&amp;component=group&amp;f_id_auth_group='.$_GET['f_id_auth_group'].'&amp;f_id_config_plugin_filter='.$all_plugin_filter_group[$i]->id_config_plugin_filter.'">'.$all_plugin_filter_group[$i]->plugin_filter_desc.'</a></td>
		<td>'.$all_plugin_filter_group[$i]->plugin_order.'</td>
	</tr>';
}
?>
</tbody>
</table>