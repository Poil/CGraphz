<?php
if (isset($_POST['f_submit_dynamic_dashboard_content']) && $cur_dynamic_dashboard) {
	$f_id_config_dynamic_dashboard=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard',FILTER_SANITIZE_NUMBER_INT);
	$f_id_config_dynamic_dashboard_content=filter_input(INPUT_POST,'f_id_config_dynamic_dashboard_content',FILTER_SANITIZE_NUMBER_INT);
	$f_dash_ordering=filter_input(INPUT_POST,'f_dash_ordering',FILTER_SANITIZE_NUMBER_INT);
	$f_title=filter_input(INPUT_POST,'f_title',FILTER_SANITIZE_SPECIAL_CHARS);
	
	$f_regex_srv=filter_input(INPUT_POST,'f_regex_srv',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_p_filter=filter_input(INPUT_POST,'f_regex_p_filter',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_pi_filter=filter_input(INPUT_POST,'f_regex_pi_filter',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_t_filter=filter_input(INPUT_POST,'f_regex_t_filter',FILTER_SANITIZE_SPECIAL_CHARS);
	$f_regex_ti_filter=filter_input(INPUT_POST,'f_regex_ti_filter',FILTER_SANITIZE_SPECIAL_CHARS);
	
	$f_rrd_ordering=filter_input(INPUT_POST,'f_rrd_ordering',FILTER_SANITIZE_SPECIAL_CHARS);
	
	if ($f_id_config_dynamic_dashboard_content !== 0) {
		$connSQL->bind('f_id_config_dynamic_dashboard_content',$f_id_config_dynamic_dashboard_content);
		$lib='
			UPDATE config_dynamic_dashboard_content SET
				title=:f_title,
				regex_srv=:f_regex_srv,
				regex_p_filter=:f_regex_p_filter,
				regex_pi_filter=:f_regex_pi_filter,
				regex_t_filter=:f_regex_t_filter,
				regex_ti_filter=:f_regex_ti_filter,
				rrd_ordering=:f_rrd_ordering,
				dash_ordering=:f_dash_ordering
			WHERE
				id_config_dynamic_dashboard_content=:f_id_config_dynamic_dashboard_content';
	} else { // INSERT
		$connSQL->bind('f_id_config_dynamic_dashboard',$f_id_config_dynamic_dashboard);
		$lib='INSERT INTO config_dynamic_dashboard_content 
			(id_config_dynamic_dashboard, title, regex_srv, regex_p_filter, regex_pi_filter, regex_t_filter, regex_ti_filter, rrd_ordering, dash_ordering) 
		VALUES 
			(:f_id_config_dynamic_dashboard,:f_title,
			:f_regex_srv, :f_regex_p_filter, :f_regex_pi_filter,
			:f_regex_t_filter, :f_regex_ti_filter,
			:f_rrd_ordering, :f_dash_ordering)';
	}
	$connSQL=new DB();
	$connSQL->bind('f_title',$f_title);
	$connSQL->bind('f_regex_srv',$f_regex_srv);
	$connSQL->bind('f_regex_p_filter',$f_regex_p_filter);
	$connSQL->bind('f_regex_pi_filter',$f_regex_pi_filter);
	$connSQL->bind('f_regex_t_filter',$f_regex_t_filter);
	$connSQL->bind('f_regex_ti_filter',$f_regex_ti_filter);
	$connSQL->bind('f_rrd_ordering',$f_rrd_ordering);
	$connSQL->bind('f_dash_ordering',$f_dash_ordering);
	$connSQL->query($lib);
}
?>
