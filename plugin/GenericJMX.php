<?php

# Collectd GenericJMX plugin

require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

$obj = new Type_Default($CONFIG);

if (strlen($obj->args['tcategory'])) {
	$default_title = ucfirst(str_replace('_', ' ', $obj->args['tcategory'])).' '.str_replace('_', ' ', $obj->args['type']);
} else {
	$default_title = ucfirst(str_replace('_', ' ', $obj->args['type']));
}

switch($obj->args['pcategory']) {
	case ((preg_match('/catalina_request_processor/', $obj->args['pinstance']) ? true : false) || preg_match('/catalina_request_processor/', $obj->args['pcategory']) ? true : false) :
		switch ($obj->args['type']) {
			case 'io_octets' :
				$obj = new Type_GenericStacked($CONFIG);
				$obj->data_sources = array('rx', 'tx');
				$obj->ds_names = array('rx' => 'Receive', 'tx' => 'Transmit', );
				$obj->colors = array('rx' => '0000ff', 'tx' => '00b000', );
				$obj->rrd_title = sprintf('Traffic (%s)', str_replace('_', ' ', (empty($obj->args['pinstance'])?$obj->args['pcategory']:$obj->args['pinstance'])));
				$obj->rrd_vertical = 'Bytes/s';
			break;
			default:
				$obj->rrd_title = $default_title;
				$obj->rrd_vertical = sprintf('%s', str_replace('_', ' ', $obj->args['type']));
				$obj->rrd_format = '%5.1lf%s';
			break;
		}
	break;
	default:
		$obj->rrd_title = $default_title;
		$obj->rrd_vertical = sprintf('%s', str_replace('_', ' ', $obj->args['type']));
		$obj->rrd_format = '%5.1lf%s';
	break;
}

$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
?>
