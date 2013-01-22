<?php
if (isset($_GET['f_id_auth_group'])) {
	$f_id_auth_group=intval($_GET['f_id_auth_group']);
		
	$connSQL=new DB();
	$lib='SELECT 
			pmg.id_perm_module, 
			pmg.id_auth_group,  
			pm.`module`, 
			pm.component,
			pm.menu_name,
			ag.`group`,
			ag.group_description
		FROM
			perm_module_group pmg
				LEFT JOIN perm_module pm
					ON pmg.id_perm_module=pm.id_perm_module
				LEFT JOIN auth_group ag
					ON pmg.id_auth_group=ag.id_auth_group
		WHERE ag.id_auth_group="'.$f_id_auth_group.'"';

	$all_group_module=$connSQL->getResults($lib);
	$cpt_group_module=count($all_group_module);
	

	$lib='SELECT 
			* 
		FROM 
			perm_module
		WHERE 
			id_perm_module NOT IN (
				SELECT id_perm_module 
				FROM perm_module_group
				WHERE id_auth_group="'.$f_id_auth_group.'"
			)
		ORDER BY 
			`module`,
			`component`';
	
	$connSQL=new DB();
	$all_module=$connSQL->getResults($lib);
	$cpt_module=count($all_module);
}
?>
