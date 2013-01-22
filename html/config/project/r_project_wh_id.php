<?php
if (isset($_GET['f_id_config_project'])) {
	$f_id_config_project=intval($_GET['f_id_config_project']);
	
	$connSQL=new DB();
	$lib='SELECT * FROM config_project WHERE id_config_project="'.$f_id_config_project.'"';
	$cur_project=$connSQL->getRow($lib);
}
?>
