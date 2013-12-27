<?php

# Collectd Curl XML plugin

require_once 'modules/collectd.inc.php';

switch(GET('t')) {

	default:
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->rrd_title = GET('t');
	break;

}

$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();

