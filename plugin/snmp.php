<?php

# Collectd snmp plugin

require_once 'modules/collectd.inc.php';
require_once 'type/Default.class.php';


$obj = new Type_Default($CONFIG);
$obj->width = $width;
$obj->heigth = $heigth;

$obj->rrd_title = sprintf('SNMP: %s (%s)', $obj->args['type'], $obj->args['tinstance']);
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
