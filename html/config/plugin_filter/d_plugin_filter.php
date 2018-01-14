<table border="0" cellpadding="0" cellspacing="0" id="table_plugin_filter" class="table_admin">
<thead>
<tr>
    <th><?php echo DESC ?></th>
    <th><?php echo PLUGIN ?></th>
    <th><?php echo PLUGIN_INSTANCE ?></th>
    <th><?php echo TYPE ?></th>
    <th><?php echo TYPE_INSTANCE ?></th>
    <th><?php echo DISPLAYED_ORDER ?></th>
</tr>
</thead>
<tbody>
<?php


for ($i=0; $i<$cpt_plugin_filter;$i++) {
    echo '
    <tr>
        <td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin_filter_desc.'</a></td>
        <td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin.'</a></td>
        <td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin_instance.'</a></td>
        <td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->type.'</a></td>
        <td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->type_instance.'</a></td>
        <td><a href="index.php?module=config&amp;component=plugin&amp;f_id_config_plugin_filter='.$all_plugin_filter[$i]->id_config_plugin_filter.'">'.$all_plugin_filter[$i]->plugin_order.'</a></td>
    </tr>';
}
?>
</tbody>
</table>
