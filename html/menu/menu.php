<?php
$cur_url=$_SERVER["REQUEST_URI"];
$module=GET('module');
$component=GET('component');
$workflow=GET('workflow');
?>
<div id="div_menu">
<div id="div_logout"><a href="index.php?f_logout=true">Logout</a></div>

<h1>CGRAPHZ</h1>
<?php
// Affichage du menu Dashboard si l'utilisateur a les droits
$perm_mod = new PERMS();
if ($perm_mod->perm_list_module('dashboard',false)) { 
	echo '
	<ul class="niveau1">
		<li>',PERF_ANALYSIS,'
		<ul class="niveau2">';
			$allowed_perm=$perm_mod->perm_list_module('dashboard', false);			
			if ($allowed_perm) {
				foreach ($allowed_perm as $allowed) {
					if ($allowed->component=='dynamic') {
						echo '<li>'.$allowed->menu_name;
							echo '<ul class="niveau3">';						
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
?>

<?php
// Affichage du menu Dashboard si l'utilisateur a les droits
$perm_mod = new PERMS();
if ($perm_mod->perm_list_module('small_admin')) { 
	echo '
	<ul class="niveau1">
		<li>',SMALL_ADMIN,'
		<ul class="niveau2">';
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
?>

<?php
// Affichage du menu Configuration si l'utilisateur a les droits
if ($perm_mod->perm_list_module('perm') or $perm_mod->perm_list_module('auth') or $perm_mod->perm_list_module('config')) {
echo '
	<ul class="niveau1">
		<li>',ADMIN,'
			<ul class="niveau2">
				<li>',PERMS,'
					<ul class="niveau3">';
?>
						<?php
						$allowed_perm=$perm_mod->perm_list_module('perm', false);
						
						if ($allowed_perm) {
							foreach ($allowed_perm as $allowed) {
								echo '<li><a href="index.php?module=perm&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
							}
						}
						?>
						
						<?php
						$allowed_auth=$perm_mod->perm_list_module('auth', false);
						if ($allowed_auth) {
							foreach ($allowed_auth as $allowed) {
								echo '<li><a href="index.php?module=auth&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
							}
						}
echo '
					</ul>
				</li>
				<li>',CONF,'
					<ul class="niveau3">';
						$allowed_config=$perm_mod->perm_list_module('config', false);
						if ($allowed_config) {
							foreach ($allowed_config as $allowed) {
								echo '<li><a href="index.php?module=config&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
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
<?php
if ($module == 'dashboard' && $component == 'view') {
	if (NEW_MENU) {
		include(DIR_FSROOT.'/html/dashboard/nav_menu/r_nav_menu.php');
		include(DIR_FSROOT.'/html/dashboard/nav_menu/d_nav_menu.php');
	} else {
		include(DIR_FSROOT.'/html/menu/menu_project.php');
	}
}
if(USE_MODE=="claranet"){
	include(DIR_FSROOT.'/modules/claranet/menuServer.php');
}
?>
