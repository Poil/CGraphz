<?php
if (isset($_POST['f_submit_module'])) {

    $f_id_perm_module=filter_input(INPUT_POST,'f_id_perm_module',FILTER_SANITIZE_NUMBER_INT);
    $f_module=filter_input(INPUT_POST,'f_module',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_component=filter_input(INPUT_POST,'f_component',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_menu_name=filter_input(INPUT_POST,'f_menu_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_menu_order=filter_input(INPUT_POST,'f_menu_order',FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    if ($_POST['f_id_perm_module']) { // UPDATE
        $connSQL->bind('f_id_perm_module',$f_id_perm_module);
        $lib='
            UPDATE perm_module SET
                module=:f_module,
                component=:f_component,
                menu_name=:f_menu_name,
                menu_order=:f_menu_order
            WHERE
                id_perm_module=:f_id_perm_module';

        $connSQL->bind('f_id_perm_module',$f_id_perm_module);

    } else { // INSERT
        $lib='INSERT INTO perm_module (module, component, menu_name, menu_order)
        VALUES (:f_module, :f_component, :f_menu_name, :f_menu_order)';
    }

    $connSQL->bind('f_module',$f_module);
    $connSQL->bind('f_component',$f_component);
    $connSQL->bind('f_menu_name',$f_menu_name);
    $connSQL->bind('f_menu_order',$f_menu_order);
    $connSQL->query($lib);
}
?>
