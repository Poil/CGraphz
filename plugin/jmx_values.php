<?php

# Collectd jmx_values


require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array(
        'value' => 'count',
);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->generate_colors();
$obj->rrd_title = sprintf(' JMX values %s',
  !empty($obj->args['pinstance']) ? $obj->args['pinstance'] : '');

$obj->rrd_vertical = 'count';
$obj->rrd_format = '%5.0lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();