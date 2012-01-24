<table border="0" cellpadding="0" cellspacing="0" id="table_user_group" class="table_admin">
<thead>
<tr>
	<th>Groupes Utilisateur</th>
	<th>Manager </th>
</tr>
</thead>
<tbody>
<?php 
for ($i=0; $i<$cpt_user_group; $i++) {
	if($all_user_group[$i]->manager==1) {
		$manager='oui';
	} else {
		$manager='non';
	}
	echo '
	<tr>
		<td>
			<a href="index.php?module=auth&amp;component=user&amp;f_id_auth_user='.$_GET['f_id_auth_user'].'&amp;f_id_auth_group='.$all_user_group[$i]->id_auth_group.'">'.$all_user_group[$i]->group.'</a></td>
		<td>'.$manager.'</td>
	</tr>';
}
?>
</tbody>
</table>