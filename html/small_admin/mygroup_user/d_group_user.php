<table border="0" cellpadding="0" cellspacing="0" id="table_group_user" class="table_admin">
<thead>
<tr>
	<th><?php echo GROUP ?></th>
	<th><?php echo MANAGER ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_group_user;$i++) {
	if($all_group_user[$i]->manager==1) {
		$manager='oui';
	} else {
		$manager='non';
	}
	
	echo '
	<tr>
		<td><a href="index.php?module=small_admin&amp;component=mygroup&amp;f_id_auth_group='.$_GET['f_id_auth_group'].'&amp;f_id_auth_user='.$all_group_user[$i]->id_auth_user.'">'.$all_group_user[$i]->user.'</a></td>
		<td>'.$manager.'</td>
	</tr>';
}
?>
</tbody>
</table>
