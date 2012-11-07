<?php
if (isset($_POST['f_submit_dynamic_dashboard_content'])) {
	$f_id_config_dynamic_dashboard=intval($_POST['f_id_config_dynamic_dashboard']);
	$f_id_config_dynamic_dashboard_content=intval($_POST['f_id_config_dynamic_dashboard_content']);
	$f_dash_ordering=intval($_POST['f_dash_ordering']);
	$f_title=mysql_escape_string(filter_input(INPUT_POST,'f_title',FILTER_SANITIZE_SPECIAL_CHARS));
	
	$f_regex_srv=mysql_escape_string(filter_input(INPUT_POST,'f_regex_srv',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_regex_p_filter=mysql_escape_string(filter_input(INPUT_POST,'f_regex_p_filter',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_regex_pi_filter=mysql_escape_string(filter_input(INPUT_POST,'f_regex_pi_filter',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_regex_t_filter=mysql_escape_string(filter_input(INPUT_POST,'f_regex_t_filter',FILTER_SANITIZE_SPECIAL_CHARS));
	$f_regex_ti_filter=mysql_escape_string(filter_input(INPUT_POST,'f_regex_ti_filter',FILTER_SANITIZE_SPECIAL_CHARS));
	
	$f_rrd_ordering=mysql_escape_string(filter_input(INPUT_POST,'f_rrd_ordering',FILTER_SANITIZE_SPECIAL_CHARS));
	
//	if ( (filter_var($f_regex_srv, FILTER_VALIDATE_REGEXP) !== false) && (filter_var($f_regex_filter, FILTER_VALIDATE_REGEXP) !== false) ) {
		if ($f_id_config_dynamic_dashboard_content !== 0) {
			$lib='
				UPDATE config_dynamic_dashboard_content SET
					title="'.$f_title.'",
					regex_srv="'.$f_regex_srv.'",
					regex_p_filter="'.$f_regex_p_filter.'",
					regex_pi_filter="'.$f_regex_pi_filter.'",
					regex_t_filter="'.$f_regex_t_filter.'",
					regex_ti_filter="'.$f_regex_ti_filter.'",
					rrd_ordering="'.$f_rrd_ordering.'",
					dash_ordering="'.$f_dash_ordering.'"
				WHERE
					id_config_dynamic_dashboard_content="'.$f_id_config_dynamic_dashboard_content.'"';
		} else { // INSERT
			$lib='INSERT INTO config_dynamic_dashboard_content 
				(id_config_dynamic_dashboard,title,regex_srv,regex_p_filter,regex_pi_filter,regex_t_filter,regex_ti_filter,rrd_ordering,dash_ordering) 
			VALUES 
				("'.$f_id_config_dynamic_dashboard.'","'.$f_title.'",
				"'.$f_regex_srv.'","'.$f_regex_p_filter.'","'.$f_regex_pi_filter.'",
				"'.$f_regex_t_filter.'","'.$f_regex_ti_filter.'",
				"'.$f_rrd_ordering.'","'.$f_dash_ordering.'")';
		}
//	}
	$connSQL=new DB();
	$connSQL->query($lib);
}
?>
