<?php

# Collectd jmx_values

# LAYOUT
# jmx_values-threads/gauge-xxxx.rrd
# jmx_values-garbage/counter-collection.rrd

require_once 'modules/collectd.inc.php';

require_once 'type/Default.class.php';
$obj = new Type_Default($CONFIG);
/*
switch($_GET['pi']) {

	case 'threads':
                $obj->ds_names = array(
                        'value' => $obj->args['tinstance'].' Size',
                );
	break;
	
	case 'garbage':
                $obj->ds_names = array(
                        'value' => $obj->args['tinstance'].' Size',
                );

        break;
}
*/

$obj->width = $width;
$obj->heigth = $heigth;
$obj->generate_colors();
$obj->rrd_title = sprintf(' JMX values - %s',
  !empty($obj->args['pinstance']) ? $obj->args['pinstance'] : '');

$obj->rrd_vertical = 'count';
$obj->rrd_format = '%5.0lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
