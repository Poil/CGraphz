<?php
date_default_timezone_set('Europe/Paris');

define('CGRAPHZ_VERSION','1.32');
define('DB_HOST','localhost');
define('DB_PORT','3306');
define('DB_DATABASE','cgraphz');
define('DB_LOGIN','root');
define('DB_PASSWD','');
define('LDAP_HOST','ldaps://');
define('LDAP_PORT','636');
define('LDAP_TREE','ou=People,dc=auth,dc=,dc=');
define('DIR_FSROOT',$_SERVER['DOCUMENT_ROOT']);
define('DIR_WEBROOT', '');
define('DEBUG',false);
define('DIR_CACHE',DIR_FSROOT.'/cache');
define('DEF_LANG','fr');
define('MAX_SRV',4); // Nombre min de serveur avant affichage des catégories
//define('MAX_ELEM_ADM_TAB',2); // Nombre Max d'elements par table d'admin'
//define('MAX_ADM_TAB',2);

// Liste des plugins à afficher
$plugins = array('load', 'memory', 'disk-sda', 'cpu', 'interface', 'processes', 'tcpconns');
# collectd version
$CONFIG['version'] = 4;

# collectd's datadir
$CONFIG['datadir'] = '/var/lib/collectd';

# rrdtool executable
$CONFIG['rrdtool'] = '/usr/bin/rrdtool';

# rrdtool special options
$CONFIG['rrdtool_opts'] = '';

# category of hosts to show on main page
#$CONFIG['cat']['category1'] = array('host1', 'host2');

# default plugins to show on host page
$CONFIG['overview'] = array('load', 'memory', 'swap'); 

# default plugins time range
$CONFIG['time_range']['default'] = 7200;
$CONFIG['time_range']['uptime']  = 31536000;

# show load averages on overview page
$CONFIG['showload'] = true;

# browser cache time for the graphs (in seconds)
$CONFIG['cache'] = 90;

# default width/height of the graphs
$CONFIG['width'] = 400;
$CONFIG['heigth'] = 175;
# default width/height of detailed graphs
$CONFIG['detail-width'] = 800;
$CONFIG['detail-heigth'] = 350;

# collectd's unix socket (unixsock plugin)
# enabled: 'unix:///var/run/collectd-unixsock'
# disabled: NULL
$CONFIG['socket'] = NULL;

$CONFIG['welcome_text'] =
'<h3>Bienvenue sur cgraphz</h3>
';

function my_autoload ($pClassName) {
	include(DIR_FSROOT . "/modules/" . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

include(DIR_FSROOT.'/html/form/commun/func_form.php');
?>
