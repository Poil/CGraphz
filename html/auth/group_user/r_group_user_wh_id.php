<?php
if (isset($_GET['f_id_auth_user']) && isset($_GET['f_id_auth_group'])) {
	$f_id_auth_user=intval($_GET['f_id_auth_user']);
	$f_id_auth_group=intval($_GET['f_id_auth_group']);
		
	$connSQL=new DB();
	$lib='SELECT 
			aug.id_auth_user, 
			aug.id_auth_group, 
			aug.manager,
			au.`user`, 
			ag.`group`,
			ag.group_description
		FROM
			auth_user_group aug
				LEFT JOIN auth_user au
					ON aug.id_auth_user=au.id_auth_user
				LEFT JOIN auth_group ag
					ON aug.id_auth_group=ag.id_auth_group
		WHERE aug.id_auth_user="'.$f_id_auth_user.'"
		AND aug.id_auth_group="'.$f_id_auth_group.'"';
	
	$cur_group_user=$connSQL->getRow($lib);
}
?>