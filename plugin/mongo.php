<?php

# Collectd APC UPS plugin
require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# apcups/
# apcups/charge.rrd
# apcups/frequency-input.rrd
# apcups/percent-load.rrd
# apcups/temperature.rrd
# apcups/timeleft.rrd
# apcups/voltage-battery.rrd
# apcups/voltage-input.rrd
# apcups/voltage-output.rrd

$obj = new Type_Default($CONFIG);

switch($obj->args['type']) {
	case 'cache_ratio' :
		//$obj -> data_sources = array('value');
		$obj -> rrd_title = sprintf('Cache Ratio%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = 'Hits';
		break;
	case 'connections' :
		//$obj -> data_sources = array('value');
		$obj -> rrd_title = sprintf('Connections%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = 'Numbers';
		break;
	case 'memory' :
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj -> width = $width;
		$obj -> heigth = $heigth;

		//$obj -> data_sources = array('value');
		$obj -> rrd_title = sprintf('Memory%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = 'MB';
		break;
	case 'counter' :
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		//$obj -> data_sources = array('value');
		$obj -> rrd_title = sprintf('Counter%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = 'Number';
		break;
	case 'percent' :
		//$obj -> data_sources = array('value');
		$obj -> rrd_title = sprintf('Lock Ratio Time%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = '%';
		break;
	case 'file_size' :
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		//$obj -> data_sources = array('bytes');
		$obj -> rrd_title = sprintf('File Size%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = 'Bytes';
		break;
	case 'total_operations' :
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);		
		$obj -> rrd_title = sprintf('Total Operation%s', !empty($obj -> args['pinstance']) ? ' (' . $obj -> args['pinstance'] . ')' : '');
		$obj -> rrd_vertical = 'Operation';
}
$obj -> width = $width;
$obj -> heigth = $heigth;
$obj -> rrd_format = '%5.1lf%s';
$obj -> generate_colors();

collectd_flush($obj -> identifiers);
$obj -> rrd_graph();
?>