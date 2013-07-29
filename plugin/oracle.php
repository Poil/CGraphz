<?php

# Collectd Oracle plugin
require_once 'modules/collectd.inc.php';

## LAYOUT
# oracle-[instance]/df_[tablename].rrd
# oracle-[instance]/io_octets-tablespace-[tablename].rrd


switch($_GET['t']) {
        case 'df':
                require_once 'type/GenericStacked.class.php';
                $obj = new Type_GenericStacked($CONFIG);
                $obj->data_sources = array('free', 'used');
                $obj->ds_names = array(
                        'used' => 'Used',
                        'free' => 'Free',
                );
                $obj->colors = array(
                        'used' => '0000ff',
                        'free' => '00ff00',
                );
                $obj->rrd_title = sprintf('Tablespace usage %s',
                        !empty($obj->args['tinstance']) ? $obj->args['tinstance'] : '');
                $obj->rrd_vertical = 'Bytes';
                $obj->rrd_format = '%5.1lf%s';
        break;
        case 'io_octets':
                require_once 'type/GenericStacked.class.php';
                $obj = new Type_GenericStacked($CONFIG);
                $obj->data_sources = array('rx', 'tx');
                $obj->ds_names = array(
                        'rx' => 'Read',
                        'tx' => 'Write',
                );
                $obj->colors = array(
                        'rx' => '0000ff',
                        'tx' => '00ff00',
                );
                $obj->rrd_title = sprintf('Database i/o (%s)', $obj->args['tinstance']);
                $obj->rrd_vertical = 'Bytes/s';
                $obj->rrd_format = '%5.1lf%s';
        break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
?>
