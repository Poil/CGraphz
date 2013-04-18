<?php
# Define timezone
date_default_timezone_set('Europe/Paris');

# Cgraphz version
define('CGRAPHZ_VERSION','1.60 alpha 2');

# DB Version
define('DB_HOST','localhost');
define('DB_PORT','3306');
define('DB_DATABASE','cgraphz');
define('DB_LOGIN','root');
define('DB_PASSWD','MySup3rP4ssW0Rd');

# LDAP Configuration
## Host : ldaps://192.168.0.1
define('LDAP_HOST','');
## Port : 636
define('LDAP_PORT','');
## Tree : ou=People,dc=domain,dc=com
define('LDAP_TREE','');
 
# Filesystem path to cgraphz (ex: /var/www/cgraphz)
define('DIR_FSROOT',$_SERVER['DOCUMENT_ROOT'].'/CGraphz/');

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

# Language
define('DEF_LANG','en');

# Plugin that can have a TypeCategory
$CONFIG['plugin_tcategory']='/^(GenericJMX|elasticsearch|P2000)$/';

# Plugin that can have a PluginCategory
$CONFIG['plugin_pcategory']='/^(GenericJMX|varnish|curl_json|curl|curl_xml|P2000|tcpconns)$/';

# Display PI as title for these plugins
$CONFIG['title_pinstance']='/^(P2000)$/';

# collectd version
$CONFIG['version'] = 4;

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

# browser cache time for the graphs (in seconds)
$CONFIG['cache'] = 90;

# default width/height of the graphs
$CONFIG['width'] = 480;
$CONFIG['heigth'] = 175;
# default width/height of detailed graphs
$CONFIG['detail-width'] = 800;
$CONFIG['detail-heigth'] = 350;

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
