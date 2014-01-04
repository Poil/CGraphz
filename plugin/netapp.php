<?php

# NetApp plugin

require_once 'modules/collectd.inc.php';
   
# LAYOUT: NetApp
# netapp-system/cpu-system.rrd
# netapp-system/cpu-idle.rrd
# netapp-system/percent-disk_busy.rrd

# netapp-system/cache_result-hits.rrd
# netapp-system/if_octets.rrd
# netapp-system/disk_ops_complex-cifs_ops.rrd
# netapp-system/disk_octets.rrd
# netapp-system/disk_ops_complex-write_ops.rrd
# netapp-system/disk_ops_complex-read_ops.rrd
# netapp-system/disk_ops_complex-http_ops.rrd
# netapp-system/disk_ops_complex-fcp_ops.rrd

# netapp-system/disk_ops_complex-nfs_ops.rrd
# netapp-system/disk_ops_complex-total_ops.rrd
# netapp-wafl/cache_ratio-find_dir_hit.rrd
# netapp-wafl/cache_ratio-name_cache_hit.rrd
# netapp-wafl/cache_ratio-inode_cache_hit.rrd
# netapp-wafl/cache_ratio-buf_hash_hit.rrd
# netapp-volume-logs/disk_latency.rrd
# netapp-volume-logs/df_complex-snap_normal_used.rrd
# netapp-volume-logs/disk_octets.rrd
# netapp-volume-logs/df_complex-snap_reserved.rrd
# netapp-volume-logs/df_complex-free.rrd
# netapp-volume-logs/df_complex-used.rrd
# netapp-volume-logs/disk_ops.rrd
# netapp-volume-logs/df_complex-snap_reserve_used.rrd

if (GET('pi') == 'system') {
   switch(GET('t')) {
      # cpu-(system|idle).rrd
      case 'cpu':
         require_once 'type/GenericStackedPercent.class.php';
         $obj = new Type_GenericStackedPercent($CONFIG);
         $obj->order = array('idle', 'system');
         $obj->ds_names = array(
            'idle' => 'Idle',
            'system'   => 'System',
         );
         $obj->colors = array(
            'idle' => '00e000',
            'system'   => '0000ff',
         );
         $obj->rrd_title = 'NetApp CPU';
         $obj->rrd_vertical = '%';
         $obj->rrd_format = '%5.1lf%s';
         $obj->rrdtool_opts = '-r -u 100';
      break;
      # percent-disk_busy.rrd
      case 'percent':
        require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->data_sources = array('percent');
         $obj->order = array('percent');
         $obj->ds_names = array(
            'percent' => 'Percent',
         );
         $obj->colors = array(
            'percent' => '00e000',
         );
         $obj->rrd_title = 'Disk Busy';
         $obj->rrd_vertical = '%';
         $obj->rrd_format = '%5.1lf%s';
         #$obj->rrdtool_opts = '-r -u 100';
      break;
      case 'disk_octets':
         require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->data_sources = array('read', 'write');
         $obj->ds_names = array(
            'read' => 'Read',
            'write' => 'Write',
         );
         $obj->colors = array(
            'read' => '0000ff',
            'write' => '00e000',
         );
         $obj->rrd_title = sprintf('Disk rate');
         $obj->rrd_vertical = 'Byte/s';
         $obj->rrd_format = '%5.1lf%s';
      break;
      case 'if_octets':
         require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->data_sources = array('rx', 'tx');
         $obj->ds_names = array(
            'rx' => 'Received',
            'tx' => 'Transmited',
         );
         $obj->colors = array(
            'rx' => '0000ff',
            'tx' => '00e000',
         );
         $obj->rrd_title = sprintf('Network rate');
         $obj->rrd_vertical = 'Byte/s';
         $obj->rrd_format = '%5.1lf%s';
      break;
      case 'disk_ops_complex':
         require_once 'type/Default.class.php';
         $obj = new Type_Default($CONFIG);
         $obj->order = array(
            'cifs_ops', 
            'fcp_ops',
            'http_ops',
            'nfs_ops',
            'read_ops',
            'total_ops',
            'write_ops'
         );
         $obj->ds_names = array(
            'cifs_ops' => 'CIFS',
            'fcp_ops'   => 'FiberChannel',
            'http_ops' => 'HTTP',
            'nfs_ops' => 'NFS',
            'read_ops' => 'Read',
            'total_ops' => 'Total',
            'write_ops' => 'Write'
         );
         $obj->rrd_title = 'Operation per second';
         $obj->rrd_vertical = 'Ops/s';
         $obj->rrd_format = '%5.1lf%s';
      break;
      default:
         error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
      break;
   }
} else if (GET('pi') == 'wafl') {
   switch(GET('t')) {
      case 'cache_ratio':
         require_once 'type/Default.class.php';
         $obj = new Type_Default($CONFIG);
         $obj->ds_names = array(
            'buf_hash_hit' => 'buf hash hit',
            'find_dir_hit' => 'find dir hit',
            'inode_cache_hit' => 'inode cache hit',
            'name_cache_hit' => 'name cache hit'
         );
         $obj->rrd_title = sprintf('Hits');
         $obj->rrd_vertical = '%';
         $obj->rrd_format = '%5.1lf%s';
      break;
   }
} else if (preg_match('/^volume-(\w+)/',GET('pi'),$tab) || preg_match('/^volume-(\w+)/',GET('pc').'-'.GET('pi'),$tab)) {
   switch(GET('t')) {
      case 'df_complex':
         require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->order = array(
            'free', 
            'snap_normal_used',
            'snap_reserved',
            'snap_reserve_used',
            'used'
         );
         $obj->ds_names = array(
            'free' => 'Free',
            'snap_normal_used'   => 'Snap Normal Used',
            'snap_reserved' => 'Snap Reserved',
            'snap_reserve_used' => 'Snap Reserve Used',
            'used' => 'Used'
         );
         $obj->rrd_title = sprintf('Volume %s', $tab[1]);
         $obj->rrd_vertical = 'Byte';
         $obj->rrd_format = '%5.1lf%s';
      break;
      case 'disk_latency':
         require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->data_sources = array('read', 'write');
         $obj->ds_names = array(
            'read' => 'Read',
            'write' => 'Write',
         );
         $obj->colors = array(
            'read' => '0000ff',
            'write' => '00e000',
         );
         $obj->rrd_title = sprintf('Disk Latency %s', $tab[1]);
         $obj->rrd_vertical = 'us';
         $obj->rrd_format = '%5.1lf%s';
      break;
      case 'disk_octets':
         require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->data_sources = array('read', 'write');
         $obj->ds_names = array(
            'read' => 'Read',
            'write' => 'Write',
         );
         $obj->colors = array(
            'read' => '0000ff',
            'write' => '00e000',
         );
         $obj->rrd_title = sprintf('Disk octets %s', $tab[1]);
         $obj->rrd_vertical = 'us';
         $obj->rrd_format = '%5.1lf%s';
      break;
      case 'disk_ops':
         require_once 'type/GenericStacked.class.php';
         $obj = new Type_GenericStacked($CONFIG);
         $obj->data_sources = array('read', 'write');
         $obj->ds_names = array(
            'read' => 'Read',
            'write' => 'Write',
         );
         $obj->colors = array(
            'read' => '0000ff',
            'write' => '00e000',
         );
         $obj->rrd_title = sprintf('Disk ops %s', $tab[1]);
         $obj->rrd_vertical = 'us';
         $obj->rrd_format = '%5.1lf%s';
      break;
      default:
         error_image('Unknown graph type :'.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
      break;
   }
}

collectd_flush($obj->identifiers);
$obj->rrd_graph();
