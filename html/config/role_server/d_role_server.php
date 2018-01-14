<table border="0" cellpadding="0" cellspacing="0" id="table_role_server" class="table_admin">
<thead>
<tr>
    <th><?php echo ROLE ?></th>
    <th><?php echo DESC ?></th>
</tr>
</thead>
<tbody>
<?php


for ($i=0; $i<$cpt_role_server;$i++) {

    echo '
    <tr>
        <td><a href="index.php?module=config&amp;component=role&amp;f_id_config_role='.$_GET['f_id_config_role'].'&amp;f_id_config_server='.$all_role_server[$i]->id_config_server.'">'.$all_role_server[$i]->server_name.'</a></td>
        <td>'.$all_role_server[$i]->server_description.'</td>
    </tr>';
}
?>
</tbody>
</table>
