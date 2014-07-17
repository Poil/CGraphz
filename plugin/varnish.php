<?php

# Collectd varnish plugin

require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
#varnish-default-backend/connections-failures.rrd
#varnish-default-backend/connections-recycled.rrd
#varnish-default-backend/connections-success.rrd
#varnish-default-backend/connections-unused.rrd
#varnish-default-backend/connections-not-attempted.rrd
#varnish-default-backend/connections-reuses.rrd
#varnish-default-backend/connections-too-many.rrd
#varnish-default-backend/connections-was-closed.rrd
#varnish-default-cache/cache_result-hitpass.rrd
#varnish-default-cache/cache_result-hit.rrd
#varnish-default-cache/cache_result-miss.rrd
#varnish-default-connections/connections-accepted.rrd
#varnish-default-connections/connections-dropped.rrd
#varnish-default-connections/connections-received.rrd

$obj = new Type_Default($CONFIG);
$obj->rrd_format = '%5.1lf%s';
switch($obj->args['pinstance']) {
	case 'backend':
		$obj->rrd_title = 'backend';
		$obj->rrd_vertical = 'hits';
	break;
	case 'cache':
		$obj->rrd_title = 'cache';
		$obj->rrd_vertical = 'hits';
	break;
	case 'connections':
		$obj->rrd_title = 'connections';
		$obj->rrd_vertical = 'hits';
	break;
	case 'shm':
        $obj->rrd_title = 'shm';
        $obj->rrd_vertical = 'total_operations';
    break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}
collectd_flush($obj->identifiers);
$obj->rrd_graph();
