<?php

# Collectd Battery plugin


require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# battery-X/
# battery-X/charge.rrd
# battery-X/current.rrd
# battery-X/voltage.rrd

$obj = new Type_Default($CONFIG);
$obj->colors = array(
	'value' => '0000f0',
);
switch($obj->args['type']) {
	case 'charge':
		$obj->ds_names = array('value' => 'Charge');
		$obj->rrd_title = sprintf('Charge (Battery %s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Ampere hours';
	break;
	case 'current':
		$obj->ds_names = array('value' => 'Current');
		$obj->rrd_title = sprintf('Current (Battery %s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Ampere';
	break;
	case 'voltage':
		$obj->ds_names = array('value' => 'Voltage');
		$obj->rrd_title = sprintf('Voltage (Battery %s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Volt';
	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}
$obj->rrd_format = '%4.1lf';

collectd_flush($obj->identifiers);
$obj->rrd_graph();

