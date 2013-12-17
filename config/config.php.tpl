<?php
# Define timezone
date_default_timezone_set('Europe/Paris');

# Cgraphz version
define('CGRAPHZ_VERSION','2.10 alpha 3');

# Collectd
define('COLLECTD_DEFAULT_VERSION',5);
define('COLLECTD_VERSIONS',serialize(array(3,4,5.0,5.1,5.2)));

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

# Menu Option : Min number of servers before displaying role
define('MAX_SRV',4);

# Replace topNavMenu with a FixedLeftMenu, but I don't like it
define('NEW_MENU',false);

# Max Legend lenght
define('MAX_LEGEND_LENGTH',20);

# Max image size in pixel (8388608 = 4096x2048)
define('MAX_IMG_SIZE',8388608);

# Language
define('DEF_LANG','en');

# use the negative X-axis in I/O graphs
$CONFIG['negative_io'] = false;

# create smooth graphs (rrdtool -E)
$CONFIG['graph_smooth'] = false;

# Plugin that can have a TypeCategory
$CONFIG['plugin_tcategory']='/^(GenericJMX|elasticsearch|P2000|nagiostats)$/';

# Plugin that can have a PluginCategory
$CONFIG['plugin_pcategory']='/^(GenericJMX|varnish|curl_json|curl|curl_xml|P2000|tcpconns)$/';

# Display PI as title for these plugins
$CONFIG['title_pinstance']='/^(P2000|GenericJMX|PM710)$/';

# collectd version
$CONFIG['version'] = 5;

# collectd's datadir
$CONFIG['datadir'] = '/var/lib/collectd/rrd/';

# rrdtool executable
$CONFIG['rrdtool'] = '/usr/bin/rrdtool';

# rrdtool special options
$CONFIG['rrdtool_opts'] = '';

# default plugins time range
$CONFIG['time_range']['default'] = 7200;
$CONFIG['time_range']['uptime']  = 31536000;

# show load averages on overview page
$CONFIG['showload'] = true;

# show graphs in bits or bytes
$CONFIG['network_datasize'] = 'bytes';

# Display graphs as png, svg or canvas 
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

# collectd's unix socket (unixsock plugin) or rrd tcp socket (collectd 4)
# syntax : 'unix:///var/run/collectd-unixsock'
# syntax : 'xxx.xxx.xxx.xxx:xxxx'
# disabled: NULL
#$CONFIG['flush_type'] = 'rrd';
#$CONFIG['flush_type'] = 'collectd';
$CONFIG['socket'] = NULL;

$CONFIG['welcome_text'] =
'<h3>Welcome on cgraphz</h3>
';

function my_autoload ($pClassName) {
	include(DIR_FSROOT . "/modules/" . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

include(DIR_FSROOT.'/lang/local.'.DEF_LANG.'.php');
include(DIR_FSROOT.'/html/form/commun/func_form.php');
include(DIR_FSROOT.'/modules/functions.inc.php');
?>
