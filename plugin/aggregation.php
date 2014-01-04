<?php

# Collectd aggregation plugin

require_once 'type/Default.class.php';
require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
#
# collectd, by default, creates the aggregation RRDs in the following pattern:
# /(basedir)/(hostname)/aggregation-(type)-(instance)/(type)-(datasources).rrd
# 
# Examples (aggregation of multiple CPUs in a single host):
#
# collectd configuration:
# <Plugin "aggregation">
#  <Aggregation>
#    Host "athens"
#    Plugin "cpu"
#    Type "cpu"
#    GroupBy "Host"
#    GroupBy "TypeInstance"
#	 CalculateSum true
# 	 CalculateAverage true
#	 </Aggregation>
# </Plugin>
#
# Produces filenames like:
# /rrdcollectd/athens/aggregation-cpu-average/cpu-idle.rrd
# /rrdcollectd/athens/aggregation-cpu-average/cpu-user.rrd
# /rrdcollectd/athens/aggregation-cpu-average/cpu-wait.rrd
# /rrdcollectd/athens/aggregation-cpu-average/cpu-system.rrd

switch(GET('t')) {
	case 'cpu':
		include('cpu.php');
	break;
	case 'df':
		include('df.php');
	break;
	case 'df_complex':
		include('df.php');
	break;
	default:
		error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	break;
}


