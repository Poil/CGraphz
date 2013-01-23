<table border="0" cellpadding="0" cellspacing="0" id="table_dynamic_dashboard_content" class="table_admin">
<thead>
<tr>
	<th><?php echo TITLE ?></th>
	<th><?php echo DISPLAYED_ORDER ?></th>
	<th><?php echo REGEX_SRV ?></th>
	<th><?php echo REGEX_PLUGIN ?></th>
	<th><?php echo REGEX_PLUGIN_INSTANCE ?></th>
	<th><?php echo REGEX_TYPE ?></th>
	<th><?php echo REGEX_TYPE_INSTANCE ?></th>
	<th><?php echo GRAPH_ORDER ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_dynamic_dashboard_content;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->title.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->dash_ordering.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->regex_srv.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->regex_p_filter.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->regex_pi_filter.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->regex_t_filter.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->regex_ti_filter.'</a></td>
		<td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard.'&amp;f_id_config_dynamic_dashboard_content='.$all_dynamic_dashboard_content[$i]->id_config_dynamic_dashboard_content.'">'.$all_dynamic_dashboard_content[$i]->rrd_ordering.'</a></td>
	</tr>';
}
?>
</tbody>
</table>
