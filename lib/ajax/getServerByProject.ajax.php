<?php
    include('../../config/config.php');

    if(isset($_GET['f_id_config_project'])){
		require DIR_FSROOT.'/html/dashboard/project_list/r_project_server_list.php';
		
			
        echo '<option value="" ></option>';

		
		if (isset($_GET['f_id_config_project'])) {
			if (isset($all_environment) && $cpt_environment>1) {
				
				foreach ($all_environment as $environment) {
					$selected="";
					if (isset($_GET['f_id_config_environment']) && intval($_GET['f_id_config_environment'])==$environment->id_config_environment) { 
						$selected="selected ";
					}
					if (isset($environment->id_config_environment)) $myenvironment=$environment->id_config_environment;
					else $myenvironment=0;
					
					if (isset($myrole)) {
						echo '<option '.$selected.'value="f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$myenvironment.'&amp;f_id_config_role='.$myrole.'">'.$environment->environment_description.'</a></span>';
					}
					else {
						echo '<option '.$selected.'value="f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$myenvironment.'">'.$environment->environment_description.'</a></span>';
					}		
				}	
			}
			if ($cpt_environment <= 1 || isset($_GET['f_id_config_environment'])) {
				if (isset($all_role) && $cpt_role>1) {
					
					foreach ($all_role as $role) {
						$selected="";
						if (isset($_GET['f_id_config_role']) && intval($_GET['f_id_config_role'])==$role->id_config_role) { 
							$selected="selected "; 
						}
						if (isset($role->id_config_role)) $myrole=$role->id_config_role;
						else $myrole=0;

						if (isset($_GET['f_id_config_environment'])) {
							$f_id_config_environment=intval($_GET['f_id_config_environment']);
							echo '<option '.$selected.'value="f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$f_id_config_environment.'&amp;f_id_config_role='.$myrole.'">'.$role->role_description.'</a></span>';
						}
						else {
							echo '<option '.$selected.'value="f_id_config_project='.$f_id_config_project.'&amp;f_id_config_role='.$myrole.'">'.$role->role_description.'</a></span>';
						}			
					}	
					
				}
				if (($cpt_server<MAX_SRV || $cpt_role<=1 || isset($_GET['f_id_config_role'])) && $cpt_server!==0) {
					
					foreach ($all_server as $server) {
						$selected="";
						if($_GET["f_id_config_server"]==$server->id_config_server){
							$selected="selected ";
						}
						if (($cpt_server>MAX_SRV && $cpt_role>1) || isset($_GET['f_id_config_role'])) $str_role='&amp;f_id_config_role='.$f_id_config_role;
						else $str_role='';
						if (isset($_GET['f_id_config_environment'])) $str_environment='&amp;f_id_config_environment='.$f_id_config_environment;
						else $str_environment='';

						// if (isset($_GET['f_id_config_role']) && $_GET['f_id_config_role']!="") $str_role='&amp;f_id_config_role='.$_GET['f_id_config_role'];

						echo '	<option '.$selected.'value="f_id_config_project='.$f_id_config_project.$str_role.$str_environment.'&amp;f_id_config_server='.$server->id_config_server.'">'.$server->server_name.'</option>';
					}
					
				}
			}
		}

    }
?>