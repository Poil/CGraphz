<?php
# Define timezone
date_default_timezone_set('Europe/Paris');

# Cgraphz version
define('CGRAPHZ_VERSION','2.20 alpha2');

# Collectd
define('COLLECTD_DEFAULT_VERSION','Collectd 5.0');
define('COLLECTD_VERSIONS',serialize(array(
	NULL,
	'Collectd 3',
	'Collectd 4',
	'Collectd 5.0',
	'Collectd 5.1',
	'Collectd 5.2',
	'SSC 3.0'
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
 
# Filesystem path to cgraphz (ex: /var/www/cgraphz)
define('DIR_FSROOT','/var/www/CGraphz');

# Dir web root (http://mydomain.com/XXXXXX : /XXXXXX)
define('DIR_WEBROOT', '/CGraphz');

# Enable debug
define('DEBUG',false);

# Text to display for user not logged
define('NOT_LOGGED_MSG','<br />Please log-in<br />');

# Display a quick navigate to plugin bar or not (true/false)
define('PLUGIN_BAR',true);

# Menu Option : Min number of servers before displaying role
define('MAX_SRV',4);

# Replace topNavMenu with a FixedLeftMenu, but I don't like it
define('NEW_MENU',false);

# Language
define('DEF_LANG','en');

# Max Legend lenght
define('MAX_LEGEND_LENGTH',20);

# Max image size in pixel (8388608 = 4096x2048)
define('MAX_IMG_SIZE',8388608);

# system default timezone when not set
define('DEFAULT_TIMEZONE', 'UTC');

# use the negative X-axis in I/O graphs
$CONFIG['negative_io'] = false;

# create smooth graphs (rrdtool -E)
$CONFIG['graph_smooth'] = false;

# Plugin that can have a TypeCategory
$CONFIG['plugin_tcategory']='/^(GenericJMX|elasticsearch|P2000)$/';

# Plugin that can have a PluginCategory
$CONFIG['plugin_pcategory']='/^(GenericJMX|aggregation|varnish|curl_json|curl|curl_xml|P2000|tcpconns)$/';

# Display PI as title for these plugins
$CONFIG['title_pinstance']='/^(P2000)$/';

# collectd's datadir
$CONFIG['datadir'] = '/var/lib/collectd/rrd';

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

# Base value 
## 1000 -> 1 Megabyte = 1000 Kilobyte 
## 1024 -> 1 Megabyte = 1024 Kilobyte)
$CONFIG['default_base']=1024;

# collectd's unix socket (unixsock plugin) or rrd tcp socket (collectd 4)
# syntax : 'unix:///var/run/collectd-unixsock'
# syntax : 'xxx.xxx.xxx.xxx:xxxx'
# disabled: NULL
#$CONFIG['flush_type'] = 'rrd';
$CONFIG['flush_type'] = 'collectd';
$CONFIG['socket'] = NULL;

$CONFIG['rrd_fetch_method'] = 'async';

$CONFIG['welcome_text'] =
'<h1>Welcome on cgraphz</h1>
This is the welcome message<br />
Feel free to write what you want here :D
<br />
<br />
It\'s just HTML ...
<br />
<br />
<h1>Note</h1>
The dynamic dashboard creation was broken in 2.10 alpha / beta, it\'s now fixed !
<br />
<br />
<h1>ChangeLog</h1>
<pre>
2.20

    ADD : Support SSC Serv (Windows collecter) format (Memory, Disk)
    Fix : Filename with special characters wasn\'t graph
    Fix : Security issue on rrd.php (non auth user was able to download rrd files)

2.10

    FIX : Zooming error in some case
    ADD : configure collectd_version per server
    ADD : Add debugging image when rrd format is unknown
    CHG : better admin (confirm on delete, cascading delete, redirect to "add element" after a delete)
    CHG : Switch to another PDO class
    CHG : Split databasae configuration from config.php (I need to continue to split this big configuration file)
    CHG : New multiselect library
    CHG : Update JQuery libraries
    CHG : Better CSS
    and more (check commit logs)
</pre>
';

function my_autoload ($pClassName) {
	include(DIR_FSROOT . "/modules/" . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

include(DIR_FSROOT.'/lang/local.'.DEF_LANG.'.php');
include(DIR_FSROOT.'/html/form/commun/func_form.php');
include(DIR_FSROOT.'/modules/functions.inc.php');

if (!ini_get('date.timezone')) { date_default_timezone_set(DEFAULT_TIMEZONE); }
