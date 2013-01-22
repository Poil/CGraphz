<?php
date_default_timezone_set('Europe/Paris');

define('CGRAPHZ_VERSION','1.52');
define('DB_HOST','localhost');
define('DB_PORT','3306');
define('DB_DATABASE','visu01g');
define('DB_LOGIN','root');
define('DB_PASSWD','Zorglub+SQL');
define('LDAP_HOST','ldaps://192.168.158.3');
define('LDAP_PORT','636');
define('LDAP_TREE','ou=People,dc=auth,dc=pagesjaunes,dc=fr');
define('DIR_FSROOT',$_SERVER['DOCUMENT_ROOT']);
define('DIR_WEBROOT', '');
define('DEBUG',false);
define('DIR_CACHE',DIR_FSROOT.'/cache');
define('DEF_LANG','fr');
define('MAX_SRV',4); // Nombre min de serveur avant affichage des catégories
//define('MAX_ELEM_ADM_TAB',2); // Nombre Max d'elements par table d'admin'
//define('MAX_ADM_TAB',2);
define('NOT_LOGGED_MSG','<br />Pour toute demande d\'accès s\'adresser à <a href="mailto:demandes.exploitation@pjdirect.fr">demandes.exploitation@pjdirect.fr</a> en spécifiant les projets/environnements auxquels vous souhaitez avoir accès');

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

# show graphs in bits or bytes
$CONFIG['datasize'] = 'bytes';

# browser cache time for the graphs (in seconds)
$CONFIG['cache'] = 90;

# default width/height of the graphs
$CONFIG['width'] = 480;
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
	<br />En cas de besoin, merci de contacter les équipes suivantes :
	<dl>
		<dt>Questions concernant la supervision:</dt>
		<dd>Équipe PES, Production Exploitation Supervision (<a href=mailto:ael.esl.supervision@pagesjaunes.fr>ael.esl.supervision@pagesjaunes.fr</a>)</dd>
		<dt>Questions concernant l\'interface: </dt>
		<dd>Équipe Système et Intégration (<a href=mailto:ael.scs.systeme@pagesjaunes.fr>ael.scs.systeme@pagesjaunes.fr</a>)</dd>
	</dl>
';

function my_autoload ($pClassName) {
	include(DIR_FSROOT . "/modules/" . $pClassName . ".php");
}

spl_autoload_register("my_autoload");

include(DIR_FSROOT.'/html/form/commun/func_form.php');
include(DIR_FSROOT.'/modules/functions.inc.php');
?>
