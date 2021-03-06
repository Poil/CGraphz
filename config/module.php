<?php
function removeqsvar($url, $varname) {
    if (is_array($varname)) {
        foreach ($varname as $cur_var) {
            $url=preg_replace('/([?&])'.$cur_var.'=[^&]+(&|$)/','$1',$url);
        }
    } else {
        $url=preg_replace('/([?&])'.$varname.'=[^&]+(&|$)/','$1',$url);
    }
    return htmlspecialchars($url);
}


$cur_url=$_SERVER["REQUEST_URI"];
$module=GET('module');
$component=GET('component');
$workflow=GET('workflow');

$perm_mod = new PERMS();

if(preg_match("/^[0-9a-z_]*$/", $module) && preg_match("/^[0-9a-z_]*$/", $component)){
    if ($perm_mod->perm_module($module, $component)) { // DEBUT PERM MODULE
        if(file_exists(DIR_FSROOT.'/component/'.$module.'/'.$component.'.php')){
            include(DIR_FSROOT.'/component/'.$module.'/'.$component.'.php');
        }else{
            echo $CONFIG['welcome_text'];
        }
    } else {
        if ($component && $module) {
            echo '<br />'.NO_ACCESS.'<br />';
        }
    }
} else {
    echo '<br />'.NO_ACCESS.'<br />';
    die();
}
?>
