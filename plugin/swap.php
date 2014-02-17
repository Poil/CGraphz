<?php

# Collectd Swap plugin


require_once 'modules/collectd.inc.php';

## LAYOUT
# swap/
# swap/swap-cached.rrd
# swap/swap-free.rrd
# swap/swap-used.rrd

switch(GET('t')) {
	case 'swap':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->order = array('free', 'cached', 'used');
		$obj->ds_names = array(
			'free'   => 'Free',
			'cached' => 'Cached',
			'used'   => 'Used',
		);
		$obj->colors = array(
			'free'   => '00e000',
			'cached' => '0000ff',
			'used'   => 'ff0000',
		);
		$obj->rrd_title = 'Swap utilization';
		$obj->rrd_vertical = 'Bytes';
		$obj->base = $CONFIG['default_base'];
	break;
	case 'swap_io':
		require_once 'type/GenericIO.class.php';
		$obj = new Type_GenericIO($CONFIG);
		$obj->order = array('out', 'in');
		$obj->ds_names = array(
			'out' => 'Out',
			'in'  => 'In',
		);
		$obj->colors = array(
			'out' => '0000ff',
			'in'  => '00b000',
		);
		$obj->rrd_title = 'Swapped I/O pages';
		$obj->rrd_vertical = 'Pages';
	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}

$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
