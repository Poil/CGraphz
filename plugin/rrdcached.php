<?php

# Collectd jmx_values

# LAYOUT
# jmx_values-threads/gauge-xxxx.rrd
# jmx_values-garbage/counter-collection.rrd

require_once 'modules/collectd.inc.php';

require_once 'type/Default.class.php';
$obj = new Type_Default($CONFIG);

$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_title = 'RRDCached';

$obj->rrd_vertical = 'count';
$obj->rrd_format = '%5.0lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
?>
