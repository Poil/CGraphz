<?php
echo '<h1>'.MANAGE_MODULES.'</h1>';
include(DIR_FSROOT.'/html/perm/module/w_module.php');
include(DIR_FSROOT.'/html/perm/module_group/e_module_group_wh_id.php');
include(DIR_FSROOT.'/html/perm/module/e_module.php');
include(DIR_FSROOT.'/html/perm/module/r_module_wh_id.php');
include(DIR_FSROOT.'/html/perm/module/r_module.php');
include(DIR_FSROOT.'/html/perm/module/d_module.php');
echo '<div class="clearfix"></div>';

$last_action=isset($_GET['last_action']) ? $_GET['last_action'] : '';

$tab_module_group_class='';
$tab_module_class='active';

if (isset($_GET['f_id_perm_module'])) {
    echo '<a href="'.removeqsvar($cur_url,'f_id_perm_module').'"><button type="button" class="btn btn-primary">'.ADD.' '.MODULE.'</button></a>';
    if (isset($_GET['f_id_auth_group']) || $last_action=='edit_group') {
        $tab_module_group_class='active';
        $tab_module_class='';
    }
}

if (isset($cur_module)) {
    $module_href='edit';
    $module_title=EDIT.' '.MODULE;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="'.$tab_module_class.'"><a href="#module_'.$module_href.'" role="tab" data-toggle="tab">'.$module_title.'</a></li>
          <li class="'.$tab_module_group_class.'"><a href="#module_group" role="tab" data-toggle="tab">'.GROUP.'</a></li>
        </ul>
        <div class="tab-content">';
} else {
    $module_href='add';
    $module_title=ADD.' '.MODULE;
    echo '<div class="clearfix"></div><br />';
    echo '
        <ul class="nav nav-tabs" role="tablist">
          <li class="active"><a href="#module_'.$module_href.'" role="tab" data-toggle="tab">'.$module_title.'</a></li>
        </ul>
        <div class="tab-content">';
}

echo '<div class="tab-pane '.$tab_module_class.'" id="module_'.$module_href.'"><fieldset>';
echo '<legend>'.MODULE.'</legend>';
echo '<fieldset>';
if (isset($_GET['f_id_perm_module'])) {
    echo '<legend>'.EDIT.'</legend>';
} else {
    echo '<legend>'.ADD.'</legend>';
}
include(DIR_FSROOT.'/html/perm/module/f_module.php');
echo '</fieldset>';
echo '</fieldset></div>';

if (isset($_GET['f_id_perm_module'])) {
    echo '<div class="tab-pane '.$tab_module_group_class.'" id="module_group"><fieldset>';
    echo '<legend>'.GROUP.'</legend>';
    include(DIR_FSROOT.'/html/perm/module_group/w_module_group.php');
    include(DIR_FSROOT.'/html/perm/module_group/e_module_group.php');
    include(DIR_FSROOT.'/html/perm/module_group/r_module_group_wh_id.php');
    include(DIR_FSROOT.'/html/perm/module_group/r_module_group.php');
    include(DIR_FSROOT.'/html/perm/module_group/d_module_group.php');
    echo '<div class="clearfix"></div>';
    
    if (isset($_GET['f_id_auth_group'])) {
        echo '<a href="'.removeqsvar($cur_url,'f_id_auth_group').'&amp;last_action=edit_group"><button type="button" class="btn btn-primary">'.ADD.' '.GROUP.'</button></a>';
    }
    echo '<div class="clearfix"></div>';
    include(DIR_FSROOT.'/html/perm/module_group/f_module_group.php');
    
    echo '</div>';
}        
echo '</div>';
echo '<div class="clearfix"></div>';
?>
