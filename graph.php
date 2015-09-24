<?php
//session_cache_limiter("private");
require_once './config/config.php';
require_once 'modules/collectd.inc.php';

$auth = new AUTH_USER();
$log = new LOG();	

if (!$auth->verif_auth()) {
	error_image('[ERROR] Permission denied');
}
			
$s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);
$plugin = validate_get(GET('p'), 'plugin');
$plugininstance = validate_get(GET('pi'), 'plugininstance');
$plugincategory = validate_get(GET('pc'), 'plugincategory');
$type = validate_get(GET('t'), 'type');
$typecategory = validate_get(GET('tc'), 'typecategory');

if (preg_match($CONFIG['plugin_tcategory'], $plugin) && !empty($typecategory)) {
  $type_orig=$type;
  $typecategory = validate_get(GET('tc'), 'typecategory');
  $type = $type.'-'.$typecategory;
}

$width = GET('x') ? filter_input(INPUT_GET, 'x', FILTER_VALIDATE_INT, array(
	'min_range' => 10,
	'max_range' => $CONFIG['max-width']
)) : $CONFIG['width'];
$height = GET('y') ? filter_input(INPUT_GET, 'y', FILTER_VALIDATE_INT, array(
	'min_range' => 10,
	'max_range' => $CONFIG['max-height']
)) : $CONFIG['height'];
$height = empty($_GET['y']) ? $CONFIG['height'] : $_GET['y'];
$host=validate_get(GET('h'), 'host');
$s=intval($_GET['s']);
$e=isset($_GET['e']) ? intval($_GET['e']) : null;
$datadir = GET('datadir');

if (strpos($host,':')!=FALSE) {
	$tmp=explode(':',$host);
	$host=$tmp[0];
}

if (!$authorized=$auth->check_access_right($host)) {
	$log->write('CGRAPHZ ERROR: Permission denied for host : '.$host);
	error_image('[ERROR] Permission denied to '.$host);
}

if (validate_get(GET('h'), 'host') === NULL) {
	$log->write('CGRAPHZ ERROR: host contains unknown characters');
	error_image('[ERROR] host contains unknown characters');
}

if ($authorized->collectd_version) {
	$mytypesdb=$authorized->collectd_version;
} else {
	$mytypesdb=COLLECTD_DEFAULT_VERSION;
}

if (isset($CONFIG['typesdb']) && is_array($CONFIG['typesdb'])) {
	array_unshift($CONFIG['typesdb'],DIR_FSROOT.'/inc/types_'.$mytypesdb.'.db');
	 $typesdb = parse_typesdb_file($CONFIG['typesdb']);
} else {
	$typesdb = parse_typesdb_file(DIR_FSROOT.'/inc/types_'.$mytypesdb.'.db');
}

if ($plugin == 'aggregation') {
	$plugin = GET('pc');
}

# plugin json
if (function_exists('json_decode') && file_exists('plugin/'.$plugin.'-'.$plugininstance.'.json')) {
	$json = file_get_contents('plugin/'.$plugin.'-'.$plugininstance.'.json');
	$plugin_json = json_decode($json, true);
	
	if (is_null($plugin_json))
		$log->write('CGP Error: invalid json in plugin/'.$plugin.'.json');
} else if (function_exists('json_decode') && file_exists('plugin/'.$plugin.'-'.$plugincategory.'.json')) {
	$json = file_get_contents('plugin/'.$plugin.'-'.$plugincategory.'.json');
	$plugin_json = json_decode($json, true);
	
	if (is_null($plugin_json))
		$log->write('CGP Error: invalid json in plugin/'.$plugin.'.json');
} else if (function_exists('json_decode') && file_exists('plugin/'.$plugin.'-'.$plugincategory.'-'.$plugininstance.'.json')) {
	$json = file_get_contents('plugin/'.$plugin.'-'.$plugincategory.'-'.$plugininstance.'.json');
	$plugin_json = json_decode($json, true);
	
	if (is_null($plugin_json))
		$log->write('CGP Error: invalid json in plugin/'.$plugin.'.json');
} else {
	if (function_exists('json_decode') && file_exists('plugin/'.$plugin.'.json')) {
		$json = file_get_contents('plugin/'.$plugin.'.json');
		$plugin_json = json_decode($json, true);
	
		if (is_null($plugin_json))
			$log->write('CGP Error: invalid json in plugin/'.$plugin.'.json');
	} else {
	        $log->write(sprintf('CGRAPHZ ERROR: plugin "%s" is not available', $plugin));
	        error_image('Unknown graph type :'.$plugin.' '.PHP_EOL.str_replace('&',PHP_EOL,$_SERVER['QUERY_STRING']));
	}
}

if (!isset($plugin_json[$type]['type']))
	$plugin_json[$type]['type'] = 'default';

// Build pluginconfig
$pluginconfig=$CONFIG['datadir'][$datadir];

switch ($plugin_json[$type]['type']) {
	case 'stackedtotal':
		require_once 'type/GenericStackedTotal.class.php';
		$obj = new Type_GenericStackedTotal($CONFIG, $_GET, $pluginconfig);
		break;
	case 'stacked':
		require_once 'type/GenericStacked.class.php';
		$obj = new Type_GenericStacked($CONFIG, $_GET, $pluginconfig);
		break;
    case 'stackedbis':
        require_once 'type/GenericStackedBis.class.php';
        $obj = new Type_GenericStackedBis($CONFIG, $_GET);
        break;
	case 'io':
		require_once 'type/GenericIO.class.php';
		$obj = new Type_GenericIO($CONFIG, $_GET, $pluginconfig);
		break;
	case 'uptime':
		require_once 'type/Uptime.class.php';
		$obj = new Type_Uptime($CONFIG, $_GET, $pluginconfig);
		break;
	case 'filled':
		require_once 'type/GenericFilled.class.php';
		$obj = new Type_GenericFilled($CONFIG, $_GET, $pluginconfig);
		break;
	case 'iowpm':
		 require_once 'type/GenericIOWPM.class.php';
        $obj = new Type_GenericIOWPM($CONFIG, $_GET, $pluginconfig);
        break;
	case 'aggregation':
		require_once 'type/GenericAggregation.class.php';
        $obj = new Type_GenericAggregation($CONFIG, $_GET, $pluginconfig);
		break;
	case 'varnish':
		require_once 'type/VarnishStacked.class.php';
        $obj = new Type_VarnishStacked($CONFIG, $_GET, $pluginconfig);
		break;
	default:
		require_once 'type/Default.class.php';
		$obj = new Type_Default($CONFIG, $_GET, $pluginconfig);
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

if (GRAPH_TITLE!='text' || $obj->graph_type!='png') {
	if (isset($plugin_json[$type]['title'])) {
		$obj->rrd_title = $plugin_json[$type]['title'];
		$replacements = array(
			'{{PI}}' => GET('pi'),
			'{{PC}}' => GET('pc'),
			'{{TI}}' => GET('ti'),
			'{{TC}}' => GET('tc'),
			'{{HOST}}' => GET('h')
		);
		$obj->rrd_title = str_replace(array_keys($replacements), array_values($replacements), $obj->rrd_title);
	} 
} else {
	$obj->rrd_title='';
}

if (isset($plugin_json[$type]['vertical'])) {
	$obj->rrd_vertical = $plugin_json[$type]['vertical'];
	$obj->rrd_vertical = str_replace('{{ND}}', ucfirst($CONFIG['network_datasize']), $obj->rrd_vertical);
}

if (isset($plugin_json[$type]['rrdtool_opts'])) {
	$rrdtool_extra_opts = $plugin_json[$type]['rrdtool_opts'];
	# compatibility with plugins which specify arguments as string
	if (is_string($rrdtool_extra_opts)) {
		$rrdtool_extra_opts = explode(' ', $rrdtool_extra_opts);
	}

	$obj->rrdtool_opts = array_merge(
		$obj->rrdtool_opts,
		$rrdtool_extra_opts
	);
}

if ($type == 'if_octets')
	$obj->percentile = $CONFIG['percentile'];

if (isset($plugin_json[$type]['datasize']) and $plugin_json[$type]['datasize'])
	$obj->scale = $CONFIG['network_datasize'] == 'bits' ? 8 : 1;

if (isset($plugin_json[$type]['scale']))
	$obj->scale = $plugin_json[$type]['scale'];

if (isset($plugin_json[$type]['base']))
	$obj->base = $plugin_json[$type]['base'];

if (isset($plugin_json[$type]['legend_format']))
	$obj->rrd_format = $plugin_json[$type]['legend_format'];

$obj->rrd_graph();

