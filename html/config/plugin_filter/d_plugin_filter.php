<table border="0" cellpadding="0" cellspacing="0" id="table_plugin_filter" class="table_admin">
<thead>
<tr>
	<th>Description</th>
	<th>Plugin</th>
	<th>Plugin instance</th>
	<th>Type</th>
	<th>Type instance</th>
	<th>Ordre d'affichage</th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_plugin_filter;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin_filter_desc.'</a></td>
		<td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin.'</a></td>
		<td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin_instance.'</a></td>
		<td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->type.'</a></td>
		<td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->type_instance.'</a></td>
		<td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin_order.'</a></td>
	</tr>';
}
?>
</tbody>
</table>