<?php
echo '<h1>'.MANAGE_MODULES.'</h1>';
include(DIR_FSROOT.'/html/config/plugin_filter/w_plugin_filter.php');
include(DIR_FSROOT.'/html/config/plugin_filter/e_plugin_filter.php');
include(DIR_FSROOT.'/html/config/plugin_filter/r_plugin_filter_wh_id.php');
include(DIR_FSROOT.'/html/config/plugin_filter/r_plugin_filter.php');
include(DIR_FSROOT.'/html/config/plugin_filter/d_plugin_filter.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_plugin_filter_class='active';

if (isset($_GET['f_id_config_plugin_filter'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_config_plugin_filter').'"><button type="button" class="btn btn-primary">'.ADD.' '.PLUGIN.'</button></a>';
}

if (isset($cur_plugin_filter)) {
    $plugin_filter_href='edit';
    $plugin_filter_title=EDIT.' '.PLUGIN;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_plugin_filter_class.'"><a href="#plugin_filter_'.$plugin_filter_href.'" role="tab" data-toggle="tab">'.$plugin_filter_title.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $plugin_filter_href='add';
    $plugin_filter_title=ADD.' '.PLUGIN;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#plugin_filter_'.$plugin_filter_href.'" role="tab" data-toggle="tab">'.$plugin_filter_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_plugin_filter_class.'" id="plugin_filter_'.$plugin_filter_href.'"><fieldset>';
if (isset($_GET['f_id_config_plugin_filter'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/config/plugin_filter/f_plugin_filter.php');
echo '</fieldset></div>';

echo '</div>';
echo '<div class="clearfix"></div>';
?>
