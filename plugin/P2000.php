<?php

# Collectd HP P2000 series plugin


require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';


$obj = new Type_GenericStacked($CONFIG);
$obj->width = $width;
$obj->heigth = $heigth;

$obj->rrd_title = sprintf('%s/%s-%s', $obj->args['pinstance'], $obj->args['type'], $obj->args['tcategory']);
$obj->rrd_format = '%5.1lf%s';

$obj->rrd_vertical = str_replace('_',' ',$obj->args['type']);

collectd_flush($obj->identifiers);
$obj->rrd_graph();
