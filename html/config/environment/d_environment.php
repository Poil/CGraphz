<table border="0" cellpadding="0" cellspacing="0" id="table_environment" class="table_admin">
<thead>
<tr>
    <th><?php echo ENV ?></th>
    <th><?php echo DESC ?></th>
</tr>
</thead>
<tbody>
<?php


for ($i=0; $i<$cpt_environment;$i++) {
    echo '
    <tr>
        <td><a href="index.php?module=config&amp;component=environment&amp;f_id_config_environment='.$all_environment[$i]->id_config_environment.'">'.$all_environment[$i]->environment.'</a></td>
        <td>'.$all_environment[$i]->environment_description.'</td>
    </tr>';
}
?>
</tbody>
</table>
