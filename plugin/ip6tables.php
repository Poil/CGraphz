<?php

# Collectd IPTables plugin

require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# ip6tables/ipt_bytes-XXX.rrd
# ip6tables/ipt_packets-XXX.rrd

$obj = new Type_GenericStacked($CONFIG);

$obj->data_sources = array('value');
switch(GET('t')) {
	case 'ipt_bytes':
	  $obj->rrd_title = 'Bytes';
	  break;
	case 'ipt_packets':
	  $obj->rrd_title = 'Packets';
	  break;
 }
$obj->rrd_vertical = '';
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
