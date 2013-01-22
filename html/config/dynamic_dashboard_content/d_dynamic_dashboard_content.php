<table border="0" cellpadding="0" cellspacing="0" id="table_dynamic_dashboard_content" class="table_admin">
<thead>
<tr>
	<th>Titre</th>
	<th>Ordre TdB</th>
	<th>Rgx Serveur</th>
	<th>Rgx Plugin</th>
	<th>Rgx Plugin Instance</th>
	<th>Rgx Type</th>
	<th>Rgx Type Instance</th>
	<th>Ordre Graphs</th>
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