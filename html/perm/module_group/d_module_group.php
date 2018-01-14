<table border="0" cellpadding="0" cellspacing="0" id="table_module_group" class="table_admin">
<thead>
<tr>
    <th><?php echo GROUP ?></th>
</tr>
</thead>
<tbody>
<?php

for ($i=0; $i<$cpt_module_group;$i++) {
    echo '
    <tr>
        <td><a href="index.php?module=perm&amp;component=module&amp;f_id_perm_module='.$_GET['f_id_perm_module'].'&amp;f_id_auth_group='.$all_module_group[$i]->id_auth_group.'">'.$all_module_group[$i]->group.'</a></td>
    </tr>';
}
?>
</tbody>
</table>
