<table border="0" cellpadding="0" cellspacing="0" id="table_dynamic_dashboard" class="table_admin">
<thead>
<tr>
    <th><?php echo TITLE ?></th>
</tr>
</thead>
<tbody>
<?php


for ($i=0; $i<$cpt_dynamic_dashboard;$i++) {
    echo '
    <tr>
        <td><a href="index.php?module=config&amp;component=dynamic_dashboard&amp;f_id_config_dynamic_dashboard='.$all_dynamic_dashboard[$i]->id_config_dynamic_dashboard.'">'.$all_dynamic_dashboard[$i]->title.'</a></td>
    </tr>';
}
?>
</tbody>
</table>
