<table border="0" cellpadding="0" cellspacing="0" id="table_module" class="table_admin">
<thead>
<tr>
	<th><?php echo MODULE ?></th>
	<th><?php echo COMPONENT ?></th>
	<th><?php echo MENU_NAME ?></th>
	<th><?php echo MENU_ORDER ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_module;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=perm&amp;component=module&amp;f_id_perm_module='.$all_module[$i]->id_perm_module.'">'.$all_module[$i]->module.'</a></td>
		<td><a href="index.php?module=perm&amp;component=module&amp;f_id_perm_module='.$all_module[$i]->id_perm_module.'">'.$all_module[$i]->component.'</a></td>
		<td><a href="index.php?module=perm&amp;component=module&amp;f_id_perm_module='.$all_module[$i]->id_perm_module.'">'.$all_module[$i]->menu_name.'</a></td>
		<td><a href="index.php?module=perm&amp;component=module&amp;f_id_perm_module='.$all_module[$i]->id_perm_module.'">'.$all_module[$i]->menu_order.'</a></td>
	</tr>';
}
?>
</tbody>
</table>
