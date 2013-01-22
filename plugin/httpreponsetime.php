<?php

# Collectd CPUfreq plugin


require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# cpufreq/cpufreq-X.rrd

$obj = new Type_Default($CONFIG);
$obj->data_sources = array('value');
$obj->ds_names = array(
        'value' => 'ms',
);
$obj->width = $width;
$obj->heigth = $heigth;
$obj->generate_colors();
$obj->rrd_title = sprintf('HTTP Response Time %s',
  !empty($obj->args['pinstance']) ? $obj->args['pinstance'] : '');

$obj->rrd_vertical = 'ms';
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();