<?php

# Collectd Sensors plugin


require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# sensors-XXXX/
# sensors-XXXX/fanspeed-XXXX.rrd
# sensors-XXXX/temerature-XXXX.rrd
# sensors-XXXX/voltage-XXXX.rrd

$obj = new Type_Default($CONFIG);
$obj->ds_names = array(
	'value' => 'Value',
);
switch($obj->args['type']) {
	case 'fanspeed':
		$obj->rrd_title = sprintf('Fanspeed (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'RPM';
		$obj->rrd_format = '%5.1lf';
	break;
	case 'temperature':
		$obj->rrd_title = sprintf('Temperature (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Celsius';
		$obj->rrd_format = '%5.1lf%s';
	break;
	case 'voltage':
		$obj->rrd_title = sprintf('Voltage (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Volt';
		$obj->rrd_format = '%5.1lf';
	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
