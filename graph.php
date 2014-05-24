<?php
//session_cache_limiter("private");
include './config/config.php';
require_once 'modules/collectd.inc.php';

session_name('CGRAPHZ');
session_start();

$auth = new AUTH_USER();
if (!$auth->verif_auth()) {
	error_image('[ERROR] Permission denied');
}
			
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);
$plugin = validate_get(GET('p'), 'plugin');
$type = validate_get(GET('t'), 'type');
$width = empty($_GET['x']) ? $CONFIG['width'] : $_GET['x'];
$height = empty($_GET['y']) ? $CONFIG['height'] : $_GET['y'];
$host=validate_get(GET('h'), 'host');
$s=intval($_GET['s']);
if (!$authorized=$auth->check_access_right($host)) {
	error_image('[ERROR] Permission denied');
}

if (strpos($host,':')!=FALSE) {
	$tmp=explode(':',$host);
	$host=$tmp[0];
}

if (validate_get(GET('h'), 'host') === NULL) {
	error_log('CGRAPHZ ERROR: plugin contains unknown characters');
	error_image('[ERROR] plugin contains unknown characters');
}

if (($width * $height) > $WEB['max_img_size']) {
        error_log('CGRAPHZ ERROR: image request is too big');
	error_image('[ERROR] Image request is too big');
}

if ($authorized->collectd_version) {
	$mytypesdb=$authorized->collectd_version;
} else {
	$mytypesdb=$COLLECTD['def_collectd_version'];
}

$typesdb = parse_typesdb_file(DIR_FSROOT.'/inc/types_'.$mytypesdb.'.db');

if ($plugin == 'aggregation') {
	$plugin = GET('pc');
}

# plugin json
if (file_exists('plugin/'.$plugin.'.json')) {
	$json = file_get_contents('plugin/'.$plugin.'.json');
	$plugin_json = json_decode($json, true);

	if (is_null($plugin_json))
		error_log('CGP Error: invalid json in plugin/'.$plugin.'.json');
} else {
        error_log(sprintf('CGRAPHZ ERROR: plugin "%s" is not available', $plugin));
        error_image('Unknown graph type :'.$plugin.' '.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
}

switch ($plugin_json[$type]['type']) {
	case 'stackedtotal':
		require_once 'type/GenericStackedTotal.class.php';
		$obj = new Type_GenericStackedTotal($CONFIG, $_GET);
		break;
	case 'stacked':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG, $_GET);
		break;
	case 'io':
		require_once 'type/GenericIO.class.php';
		$obj = new Type_GenericIO($CONFIG, $_GET);
		break;
	case 'uptime':
		require_once 'type/Uptime.class.php';
		$obj = new Type_Uptime($CONFIG, $_GET);
		break;
	default:
		require_once 'type/Default.class.php';
		$obj = new Type_Default($CONFIG, $_GET);
		break;
}

if (isset($typesdb[$type])) {
	$obj->data_sources = array();
	foreach ($typesdb[$type] as $ds => $property) {
		$obj->data_sources[] = $ds;
	}
}

if (isset($plugin_json[$type]['legend'])) {
	$obj->order = array();
	foreach ($plugin_json[$type]['legend'] as $rrd => $property) {
		$obj->order[] = $rrd;
		$obj->legend[$rrd] = isset($property['name']) ? $property['name'] : $rrd;
		if (isset($property['color']))
			$obj->colors[$rrd] = $property['color'];
	}
}

if (isset($plugin_json[$type]['title'])) {
	$obj->rrd_title = $plugin_json[$type]['title'];
	$obj->rrd_title = str_replace('{{PI}}', GET('pi'), $obj->rrd_title);
	$obj->rrd_title = str_replace('{{PC}}', GET('pc'), $obj->rrd_title);
	$obj->rrd_title = str_replace('{{TI}}', GET('ti'), $obj->rrd_title);
	$obj->rrd_title = str_replace('{{TC}}', GET('tc'), $obj->rrd_title);
}

if (isset($plugin_json[$type]['vertical'])) {
	$obj->rrd_vertical = $plugin_json[$type]['vertical'];
	$obj->rrd_vertical = str_replace('{{ND}}', ucfirst($CONFIG['network_datasize']), $obj->rrd_vertical);
}

if (isset($plugin_json[$type]['rrdtool_opts'])) {
	$obj->rrdtool_opts = $plugin_json[$type]['rrdtool_opts'];
}

if (isset($plugin_json[$type]['datasize']) and $plugin_json[$type]['datasize'])
	$obj->scale = $CONFIG['network_datasize'] == 'bits' ? 8 : 1;

if (isset($plugin_json[$type]['scale']))
	$obj->scale = $plugin_json[$type]['scale'];

if (isset($plugin_json[$type]['base']))
	$obj->base = $plugin_json[$type]['base'];

if (isset($plugin_json[$type]['legend_format']))
	$obj->rrd_format = $plugin_json[$type]['legend_format'];

$obj->rrd_graph();

