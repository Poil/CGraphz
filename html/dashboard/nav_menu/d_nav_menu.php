<?php
echo '<div id="nav_menu">';
echo '<ul>';
for ($i=0; $i<$cpt_nav; $i++) {
	if ($i>0) {
		if ($all_nav[$i]->id_config_project!=$all_nav[$i-1]->id_config_project) {
			echo '</ul></li></ul></li>';
		} else if ($all_nav[$i]->id_config_role!=$all_nav[$i-1]->id_config_role) {
			echo '</ul></li>';
		}
	}

	if ($i==0 || $i>0 && $all_nav[$i]->id_config_project!=$all_nav[$i-1]->id_config_project) {
		echo '<li class="has-sub"><a href="#"><span>'.$all_nav[$i]->project_description.'</span></a><ul class="sub-level">';
	}
	
	if ($i==0 || $i>0 && $all_nav[$i]->id_config_role!=$all_nav[$i-1]->id_config_role || $all_nav[$i]->id_config_project!=$all_nav[$i-1]->id_config_project) {
		echo '<li class="has-sub"><a href="#"><span>'.$all_nav[$i]->role_description.'</span></a><ul>';
	}
	
	echo '<li class="last">
		<a href="'.DIR_WEBROOT.'/index.php?module=dashboard&component=view&amp;f_id_config_project='. $all_nav[$i]->id_config_project.'&amp;f_id_config_role='.$all_nav[$i-1]->id_config_role.'&amp;f_id_config_server='.$all_nav[$i]->id_config_server.'"><span>'.$all_nav[$i]->server_name.'</span></a></li>';
}
echo '</ul></li></ul></li></ul></div>';
