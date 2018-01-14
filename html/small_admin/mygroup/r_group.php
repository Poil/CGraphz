<?php
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

$lib='SELECT * FROM auth_group ag
WHERE ag.id_auth_group IN (
    SELECT id_auth_group FROM auth_user_group WHERE id_auth_user=:s_id_user AND manager=1
) ORDER BY ag.group';

$connSQL=new DB();
$connSQL->bind('s_id_user',$s_id_user);
$all_group=$connSQL->query($lib);
$cpt_group=count($all_group);
?>
