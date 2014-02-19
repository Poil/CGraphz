<table border="0" cellpadding="0" cellspacing="0" id="group" class="table_admin">
<thead>
<tr>
	<th><?php echo GROUP ?></th>
	<th><?php echo DESC ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_group;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=auth&amp;component=group&amp;f_id_auth_group='.$all_group[$i]->id_auth_group.'">'.$all_group[$i]->group.'</a></td>
		<td>'.$all_group[$i]->group_description.'</td>
	</tr>';
}
?>
</tbody>
</table>
