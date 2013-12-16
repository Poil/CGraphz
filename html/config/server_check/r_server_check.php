<?php
$all_server=$connSQL->query('SELECT * FROM config_server ORDER BY server_name');
$cpt_server=count($all_server);

$lib='
	SELECT * 
	FROM config_server 
	WHERE server_name NOT IN (
		SELECT server_name FROM server_list
	) ORDER BY server_name';

$all_deleted_server=$connSQL->query($lib);
$cpt_deleted_server=count($all_deleted_server);
?>
