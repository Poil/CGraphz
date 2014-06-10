<?php
$cur_url=$_SERVER["REQUEST_URI"];
$module=GET('module');
$component=GET('component');
$workflow=GET('workflow');
?>

<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
<?php
// Affichage du menu Dashboard si l'utilisateur a les droits
$perm_mod = new PERMS();
if ($perm_mod->perm_list_module('dashboard',false)) { 
   echo '
   <ul class="nav navbar-nav">
      <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown">',PERF_ANALYSIS,' <b class="caret"></b></a>
         <ul class="dropdown-menu">';
         $allowed_perm=$perm_mod->perm_list_module('dashboard', false);         
         if ($allowed_perm) {
            foreach ($allowed_perm as $allowed) {
               if ($allowed->component=='dynamic') {
                  echo '<li class="dropdown-submenu"><a tabindex="-1" href="#">'.$allowed->menu_name.'</a>';
                    echo '<ul class="dropdown-menu">';
                    include(DIR_FSROOT.'/html/menu/menu_dynamic_dashboard.php');
                    echo '</ul>';
                  echo '</li>';
               } else {
                  echo '<li><a href="index.php?module=dashboard&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
               }
            }
         }
         echo '</ul>
      </li>
   </ul>';
}
if ($perm_mod->perm_list_module('small_admin')) { 
  echo '
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">',SMALL_ADMIN,' <b class="caret"></b></a>
      <ul class="dropdown-menu">';
      $allowed_perm=$perm_mod->perm_list_module('small_admin', false);         
      if ($allowed_perm) {
         foreach ($allowed_perm as $allowed) {
            echo '<li><a href="index.php?module=small_admin&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
         }
      }
      echo '</ul>
    </li>
  </ul>';
}
if ($perm_mod->perm_list_module('perm') or $perm_mod->perm_list_module('auth') or $perm_mod->perm_list_module('config')) {
?>
  <ul class="nav navbar-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ADMIN ?> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo PERMS ?></a>
          <ul class="dropdown-menu">
          <?php
            $allowed_perm=$perm_mod->perm_list_module('perm', false);
            if ($allowed_perm) {
              foreach ($allowed_perm as $allowed) {
                echo ' <li><a href="index.php?module=perm&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
              }
            }
           
            $allowed_auth=$perm_mod->perm_list_module('auth', false);
            if ($allowed_auth) {
              foreach ($allowed_auth as $allowed) {
                echo ' <li><a href="index.php?module=auth&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
              }
            }
            ?>
          </ul>
        </li>
        <li class="dropdown-submenu">
          <a tabindex="-1" href="#"><?php echo CONF ?></a>
          <ul class="dropdown-menu">
            <?php
            $allowed_config=$perm_mod->perm_list_module('config', false);
            if ($allowed_config) {
              foreach ($allowed_config as $allowed) {
                echo ' <li><a href="index.php?module=config&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
              }
            }
            ?>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
<?php
}
?>
</div>
