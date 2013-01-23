<table border="0" cellpadding="0" cellspacing="0" id="table_user_group" class="table_admin">
<thead>
<tr>
	<th><?php echo GROUP ?></th>
	<th><?php echo MANAGER ?></th>
</tr>
</thead>
<tbody>
<?php 
for ($i=0; $i<$cpt_dynamic_dashboard_group; $i++) {
	if($all_dynamic_dashboard_group[$i]->group_manager==1) {
		$manager=YES;
	} else {
		$manager=NO;
	}
	echo '
	<tr>
		<td>
			<a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard_group[$i]->id_config_dynamic_dashboard.'&amp;f_id_auth_group='.$all_dynamic_dashboard_group[$i]->id_auth_group.'">'.$all_dynamic_dashboard_group[$i]->group.'</a></td>
		<td>'.$manager.'</td>
	</tr>';
}
?>
</tbody>
</table>
