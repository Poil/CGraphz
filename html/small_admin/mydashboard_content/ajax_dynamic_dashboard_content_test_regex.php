<?php
include('../../../config/config.php');
include('../../../modules/preg_find.php');

$auth = new AUTH_USER();
if (!$auth->verif_auth()) {
    die();
}

if ($_POST['f_regex_srv']) {
    $f_regex_srv=filter_input(INPUT_POST,'f_regex_srv',FILTER_SANITIZE_SPECIAL_CHARS);
    $s_id_user=filter_var($_SESSION['S_ID_USER'],FILTER_SANITIZE_NUMBER_INT);

    $connSQL=new DB();
    $lib='
    SELECT
        cs.id_config_server,
        cs.server_name
    FROM config_server cs
        LEFT JOIN config_server_project csp
            ON cs.id_config_server=csp.id_config_server
        LEFT JOIN perm_project_group ppg
            ON ppg.id_config_project=csp.id_config_project
        LEFT JOIN auth_group ag
            ON ag.id_auth_group=ppg.id_auth_group
        LEFT JOIN auth_user_group aug
            ON aug.id_auth_group=ag.id_auth_group
    WHERE aug.id_auth_user=:s_id_user
        AND cs.server_name REGEXP :f_regex_srv
    GROUP BY id_config_server, server_name
    ORDER BY server_name';

    $connSQL->bind('f_regex_srv',$f_regex_srv);
    $connSQL->bind('s_id_user',$s_id_user);
    $all_server=$connSQL->query($lib);
    $cpt_server=count($all_server);

    $f_regex_p=filter_input(INPUT_POST,'f_regex_p',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_regex_pi=filter_input(INPUT_POST,'f_regex_pi',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_regex_t=filter_input(INPUT_POST,'f_regex_t',FILTER_SANITIZE_SPECIAL_CHARS);
    $f_regex_ti=filter_input(INPUT_POST,'f_regex_ti',FILTER_SANITIZE_SPECIAL_CHARS);

    for ($i=0; $i<$cpt_server; $i++) {
        $allDatadir=getAllDatadir();
        foreach($allDatadir as $key => $datadir){
            if(!is_dir($datadir.'/'.$all_server[$i]->server_name.'/')) unset($allDatadir[$key]);
        }

        if (!empty($allDatadir)) {
            $myregex='#^(('.implode('|',$allDatadir).')/'.$all_server[$i]->server_name.'/)('.$f_regex_p.')(?:\-('.$f_regex_pi.'))?/('.$f_regex_t.')(?:\-('.$f_regex_ti.'))?\.rrd#';

            $plugins = array();
            foreach($allDatadir as $datadir) {
                $tplugins = preg_find($myregex, $datadir.'/'.$all_server[$i]->server_name, PREG_FIND_RECURSIVE|PREG_FIND_FULLPATH|PREG_FIND_SORTBASENAME);
                $plugins=array_merge($plugins, $tplugins);
            }

            foreach ($plugins as $plugin) {
                preg_match($myregex, $plugin, $matches);
                if (isset($matches[3])) {
                    $str=$matches[3];
                }
                if (isset($matches[4]) && $matches[4]!='') {
                    $str.='-'.$matches[4].'/';
                } else {
                    $str.='/';
                }
                if (isset($matches[5])) {
                    $str.=$matches[5];
                }
                if (isset($matches[6]) && $matches[6]!='') {
                    $str.='-'.$matches[6].'.rrd';
                } else {
                    $str.='.rrd';
                }
                $plugin_array[]=$str;
            }

        }
    }

    echo '<div>'.SERVERS_FOUND.'<br />';
    foreach ($all_server as $server) {
        echo $server->server_name.', ';
    }
    echo '</div><br />
    <div>'.RRDS_FOUND.'<br />';

    $plugin_array=array_unique($plugin_array,SORT_REGULAR);

    foreach ($plugin_array as $plugin) {
        echo $plugin.'<br />';
    }
    echo '</div>';
}
?>
