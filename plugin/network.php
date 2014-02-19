<?php

# Collectd Interface plugin

require_once 'type/GenericIO.class.php';
require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

# LAYOUT - Collectd 4
# interface/
# interface/if_errors-XXXX.rrd
# interface/if_octets-XXXX.rrd
# interface/if_packets-XXXX.rrd

# LAYOUT - Collectd 5
# interface-XXXX/if_errors.rrd
# interface-XXXX/if_octets.rrd
# interface-XXXX/if_packets.rrd

$obj = new Type_GenericIO($CONFIG);

if (preg_replace('/[^a-zA-Z]/','',$CONFIG['version']) == 'Collectd') {
	$instance = (preg_replace('/[^0-9\.]/','',$CONFIG['version']) < 5) ? 'tinstance' : 'pinstance';
} else {
	 $instance = 'pinstance';
}

switch($obj->args['type']) {
	case 'if_octets':
		$obj->data_sources = array('rx', 'tx');
		$obj->ds_names = array(
			'rx' => 'Receive',
			'tx' => 'Transmit',
		);
		$obj->rrd_title = sprintf('Trafic');
		$obj->rrd_vertical = sprintf('%s per second', ucfirst($CONFIG['network_datasize']));
		$obj->scale = $CONFIG['network_datasize'] == 'bits' ? 8 : 1;
	break;
	case 'if_packets':
		$obj->data_sources = array('rx', 'tx');
		$obj->ds_names = array(
			'rx' => 'Receive',
			'tx' => 'Transmit',
		);
		$obj->rrd_title = sprintf('Packets');
		$obj->rrd_vertical = 'Packets per second';
	break;
	case 'queue_length':
		$obj = new Type_Default($CONFIG);
		$obj->data_sources = array('value');
		$obj->ds_names = array(
			'value' => 'Object',
		);
		$obj->rrd_title = sprintf('Queue Length');
		$obj->rrd_vertical = 'Objects in queue';
	break;
	case 'total_values':
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_title = sprintf('Total values');
		$obj->rrd_vertical = 'Value';
	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}

$obj->rrd_format = '%5.1lf%s';
collectd_flush($obj->identifiers);
$obj->rrd_graph();
