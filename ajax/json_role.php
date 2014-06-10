<?php
include('../config/config.php');
$auth = new AUTH_USER();

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$f_id_config_project=filter_input(INPUT_GET, 'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
$f_id_config_environment=filter_input(INPUT_GET, 'f_id_config_environment',FILTER_SANITIZE_NUMBER_INT);

if ($auth->verif_auth()) {
	$project=new PROJECT($f_id_config_project);
	$envs = (array) $project->get_servers_roles($f_id_config_environment);
	echo json_encode($envs);
}
?>
