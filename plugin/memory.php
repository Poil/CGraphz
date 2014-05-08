<?php

# Collectd Memory plugin

require_once 'type/GenericStacked.class.php';
require_once 'modules/collectd.inc.php';

## LAYOUT
#- Unix like
# memory/
# memory/memory-buffered.rrd
# memory/memory-cached.rrd
# memory/memory-free.rrd
# memory/memory-used.rrd
#- Windows
# memory/
# memory/memory-available.rrd
# memory/memory-pool_nonpaged.rrd
# memory/memory-pool_paged.rrd
# memory/memory-system_cache.rrd
# memory/memory-system_code.rrd
# memory/memory-system_driver.rrd
# memory/memory-working_set.rrd
# memory-pagefile/memory-free.rrd
# memory-pagefile/memory-used.rrd


$obj = new Type_GenericStacked($CONFIG);
# SCC/Windows
if (preg_replace('/[^a-zA-Z]/','',$CONFIG['version']) == 'SSC') {
	switch(GET('pi')) {
		case 'pagefile':
			$obj->rrd_title = 'Pagefile utilization';
			$obj->order = array('free', 'used');
			$obj->ds_names = array(
				'free'     => 'Free',
				'used'     => 'Used',
			);
			$obj->colors = array(
				'free' => '00e000',
				'used' => 'ff0000',
			);

		break;
		default:
			$obj->rrd_title = 'Physical memory utilization';
			$obj->order = array('available', 'pool_nonpaged', 'pool_paged', 'system_cache', 'system_code','system_driver','working_set');
			$obj->ds_names = array(
				'available'     => 'Available',
				'pool_nonpaged' => 'Pool non paged',
				'pool_paged'    => 'Pool paged',
				'system_cache'  => 'System cache',
				'system_code'   => 'System code',
				'system_driver' => 'System driver',
				'working_set'   => 'Working set',
			);

			$obj->colors = array(
				'available'     => '00e000',
				'pool_nonpaged' => '0000ff',
				'pool_paged'    => 'ffb000',
				'system_cache'  => 'ff00ff',
				'system_code'   => 'ff0000',
				'system_driver' => 'ffff00',
				'working_set'   => 'ff0f0f',
			);
		break;
	};
} else { # Unix like
	$obj->rrd_title = 'Physical memory utilization';
	$obj->order = array('free', 'inactive', 'buffered', 'cached', 'cache', 'locked', 'used', 'active', 'wired');
	$obj->ds_names = array(
		'free'     => 'Free',
		'inactive' => 'Inactive',
		'cached'   => 'Cached',
		'cache'    => 'Cache',
		'buffered' => 'Buffered',
		'locked'   => 'Locked',
		'used'     => 'Used',
		'wired'    => 'Wired',
	);
	$obj->colors = array(
		'free' => '00e000',
		'inactive' => '00b000',
		'cached' => '0000ff',
		'cache' => '0000ff',
		'buffered' => 'ffb000',
		'locked' => 'ff00ff',
		'used' => 'ff0000',
		'active' => 'ff00ff',
		'wired' => 'ff0000',
	);
}

$obj->base=$CONFIG['default_base'];
$obj->rrd_vertical = 'Bytes';
$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
