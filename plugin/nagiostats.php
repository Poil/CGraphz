<?php

# Collectd nagiostats plugin
require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

switch(GET('t')) {
	case 'percent':
		$obj = new Type_Default($CONFIG);
		$obj->data_sources = array('percent');
		$obj->ds_names = array(
			'percent ' => 'Percentage',
		);
		$obj->rrd_vertical = '%';
	break;
	case 'latency':
		$obj = new Type_Default($CONFIG);
		$obj->rrd_vertical = 'Second';
	break;
	case 'response_time':
		$obj = new Type_Default($CONFIG);
		$obj->rrd_vertical = 'Second';
	break;
	default:
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_vertical = 'Number';
	break;
}
$obj->rrd_title = $obj->args['type'].' : '.$obj->args['tcategory'];
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();

