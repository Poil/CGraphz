<?php
$perm_mod = new PERMS();
if ($perm_mod->perm_module('dashboard','view')) {
  if (isset($_GET['f_id_config_project'])) {
    if (isset($all_environment) && $cpt_environment>1) {
      echo '<select>';
      foreach ($all_environment as $environment) {
        if (isset($_GET['f_id_config_environment']) && intval($_GET['f_id_config_environment'])==$environment->id_config_environment) {
          $style=' style="font-weight: bold;" ';
        } else {
          $style='';
        }
        if (isset($environment->id_config_environment)) $myenvironment=$environment->id_config_environment;
        else $myenvironment=0;

        if (isset($myrole)) {
          echo '<option><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$myenvironment.'&amp;f_id_config_role='.$myrole.'">'.$environment->environment_description.'</a></option>';
        }
        else {
          echo '<option><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$myenvironment.'">'.$environment->environment_description.'</a></option>';
        }
      }
      echo '</select>';
    }
    if ($cpt_environment <= 1 || isset($_GET['f_id_config_environment'])) {
      if (isset($all_role) && $cpt_role>1) {
        echo '<select>';
        foreach ($all_role as $role) {
          if (isset($_GET['f_id_config_role']) && intval($_GET['f_id_config_role'])==$role->id_config_role) {
            $style=' style="font-weight: bold;" ';
          } else {
            $style='';
          }
          if (isset($role->id_config_role)) $myrole=$role->id_config_role;
          else $myrole=0;

          if (isset($_GET['f_id_config_environment'])) {
            $f_id_config_environment=intval($_GET['f_id_config_environment']);
            echo '<option><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_environment='.$f_id_config_environment.'&amp;f_id_config_role='.$myrole.'">'.$role->role_description.'</a></option>';
          }
          else {
            echo '<option><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.'&amp;f_id_config_role='.$myrole.'">'.$role->role_description.'</a></option>';
          }
        }
        echo '</select>';
      }
      if (($cpt_server<MAX_SRV || $cpt_role<=1 || isset($_GET['f_id_config_role'])) && $cpt_server!==0) {
        echo '<select>';
        foreach ($all_server as $server) {
          if (intval(GET('f_id_config_server'))==$server->id_config_server) {
            $style=' style="font-weight: bold;" ';
          } else {
            $style='';
          }
          if (($cpt_server>MAX_SRV && $cpt_role>1) || isset($_GET['f_id_config_role'])) $str_role='&amp;f_id_config_role='.$f_id_config_role;
          else $str_role='';
          if (isset($_GET['f_id_config_environment'])) $str_environment='&amp;f_id_config_environment='.$f_id_config_environment;
          else $str_environment='';

          echo '<option><a '.$style.' href="index.php?module=dashboard&amp;component=view&amp;f_id_config_project='.$f_id_config_project.$str_role.$str_environment.'&amp;f_id_config_server='.$server->id_config_server.'">'.$server->server_name.'</a></option>';
        }
        echo '</select>';
      }
    }
  }
}
?>
