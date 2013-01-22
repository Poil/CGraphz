<?php

# Collectd Filecount plugin
require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# filecount/
# filecount/files.rrd
# filecount/bytes.rrd



$obj = new Type_GenericStacked($CONFIG);
$obj->width = $width;
$obj->heigth = $heigth;

switch($obj->args['type'])
{

        case 'bytes':
                $obj->ds_names = array(
                        'value' => 'Bytes',
                );
                $obj->colors = array(
                        'value' => '0000ff',
                );
                $obj->rrd_title = sprintf('Bytes %s',
                        !empty($obj->args['pinstance']) ? ' ('.$obj->args['pinstance'].')' : '');
                $obj->rrd_vertical = ucfirst($CONFIG['datasize']);
                $obj->rrd_format = '%5.1lf%s';
				$obj->scale = $CONFIG['datasize'] == 'bits' ? 8 : 1;
        break;

        case 'files':
                $obj->ds_names = array(
                        'value' => 'Files',
                );
                $obj->colors = array(
                        'value' => 'f0a000',
                );
                $obj->rrd_title = sprintf('Files %s',
                        !empty($obj->args['pinstance']) ? ' ('.$obj->args['pinstance'].')' : '');

                $obj->rrd_vertical = 'Files';
                $obj->rrd_format = '%5.1lf%s';
        break;

}


collectd_flush($obj->identifiers);
$obj->rrd_graph();
