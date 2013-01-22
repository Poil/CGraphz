<?php

# logtail plugin

require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';
$obj = new Type_Default($CONFIG);

switch ($obj->args['pinstance']) {
        case (preg_match('/blocs-obsoletes.*/', $obj->args['pinstance']) ? true : false) :           
                $obj->rrd_title = sprintf('Tail %s',
                  !empty($obj->args['pinstance']) ? $obj->args['pinstance'] : '');
                $obj->rrd_vertical = '%';
                $obj->rrd_format = '%6.1lf';
        break;
        default:
                $obj->rrd_title = sprintf('Tail %s',
                  !empty($obj->args['pinstance']) ? $obj->args['pinstance'] : '');

                $obj->rrd_vertical = 'log/min.';
                $obj->rrd_format = '%6.0lf%s';
        break;
}


$obj->generate_colors();

$obj->width = $width;
$obj->heigth = $heigth;

collectd_flush($obj->identifiers);
$obj->rrd_graph();
