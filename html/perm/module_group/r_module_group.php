<?php
if (isset($_GET['f_id_perm_module'])) {
	$f_id_perm_module=intval($_GET['f_id_perm_module']);
		
	$connSQL=new DB();
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
		WHERE pmg.id_perm_module="'.$f_id_perm_module.'"';

	$all_module_group=$connSQL->getResults($lib);
	$cpt_module_group=count($all_module_group);
	
	
	$lib='SELECT 
			* 
		FROM 
			auth_group
		WHERE 
			id_auth_group NOT IN (
				SELECT id_auth_group 
				FROM perm_module_group
				WHERE id_perm_module="'.$f_id_perm_module.'"
			)
		ORDER BY 
			`group`';
	
	$connSQL=new DB();
	$all_group=$connSQL->getResults($lib);
	$cpt_group=count($all_group);
}
?>
