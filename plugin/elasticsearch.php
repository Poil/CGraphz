<?php

# Collectd GenericJMX plugin

require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

$obj = new Type_Default($CONFIG);

$pospi = strpos($obj->args['pinstance'], '-');
if ($pospi !== false) {
        if (($pospi+1) != strlen($obj->args['pinstance'])) {
                $sub = substr($obj->args['pinstance'], $pospi+1);
        } else {
                $sub = substr($obj->args['pinstance'], 0, -1);
        }
} else {
        $sub = $obj->args['pinstance'];
}


if ($obj->args['tinstance'] != "") {
        if (substr($obj->args['tinstance'],-2)=='-*') {
                $obj->args['tinstance']=substr($obj->args['tinstance'],0,strlen($obj->args['tinstance'])-2);
        }
        $rrd_title = sprintf('%s', str_replace('_', ' ', str_replace('*', '', $subpi.' '.$obj->args['tinstance'])));

} else {
        $rrd_title = sprintf('%s', trim(str_replace('_', ' ', $sub)));
}

switch($obj->args['pinstance']) {
	case (preg_match('/catalina_request_processor.*/', $obj->args['pinstance']) ? true : false) :
	default :
		$obj -> rrd_title = $rrd_title;

		$obj -> rrd_vertical = sprintf('%s', str_replace('_', ' ', $obj -> args['type']));
		$obj -> rrd_format = '%5.1lf%s';

		break;
}

$obj -> width = $width;
$obj -> heigth = $heigth;
$obj -> rrd_format = '%5.1lf%s';

collectd_flush($obj -> identifiers);
$obj -> rrd_graph();
?>
