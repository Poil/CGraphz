<?php

# Collectd Terminal_services plugin


require_once 'type/Default.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
# terminal_services/users-active.rrd
# terminal_services/users-inactive.rrd

$obj = new Type_Default($CONFIG);
$obj->rrd_title = 'Users';
$obj->rrd_vertical = 'Users';
$obj->rrd_format = '%.1lf';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
