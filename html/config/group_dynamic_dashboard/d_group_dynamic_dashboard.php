<table border="0" cellpadding="0" cellspacing="0" id="table_group_plugin_filter" class="table_admin">
<thead>
<tr>
	<th><?php echo DASHBOARD ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_plugin_filter_group;$i++) {

	echo '
	<tr>
		<td>
			<a href="index.php?module=auth&amp;component=group&amp;f_id_auth_group='.$_GET['f_id_auth_group'].'&amp;f_id_config_dynamic_dashboard='.$all_plugin_dynamic_dashboard_group[$i]->id_config_dynamic_dashboard.'">
			'.$all_plugin_dynamic_dashboard_group[$i]->dynamic_dashboard_desc
			.'</a>
		</td>
	</tr>';
}
?>
</tbody>
</table>
