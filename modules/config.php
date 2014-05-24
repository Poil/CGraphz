<?php
# Filesystem path to cgraphz (ex: /var/www/cgraphz).
# leave it as defined unless you know what you do.
define('DIR_FSROOT',realpath(__DIR__.'/../'));

include(DIR_FSROOT.'/html/form/commun/func_form.php');
include(DIR_FSROOT.'/modules/functions.inc.php');

$WEB=json_clean_decode(DIR_FSROOT.'/config/web_config.json');
$AUTH=json_clean_decode(DIR_FSROOT.'/config/auth_config.json');
$VERSION=json_clean_decode(DIR_FSROOT.'/config/version_config.json');
$COLLECTD=json_clean_decode(DIR_FSROOT.'/config/collectd_config.json');
$GRAPH=json_clean_decode(DIR_FSROOT.'/config/graph_config.json');
$RRD=json_clean_decode(DIR_FSROOT.'/config/rrd_config.json');

function my_autoload ($pClassName) {
	include(DIR_FSROOT . "/modules/" . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

if ($AUTH['auth_type'] != 'default') { include(DIR_FSROOT.'/modules/'.$AUTH['auth_type'].'/external_auth.php'); }

if (!ini_get('date.timezone')) { date_default_timezone_set($WEB['def_timezone']); }

include(DIR_FSROOT.'/lang/local.'.$WEB['def_lang'].'.php');
?>

