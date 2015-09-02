<?php
echo '<h1>'.MANAGE_ENVS.'</h1>';
include(DIR_FSROOT.'/html/config/environment/w_environment.php');
include(DIR_FSROOT.'/html/config/environment_server/e_environment_server_wh_id.php');
include(DIR_FSROOT.'/html/config/environment/e_environment.php');
include(DIR_FSROOT.'/html/config/environment/r_environment_wh_id.php');
include(DIR_FSROOT.'/html/config/environment/r_environment.php');
include(DIR_FSROOT.'/html/config/environment/d_environment.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_environment_server_class='';
$tab_environment_class='active';

if (isset($_GET['f_id_config_environment'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_config_environment').'"><button type="button" class="btn btn-primary">'.ADD.' '.ENV.'</button></a>';
    if (isset($_GET['f_id_config_server']) || $last_action=='edit_server') {
        $tab_environment_server_class='active';
        $tab_environment_class='';
    } 
}

if (isset($cur_environment)) {
    $environment_href='edit';
    $environment_title=EDIT.' '.ENV;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_environment_class.'"><a href="#environment_'.$environment_href.'" role="tab" data-toggle="tab">'.$environment_title.'</a></li>
          <li class="'.$tab_environment_server_class.'" ><a href="#environment_server" role="tab" data-toggle="tab">'.SERVER.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $environment_href='add';
    $environment_title=ADD.' '.ENV;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#environment_'.$environment_href.'" role="tab" data-toggle="tab">'.$environment_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_environment_class.'" id="environment_'.$environment_href.'"><fieldset>';
echo '<legend>'.ENV.'</legend>';
echo '<fieldset>';
if (isset($_GET['f_id_config_environment'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/config/environment/f_environment.php');
echo '</fieldset>';
echo '</fieldset></div>';

if (isset($_GET['f_id_config_environment'])) {
    echo '<div class="tab-pane '.$tab_environment_server_class.'" id="environment_server"><fieldset>';
    echo '<legend>'.SERVER.'</legend>';
    include(DIR_FSROOT.'/html/config/environment_server/w_environment_server.php');
    include(DIR_FSROOT.'/html/config/environment_server/e_environment_server.php');
    include(DIR_FSROOT.'/html/config/environment_server/r_environment_server_wh_id.php');
    include(DIR_FSROOT.'/html/config/environment_server/r_environment_server.php');
    include(DIR_FSROOT.'/html/config/environment_server/d_environment_server.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_config_server'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_config_server').'&amp;last_action=edit_server"><button type="button" class="btn btn-primary">'.ADD.' '.SERVER.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/config/environment_server/f_environment_server.php');
    echo '</div>';
}        

echo '</div>';
echo '<div class="clearfix"></div>';
?>
