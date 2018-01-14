<table border="0" cellpadding="0" cellspacing="0" id="table_project_server" class="table_admin">
<thead>
<tr>
    <th><?php echo SERVER ?></th>
    <th><?php echo DESC ?></th>
</tr>
</thead>
<tbody>
<?php

for ($i=0; $i<$cpt_project_server;$i++) {
    echo '
    <tr>
        <td><a href="index.php?module=config&amp;component=project&amp;f_id_config_project='.$_GET['f_id_config_project'].'&amp;f_id_config_server='.$all_project_server[$i]->id_config_server.'">'.$all_project_server[$i]->server_name.'</a></td>
        <td><a href="index.php?module=config&amp;component=project&amp;f_id_config_project='.$_GET['f_id_config_project'].'&amp;f_id_config_server='.$all_project_server[$i]->id_config_server.'">'.$all_project_server[$i]->server_description.'</a></td>
    </tr>';
}
?>
</tbody>
</table>
