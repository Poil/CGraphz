<?php
if (isset($_POST['f_submit_group'])) {


    $f_id_auth_group=filter_input(INPUT_POST,'f_id_auth_group',FILTER_SANITIZE_NUMBER_INT);
    $f_group_description=filter_input(INPUT_POST,'f_group_description',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_group=filter_input(INPUT_POST,'f_group',FILTER_SANITIZE_SPECIAL_CHARS);
    $s_id_user=filter_var($_SESSION['S_ID_USER'], FILTER_SANITIZE_NUMBER_INT);

    $perm_grp = new PERMS();
    if (($f_id_auth_group && $perm_grp->auth_user_group($s_id_user,$f_id_auth_group,true)) || !$f_id_auth_group) {
        $connSQL=new DB();

        if ($_POST['f_id_auth_group']) { // UPDATE
            $lib='
                UPDATE auth_group ag SET
                    ag.group=:f_group,
                    ag.group_description=:f_group_description
                WHERE
                    ag.id_auth_group=:f_id_auth_group';


            $connSQL->bind('f_id_auth_group',$f_id_auth_group);
            $connSQL->bind('f_group_description',$f_group_description);
            $connSQL->query($lib);

        } else { // INSERT
            $lib='INSERT INTO auth_group ag (
                    ag.group,
                    group_description
                )
                VALUES (
                    :f_group,
                    :f_group_description
                )';
            $connSQL->bind('f_group',$f_group);
            $connSQL->bind('f_group_description',$f_group_description);
            $connSQL->query($lib);

            $id_auth_group=$connSQL->getLastInsertId();

            $lib='INSERT INTO auth_user_group (
                    id_auth_user,
                    id_auth_group,
                    manager
                 ) VALUES (
                    :s_id_user,
                    :id_auth_group,
                    "1"
                )';
            $connSQL->bind('s_id_user',$s_id_user);
            $connSQL->bind('id_auth_group',$id_auth_group);
            $connSQL->query($lib);
        }
    } else {
        echo 'Arrrrrrrrrrh am I hacked ?!!';
    }
}
?>
