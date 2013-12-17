<table border="0" cellpadding="0" cellspacing="0" id="table_group_dynamic_dashboard" class="table_admin">
<thead>
<tr>
	<th><?php echo DYNAMIC_DASHBOARDS ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_dynamic_dashboard;$i++) {

	echo '
	<tr>
		<td>
			<a href="index.php?module=auth&amp;component=group&amp;f_id_auth_group='.$_GET['f_id_auth_group'].'&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_group[$i]->id_config_dynamic_dashboard.'">
			'.$all_dynamic_dashboard_group[$i]->title
			.'</a>
		</td>
	</tr>';
}
?>
</tbody>
</table>
