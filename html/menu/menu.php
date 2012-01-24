<div id="div_header">
	<a href="index.php" style="float:left">Home</a>
	<a href="index.php" style="float:left">Help</a>
	<a href="index.php?f_logout=exit" style="float:right">Logout</a>
</div>
<div id="div_menu">


<h1>CGRAPHZ</h1>
<?php
// Affichage du menu Dashboard si l'utilisateur a les droits
$perm_mod = new PERMS();
if ($perm_mod->perm_list_module('dashboard')) { 
	echo '
	<ul class="niveau1">
		<li>Métrologie
		<ul class="niveau2">';
			$allowed_perm=$perm_mod->perm_list_module('dashboard', false);			
			if ($allowed_perm) {
				foreach ($allowed_perm as $allowed) {
					echo '<li><a href="index.php?module=dashboard&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
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
		<li>Gestion
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
echo <<< MENU_CONFIGURATION
	<ul class="niveau1">
		<li>Administration
			<ul class="niveau2">
MENU_CONFIGURATION;
?>
				<li>Permissions
					<ul class="niveau3">
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
						?>
					</ul>
				</li>

				<li>Configuration
					<ul class="niveau3">
						<?php
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