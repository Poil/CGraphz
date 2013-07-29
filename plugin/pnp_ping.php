<?php

# Ping PNP

require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# filecount/
# filecount/files.rrd
# filecount/bytes.rrd


$obj = new Type_GenericStacked($CONFIG);

                $obj->ds_names = array(
                        '1' => 'ds1',
                );
                $obj->colors = array(
                        '1' => '0000ff',
                );
                $obj->rrd_title = 'blabla';
                $obj->rrd_vertical = 'blabla';
                $obj->rrd_format = '%5.1lf%s';


collectd_flush($obj->identifiers);
$obj->rrd_graph();
