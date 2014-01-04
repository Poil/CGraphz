<?php

# Collectd Curl plugin

require_once 'modules/collectd.inc.php';
	
switch(GET('t')) {

	case 'players':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_title = 'Connections on '.(empty($obj->args['pinstance'])?$obj->args['pcategory']:$obj->args['pinstance']);
		$obj->rrd_vertical = 'Slots';
	break;
	
	// APC : https://github.com/Poil/CGraphz-extra-plugins/tree/master/php-apc
	case 'cache_result':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_title = 'Cache query on '.(empty($obj->args['pinstance'])?$obj->args['pcategory']:$obj->args['pinstance']);
		$obj->rrd_vertical = 'Queries';
	break;
	case 'cache_size':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_title = 'Cache size on '.(empty($obj->args['pinstance'])?$obj->args['pcategory']:$obj->args['pinstance']);
		$obj->rrd_vertical = 'Bytes';
	break;
	case 'files':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_title = 'Files on '.(empty($obj->args['pinstance'])?$obj->args['pcategory']:$obj->args['pinstance']);
		$obj->rrd_vertical = 'Files';
	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;

}

$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
