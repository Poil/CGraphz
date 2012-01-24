<?php
class PERMS {
	function __construct() {
		$this->connSQL=new DB();
	}
	
	/*function verif_read_perms($mod) {
		$Perms=$this->connSQL->getResults('
			SELECT
				MAX(`read`) AS read,
				MAX(`write`) AS write
			FROM (
				SELECT 
					MAX(`read`) AS read,
					MAX(`write`) AS write 
				FROM mod_process_group 
				WHERE 
					`group` IN (
						SELECT `group` 
						FROM `auth_user_group` 
						WHERE `user`="'.$_SESSION['S_USER'].'"
					)
				AND `process`="'.$perms.'"				
				UNION				
				SELECT 
					`read`,
					`write` 
				FROM mod_process_user 
				WHERE `user`="'.$_SESSION['S_USER'].'"
				AND `process`="'.$perms.'"
			) T1'
		);
	}*/
	
	function perm_module($module, $component) {
		// Check si Admin
		$lib='
			SELECT count(*) AS mycpt
			FROM
			auth_group ag
				JOIN auth_user_group aug
					ON ag.id_auth_group=aug.id_auth_group AND ag.group="Administrateur"
				JOIN auth_user au
					ON aug.id_auth_user=au.id_auth_user	AND au.user="'.$_SESSION['S_USER'].'"';
		$res=$this->connSQL->getRow($lib);
		if ($res->mycpt > 0) {
			return true;
		} else { // Sinon			
			$lib='
				SELECT count(*) AS mycpt
				FROM
				perm_module pm
					JOIN perm_module_group pmg 
						ON pm.id_perm_module=pmg.id_perm_module AND pm.module="'.$module.'" AND pm.component="'.$component.'"
					JOIN auth_user_group aug
						ON pmg.id_auth_group=aug.id_auth_group
					JOIN auth_user au
						ON aug.id_auth_user=au.id_auth_user AND au.user="'.$_SESSION['S_USER'].'"';
						
			$res=$this->connSQL->getRow($lib);
			if ($res->mycpt > 0) {
				return true;
			} else {
				return false;
			}	
		}	
	}
	
	function perm_list_module($module, $show_no_menu=true) {
		if ($show_no_menu!==true) $libmenu=' AND (menu_name!="" OR menu_name IS NOT NULL) ';
		else $libmenu='';
		$lib='
			SELECT pm.component, pm.menu_name
			FROM perm_module pm
				LEFT JOIN perm_module_group pmg 
					ON pm.id_perm_module=pmg.id_perm_module
				LEFT JOIN auth_group ag 
					ON pmg.id_auth_group=ag.id_auth_group
				LEFT JOIN auth_user_group aug 
					ON ag.id_auth_group=aug.id_auth_group
				LEFT JOIN auth_user au 
					ON aug.id_auth_user=au.id_auth_user
			WHERE au.user="'.$_SESSION['S_USER'].'" AND pm.module="'.$module.'"
			'.$libmenu.'
			GROUP BY component
			ORDER BY menu_order';
		
		$components=$this->connSQL->getResults($lib);
		
		if (isset($components)) {
			return $components;
		} else {
			return false;
		}			
	}
	
	function auth_user_group($id_auth_user, $id_auth_group, $manager=false) {
		$id_auth_user=intval($id_auth_user);
		$id_auth_group=intval($id_auth_group);
		
		if ($id_auth_user!=$_SESSION['S_ID_USER']) {
			return false;
		} else {
			$lib='SELECT count(id_auth_group) as mycpt FROM auth_user_group WHERE id_auth_user="'.$id_auth_user.'" AND id_auth_group="'.$id_auth_group.'"';
			if ($manager===true) $lib.=' AND manager="1"';

			$res=$this->connSQL->getRow($lib);
			if ($res->mycpt > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
}
