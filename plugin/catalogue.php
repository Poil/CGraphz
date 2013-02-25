<?php

# Collectd Tina Catalog plugin


require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# irq/
# irq/irq-XX.rrd

$obj = new Type_GenericStacked($CONFIG);
$obj->width = $width;
$obj->heigth = $heigth;

$obj->rrd_title = 'Catalog Usage '.$obj->args['pinstance'];
//$obj->rrd_vertical = 'Bytes';
//$obj->rrd_format = '%6.1lf';

$obj->rrd_vertical = 'Bytes';
$obj->rrd_format = '%5.1lf%s';


collectd_flush($obj->identifiers);
$obj->rrd_graph();
