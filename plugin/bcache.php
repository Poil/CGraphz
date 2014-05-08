<?php

# Collectd bcache plugin

require_once 'modules/collectd.inc.php';

# LAYOUT
#
# bcache-bcacheX/df_complex-dirty_data.rrd

switch(GET('t')) {
	case 'df_complex':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->data_sources = array('value');
		$obj->order = array('unused', 'dirty_data', 'used');
		$obj->ds_names = array(
			'unused'     => 'Unused',
			'dirty_data' => 'Dirty Data',
			'used'       => 'Used',
		);
		$obj->colors = array(
			'unused'     => '00ff00',
			'dirty_data' => 'ffb000',
			'used'       => '0000ff',
		);

		$obj->rrd_title = sprintf('bcache usage (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Bytes';
		$obj->rrd_format = '%5.1lf%sB';
	break;
	case 'bytes':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG);
		$obj->data_sources = array('value');
		$obj->order = array('bypassed');
		$obj->ds_names = array(
			'bypassed' => 'Bypassed',
		);
		$obj->colors = array(
			'bypassed' => '195aa7',
		);

		$obj->rrd_title = sprintf('bcache bypassed I/O (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Bytes (5 min avg)';
		$obj->rrd_format = '%5.1lf%sB';
	break;
	case 'cache_ratio':
		require_once 'type/Default.class.php';
		$obj = new Type_Default($CONFIG);
		$obj->data_sources = array('value');
		$obj->order = array('five_minute', 'hour', 'day', 'total');
		$obj->ds_names = array(
			'five_minute' => '5 min',
			'hour'        => 'hour',
			'day'         => 'day',
			'total'       => 'total',
		);
		$obj->colors = array(
			'five_minute' => '59db84',
			'hour'        => '195aa7',
			'day'         => 'e5279b',
			'total'       => 'ff7f00',
		);

		$obj->rrd_title = sprintf('bcache cache hit ratio (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Percent';
		$obj->rrd_format = '%5.1lf%s';
	break;
	case 'requests':
		require_once 'type/Default.class.php';
		$obj = new Type_Default($CONFIG);
		$obj->data_sources = array('value');
		$obj->order = array('hits', 'bypass_hits', 'bypass_misses', 'misses', 'miss_collisions', 'readaheads');
		$obj->ds_names = array(
			'bypass_hits'     => 'Bypass Hits',
			'bypass_misses'   => 'Bypass Misses',
			'hits'            => 'Hits',
			'miss_collisions' => 'Miss Collision',
			'misses'          => 'Misses',
			'readaheads'      => 'Read-aheads',
		);
		$obj->colors = array(
			'bypass_hits'     => 'ffb000',
			'bypass_misses'   => 'ff5e00',
			'hits'            => '00e000',
			'miss_collisions' => 'a000a0',
			'misses'          => 'ff0000',
			'readaheads'      => '0000ff',
		);

		$obj->rrd_title = sprintf('bcache access stats (%s)', $obj->args['pinstance']);
		$obj->rrd_vertical = 'Cache access (5 min avg)';
		$obj->rrd_format = '%5.1lf%s';
	break;
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();

