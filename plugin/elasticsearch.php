<?php

# Collectd GenericJMX plugin

require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

$obj = new Type_Default($CONFIG);
$rrd_title=ucfirst(str_replace('_',' ',$obj->args['tcategory']));

switch($obj->args['pinstance']) {
	case (preg_match('/catalina_request_processor.*/', $obj->args['pinstance']) ? true : false) :
	default :
		$obj -> rrd_title = $rrd_title;

		$obj -> rrd_vertical = sprintf('%s', str_replace('_', ' ', $obj -> args['type']));
		$obj -> rrd_format = '%5.1lf%s';

	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}

$obj -> rrd_format = '%5.1lf%s';

collectd_flush($obj -> identifiers);
$obj -> rrd_graph();
?>
