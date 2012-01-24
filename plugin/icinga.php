<?php

# Collectd Icinga plugin
require_once 'modules/collectd.inc.php';

## LAYOUT
# latency-active_check_hosts.rrd
# latency-active_check_services.rrd
# latency-passive_check_hosts.rrd
# latency-passive_check_services.rrd
# percent-5_min_checks.rrd

switch($_GET['t']) {
# percent-5_min_checks.rrd
        case 'percent':
        require_once 'type/Default.class.php';
        $obj = new Type_Default($CONFIG);
        $obj->data_sources = array('percent');
                $obj->ds_names = array(
                        'percent' => '5 minutes checks',
                );
                $obj->colors = array(
                        'percent' => '00e000',
                );
                $obj->rrd_title = 'Icinga checks';
                $obj->rrd_vertical = 'percent';
        break;
        case 'latency':
                require_once 'type/GenericStacked.class.php';
                $obj = new Type_GenericStacked($CONFIG);
                $obj->width = $width;
                $obj->heigth = $heigth;
                $obj->generate_colors();

                $obj->rrd_title = sprintf('%s', $obj->args['type']);
                $obj->rrd_vertical = 'ms';
                $obj->rrd_format = '%5.1lf%s';

        break;


}

$obj->width = $width;
$obj->heigth = $heigth;
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
