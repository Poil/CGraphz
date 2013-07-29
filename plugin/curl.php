<?php

# Collectd Curl plugin




require_once 'modules/collectd.inc.php';

switch ($_GET['pi']) {
	
# LAYOUT: APC opcode cache
# curl-apc/cache_result-hits.rrd
# curl-apc/cache_result-misses.rrd
# curl-apc/cache_size-free.rrd
# curl-apc/cache_size-used.rrd
#   Requirement :
#   apc_stat.php 
/*<?php
  header('Content-Type: text/plain');
  if(!$cache_info = @apc_cache_info()) {
    die("No cache info available.");
  }
  $sma_info = apc_sma_info();
  $mem_used = $sma_info['seg_size'] - $sma_info['avail_mem'];
 
  echo 'mem_size: '.$sma_info['seg_size']."\n";
  echo 'mem_free: '.($sma_info['seg_size']-$mem_used)."\n";
  echo 'mem_used: '.$mem_used."\n";
  echo 'mem_free: '.$mem_free."\n";
  echo 'num_hits: '.$cache_info['num_hits']."\n";
  echo 'num_misses: '.$cache_info['num_misses']."\n";
  echo 'cached_files: '.count($cache_info['cache_list'])."\n";
  echo 'deleted_files: '.count($cache_info['deleted_list'])."\n";
 
?>
*/
# /etc/collectd.d/curl.conf
/*
<Plugin curl>
  <Page "apc">
    URL "http://part01g.he1.local/apc_stat.php"
    <Match>
      Regex "mem_free: ([0-9]+)"
      DSType "GaugeAverage"
      Type "cache_size"
       Instance "free"
    </Match>
    <Match>
      Regex "mem_used: ([0-9]+)"
      DSType "GaugeAverage"
      Type "cache_size"
       Instance "used"
    </Match>
    <Match>
      Regex "num_hits: ([0-9]+)"
      DSType "CounterAdd"
      Type "cache_result"
       Instance "hits"
    </Match>
    <Match>
      Regex "num_misses: ([0-9]+)"
      DSType "CounterAdd"
      Type "cache_result"
       Instance "misses"
    </Match>
  </Page>
</Plugin>
 */



	case 'apc':
		switch($_GET['t']) {
		
		# cache_result-(hits|misses).rrd
			case 'cache_result':
				require_once 'type/GenericStacked.class.php';
				$obj = new Type_GenericStacked($CONFIG);
				$obj->order = array('hits', 'misses');
				$obj->ds_names = array(
					'hits' => 'Hits',
					'misses'   => 'Misses',
				);
				$obj->colors = array(
					'hits' => '00e000',
					'misses'   => '0000ff',
				);
				$obj->rrd_title = 'APC Hits/Misses';
				$obj->rrd_vertical = 'Count';
			break;
		
		# cache_size-(used|free).rrd
			case 'cache_size':
				require_once 'type/GenericStacked.class.php';
				$obj = new Type_GenericStacked($CONFIG);
				$obj->order = array('used', 'free');
				$obj->ds_names = array(
					'used' => 'Used',
					'free'   => 'Free',
				);
				$obj->colors = array(
					'used' => '00e000',
					'free'   => '0000ff',
				);
				$obj->rrd_title = 'APC Memory usage';
				$obj->rrd_vertical = 'Memory';
			break;
		}
	break;
}

$obj->rrd_format = '%5.1lf%s';

collectd_flush($obj->identifiers);
$obj->rrd_graph();
