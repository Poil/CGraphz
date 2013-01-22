<?php
if (isset($_GET['f_id_perm_module']) && isset($_GET['f_id_auth_group'])) {
	$f_id_perm_module=intval($_GET['f_id_perm_module']);
	$f_id_auth_group=intval($_GET['f_id_auth_group']);
		
	$connSQL=new DB();
	/* A FAIRE A PARTIR D'ICI DEMAIN GROS BOULET */
	$lib='SELECT 
			pmg.id_perm_module, 
			pmg.id_auth_group, 
			pm.`module`, 
			ag.`group`,
			ag.group_description
		FROM
			perm_module_group pmg
				LEFT JOIN perm_module pm
					ON pmg.id_perm_module=pm.id_perm_module
				LEFT JOIN auth_group ag
					ON pmg.id_auth_group=ag.id_auth_group
		WHERE pmg.id_perm_module="'.$f_id_perm_module.'"
		AND pmg.id_auth_group="'.$f_id_auth_group.'"';
	
	$cur_module_group=$connSQL->getRow($lib);
}
?>
