<?php

# logtail plugin

require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array(
        'value' => 'line',
);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->generate_colors();
$obj->rrd_title = sprintf('Tail %s',
  !empty($obj->args['pinstance']) ? $obj->args['pinstance'] : '');

$obj->rrd_vertical = 'log/min.';
$obj->rrd_format = '%6.0lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();