<?php
/************************* CGraphz **********************/
# Cgraphz version
define('CGRAPHZ_VERSION','2.40 beta 1');

# Collectd
define('COLLECTD_DEFAULT_VERSION','collectd_5');
define('COLLECTD_VERSIONS',serialize(array(
	NULL,
	'collectd_4',
	'collectd_5'
)));

# AUTH type (default or ...) - don't touch this except if you want to use AUTH of an another software
define('AUTH_TYPE','default');

# LDAP Configuration
## Host : ldaps://192.168.0.1
define('LDAP_HOST','');
## Port : 636
define('LDAP_PORT','');
## Tree : ou=People,dc=domain,dc=com
define('LDAP_TREE','');
 
# Filesystem path to cgraphz (ex: /var/www/cgraphz).
# leave it as defined unless you know what you do.
define('DIR_FSROOT',realpath(__DIR__.'/../'));

# Dir web root (http://mydomain.com/XXXXXX : /XXXXXX)
define('DIR_WEBROOT', '/CGraphz');

# Enable debug
define('DEBUG',false);

# Text to display for user not logged
define('NOT_LOGGED_MSG','<br />Please log-in<br />');

# Display a quick navigate to plugin bar or not (true/false)
define('PLUGIN_BAR',true);

# Language
define('DEF_LANG','en');

# system default timezone when not set
define('DEFAULT_TIMEZONE', 'UTC');

# Form elements size
define('I_CSS','col-xs-6 col-sm-6 col-md-6 col-lg-6');
define('IL_CSS','col-xs-3 col-sm-3 col-md-3 col-lg-3');
define('S_CSS', 'col-xs-6 col-sm-6 col-md-6 col-lg-6');
define('SL_CSS','col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3');
define('SEM_CSS','col-xs-9 col-sm-9 col-md-9 col-lg-9');
define('C_CSS','col-xs-offset-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3 col-xs-9 col-sm-9 col-md-9 col-lg-9');

/************************* CGP *************************/
# extra typesdb config to merge to default
#$CONFIG['typesdb'][] = '/usr/share/collectd/my_extra_types.db';

# use the negative X-axis in I/O graphs
$CONFIG['negative_io'] = false;

# add XXth percentile line + legend to network graphs
# false = disabled; 95 = 95th percentile
$CONFIG['percentile'] = 95;

# create smooth graphs (rrdtool -E)
$CONFIG['graph_smooth'] = false;

# draw min/max spikes in a lighter color in graphs with type default
$CONFIG['graph_minmax'] = false;

# Plugin that can have a TypeCategory
$CONFIG['plugin_tcategory']='/^(GenericJMX|elasticsearch|P2000|nagiostats)$/';

# Plugin that can have a PluginCategory
$CONFIG['plugin_pcategory']='/^(GenericJMX|varnish|curl_json|curl|curl_xml|P2000|tcpconns|aggregation)$/';

# Display PI as title for these plugins
$CONFIG['title_pinstance']='/^(tail|P2000|GenericJMX|PM710|mysql)$/';

# prevent a linebreak between the img tag (true/false)
$CONFIG['no_break'] = false;

# collectd version
$CONFIG['version'] = 5;

# collectd's datadir
$CONFIG['datadir'] = '/var/lib/collectd/rrd/';

# rrdtool executable
$CONFIG['rrdtool'] = '/usr/bin/rrdtool';

# rrdtool special command-line options
$CONFIG['rrdtool_opts'] = array();

# default plugins time range
$CONFIG['time_range']['default'] = 7200;
$CONFIG['time_range']['uptime']  = 31536000;

# show load averages on overview page
$CONFIG['showload'] = true;

# show graphs in bits or bytes
$CONFIG['network_datasize'] = 'bytes';

# Base value 
## 1000 -> 1 Megabyte = 1000 Kilobyte 
## 1024 -> 1 Megabyte = 1024 Kilobyte)
$CONFIG['default_base']=1024;

# Display graphs as png, svg
# Note that svg graph dimensions are defined in "points" (pt) and not pixels, so svg image sizes will be different then png
$CONFIG['graph_type'] = 'png';

# browser cache time for the graphs (in seconds)
$CONFIG['cache'] = 90;

# default width/height of the graphs
$CONFIG['width'] = 480;
$CONFIG['height'] = 175;
# default width/height of detailed graphs
$CONFIG['detail-width'] = 800;
$CONFIG['detail-height'] = 350;
# max allowed width/height of the graphs
$CONFIG['max-width'] = 1280;
$CONFIG['max-height'] = 1024;

# collectd's unix socket (unixsock plugin) or rrdcached tcp socket
# syntax : 'unix:///var/run/collectd-unixsock'
# syntax : 'xxx.xxx.xxx.xxx:xxxx'
# disabled: NULL
#$CONFIG['flush_type'] = 'rrdcached';
#$CONFIG['flush_type'] = 'collectd';
$CONFIG['socket'] = NULL;

$CONFIG['welcome_text'] =
'<h3>Welcome on cgraphz</h3>
';


/******************* End config **********************/
function my_autoload ($pClassName) {
	include(DIR_FSROOT . "/modules/" . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

include(DIR_FSROOT.'/lang/local.'.DEF_LANG.'.php');
include(DIR_FSROOT.'/html/form/commun/func_form.php');
include(DIR_FSROOT.'/modules/functions.inc.php');

if (AUTH_TYPE != 'default') include(DIR_FSROOT.'/modules/'.AUTH_TYPE.'/external_auth.php');

if (!ini_get('date.timezone')) { date_default_timezone_set(DEFAULT_TIMEZONE); }
?>
