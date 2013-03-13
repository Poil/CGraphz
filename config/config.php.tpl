<?php
date_default_timezone_set('Europe/Paris');

define('CGRAPHZ_VERSION','1.60 alpha 1');
define('DB_HOST','localhost');
define('DB_PORT','3306');
define('DB_DATABASE','cgraphz');
define('DB_LOGIN','cgraphz');
define('DB_PASSWD','mypasswd');
define('LDAP_HOST','');
define('LDAP_PORT','');
define('LDAP_TREE','');
define('DIR_FSROOT',$_SERVER['DOCUMENT_ROOT'].'/CGraphz/');
define('DIR_WEBROOT', '/CGraphz');
define('DEBUG',false);
define('DIR_CACHE',DIR_FSROOT.'/cache');
define('DEF_LANG','fr');
define('MAX_SRV',4); // Nombre min de serveur avant affichage des catégories
//define('MAX_ELEM_ADM_TAB',2); // Nombre Max d elements par table d admin
//define('MAX_ADM_TAB',2);
define('NOT_LOGGED_MSG','<br />Please log-in<br />');

/*** Language ***/
define('DEF_LANG','en');

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
