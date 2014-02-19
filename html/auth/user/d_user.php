<table border="0" cellpadding="0" cellspacing="0" id="table_user" class="table_admin">
<thead>
<tr>
	<th><?php echo USER ?></th>
	<th><?php echo NAME ?></th>
	<th><?php echo FIRSTNAME ?></th>
</tr>
</thead>
<tbody>
<?php 


for ($i=0; $i<$cpt_user;$i++) {
	echo '
	<tr>
		<td><a href="index.php?module=auth&amp;component=user&amp;f_id_auth_user='.$all_user[$i]->id_auth_user.'">'.$all_user[$i]->user.'</a></td>
		<td>'.$all_user[$i]->nom.'</td>
		<td>'.$all_user[$i]->prenom.'</td>
	</tr>';
}
?>
</tbody>
</table>
