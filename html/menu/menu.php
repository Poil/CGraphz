<?php
$cur_url=$_SERVER["REQUEST_URI"];
$module=GET('module');
$component=GET('component');
$workflow=GET('workflow');
?>
<style>
	.dropdown-submenu{position:relative;}
	.dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
	.dropdown-submenu:hover>.dropdown-menu{display:block;}
	.dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
	.dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
	.dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}

	select {
		margin-top : 10px;
		width : 220px;
		background-color : #ffffff;
		border : 1px solid #cccccc;
		height : 30px;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		padding: 4px 6px;
	}
	
	.navbar-inner > .container-fluid {
		text-align: center;
		max-width: 1024px;
		margin-left: auto;
		margin-right: auto;
	}
	
	.demi-spacer{
		margin-top : 10px;
	}	
	
	.navbar-default a{
		margin-top : 8px;
	} 
</style>
<div id="navigation">
<nav style="margin-bottom:-2px;" class="navbar navbar-inverse navbar-static-top" role="navigation">
	<div class="container-fluid"> 
		<div class="navbar-inner">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		</div>
		<div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" style="height: auto;">
			<div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-2" style="height: auto;">
				<ul class="nav navbar-nav">
					<a class="navbar-brand" href="" style="color: #ffffff; background-color: transparent; text-decoration: none;">CGraphZ</a>
				</ul>
<?php
$haveNav=false;
// Affichage du menu Dashboard si l'utilisateur a les droits
$perm_mod = new PERMS();
if ($perm_mod->perm_list_module('dashboard',false)) { 
	$haveNav=true;
	echo '
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">',PERF_ANALYSIS,' <b class="caret"></b></a>
						<ul class="dropdown-menu">';
	$allowed_perm=$perm_mod->perm_list_module('dashboard', false);			
	if ($allowed_perm) {
		foreach ($allowed_perm as $allowed) {
			if ($allowed->component=='dynamic') {
				echo '		<li class="dropdown-submenu">
								<a tabindex="-1" href="#">'.$allowed->menu_name.'</a>';
				echo '	  		<ul class="dropdown-menu">';						
				include(DIR_FSROOT.'/html/menu/menu_dynamic_dashboard.php');
				echo '	  		</ul>';
				echo '		</li>';
			} else {
				echo '		<li><a href="index.php?module=dashboard&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
			}
		}
	}
		echo '			</ul>
					</li>
				</ul>';
}
?>

<?php
// Affichage du menu Dashboard si l'utilisateur a les droits
$perm_mod = new PERMS();
if ($perm_mod->perm_list_module('small_admin')) { 
	$haveNav=true;
	echo '
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">',SMALL_ADMIN,' <b class="caret"></b></a>
						<ul class="dropdown-menu">';
	$allowed_perm=$perm_mod->perm_list_module('small_admin', false);			
	if ($allowed_perm) {
		foreach ($allowed_perm as $allowed) {
			echo '  		<li>
								<a href="index.php?module=small_admin&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a>
							</li>';
		}
	}
	echo '				</ul>
					</li>
				</ul>';
}
?>

<?php
// Affichage du menu Configuration si l'utilisateur a les droits
if ($perm_mod->perm_list_module('perm') or $perm_mod->perm_list_module('auth') or $perm_mod->perm_list_module('config')) {
	$haveNav=true;
	echo '
			<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">',ADMIN,' <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li class="dropdown-submenu">
								<a tabindex="-1" href="#">',PERMS,'</a>
								<ul class="dropdown-menu">';
		
	$allowed_perm=$perm_mod->perm_list_module('perm', false);
	if ($allowed_perm) {
		foreach ($allowed_perm as $allowed) {
			echo ' 					<li><a href="index.php?module=perm&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
		}
	}
						?>
						
						<?php
	$allowed_auth=$perm_mod->perm_list_module('auth', false);
	if ($allowed_auth) {
		foreach ($allowed_auth as $allowed) {
			echo ' 					<li><a href="index.php?module=auth&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
		}
	}
	echo '
								</ul>
							</li>
							<li class="dropdown-submenu">
								<a tabindex="-1" href="#">',CONF,'</a>
								<ul class="dropdown-menu">';
	$allowed_config=$perm_mod->perm_list_module('config', false);
	if ($allowed_config) {
		foreach ($allowed_config as $allowed) {
			echo ' 					<li><a href="index.php?module=config&amp;component='.$allowed->component.'">'.$allowed->menu_name.'</a></li>';
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
if($haveNav){
?>
				<p class="navbar-text pull-right" style="margin-top : 0px;">
					<a href="/logout" style="color: #ffffff; background-color: transparent; text-decoration: none;">Logout</a>
				</p>
			</div>
			<div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-2" style="height: auto; margin-left : 50px;">
<?php	
}
?>
			
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
<?php
if(!$haveNav){
	echo '		<p class="navbar-text pull-right" style="margin-top : 0px;">
					<a href="/logout" style="color: #ffffff; background-color: transparent; text-decoration: none;">Logout</a>
				</p>';
}
?>
			</div>
		</div>
	</div>
</nav>
</div>