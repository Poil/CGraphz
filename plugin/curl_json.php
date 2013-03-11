<?php

# Collectd Curl plugin

require_once 'modules/collectd.inc.php';
	
switch($_GET['t']) {

	case 'players':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->ds_names = array(
			'players' => 'Players',
			'free_slots'   => 'Free Slots',
		);
		$obj->rrd_title = 'Connections on '.$obj->args['pinstance'];
		$obj->rrd_vertical = 'Slots';
	break;

}

$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
