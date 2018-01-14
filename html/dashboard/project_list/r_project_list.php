<?php
$connSQL=new DB();
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

$lib='
SELECT cp.project_description, cp.id_config_project
FROM config_project cp
    LEFT JOIN perm_project_group ppg
        ON cp.id_config_project=ppg.id_config_project
    LEFT JOIN auth_group ag
        ON ppg.id_auth_group=ag.id_auth_group
    LEFT JOIN auth_user_group aug
        ON ag.id_auth_group=aug.id_auth_group
WHERE
    aug.id_auth_user=:s_id_user
GROUP BY id_config_project, project_description
ORDER BY project_description ';

$connSQL->bind('s_id_user',$s_id_user);
$all_project=$connSQL->query($lib);

?>
