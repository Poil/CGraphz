<?php
if (isset($_POST['f_submit_project_server'])) {
	
	$f_id_config_project=filter_input(INPUT_POST,'f_id_config_project',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_server=filter_input(INPUT_POST,'f_id_config_server',FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY);
	$f_filter_server_in_project=$_POST['f_filter_server_in_project'];
	
	foreach ($f_id_config_server as $id_config_server) {
		$lib='INSERT INTO config_server_project 
				(id_config_project, id_config_server) 
			VALUES 
				(:f_id_config_project, :id_config_server)';
		
		$connSQL=new DB();
		$connSQL->bind('f_id_config_project',$f_id_config_project);
		$connSQL->bind('id_config_server',$id_config_server);
		$connSQL->query($lib);
	}
} else {
        $f_filter_server_in_project='true';
}
?>
