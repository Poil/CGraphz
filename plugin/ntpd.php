<?php

# Collectd NTPD plugin


require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# ntpd/
# ntpd/delay-<host>.rrd
# ntpd/frequency_offset-loop.rrd
# ntpd/time_dispersion-<host>.rrd
# ntpd/time_offset-<host>.rrd

$obj = new Type_Default($CONFIG);
$obj->ds_names = array('ping' => 'Ping time',
                       'ping_stddev' => 'Ping stddev',
                       'ping_droprate' => 'Ping droprate');
$obj->rrd_format = '%5.1lf%s';

switch($obj->args['type']) {
	case 'delay':
		if (preg_replace('/[^0-9\.]/','',$CONFIG['version']) < 5) {
			$obj->data_sources = array('seconds');
		$obj->rrd_title = sprintf('Delay');
		$obj->rrd_vertical = 'Seconds';
		break;
	case 'frequency_offset':
		if (preg_replace('/[^0-9\.]/','',$CONFIG['version']) < 5) {
			$obj->data_sources = array('ppm');
		$obj->rrd_title = 'Frequency offset';
		$obj->rrd_vertical = 'ppm';
		break;
	case 'time_dispersion':
		if (preg_replace('/[^0-9\.]/','',$CONFIG['version']) < 5) {
			$obj->data_sources = array('seconds');
		$obj->rrd_title = 'Time dispersion';
		$obj->rrd_vertical = 'Seconds';
		break;
	case 'time_offset':
		if (preg_replace('/[^0-9\.]/','',$CONFIG['version']) < 5) {
			$obj->data_sources = array('seconds');
		$obj->rrd_title = 'Time offset';
		$obj->rrd_vertical = 'Seconds';
		break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
