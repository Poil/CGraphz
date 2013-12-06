<?php
if (isset($_SESSION['time_range']) && is_numeric($_SESSION['time_range'])) {
        $time_range=$_SESSION['time_range'];
} else {
        if (isset($_SESSION['time_start']) && is_numeric($_SESSION['time_start']) && isset($_SESSION['time_end']) && is_numeric($_SESSION['time_end'])) {
                $time_start=$_SESSION['time_start'];
                $time_end=$_SESSION['time_end'];
                $time_range=null;
        } else {
                $time_range=$CONFIG['time_range']['default'];
                $time_start=null;
                $time_end=null;
        }
}

if (isset($_GET['auto_refresh'])) {
        $urlrefresh='<a href="'.removeqsvar($_SERVER['REQUEST_URI'],'auto_refresh').'"><img src="img/auto_refresh_on.png" title="'.STOP_AUTO_REFRESH.'" alt="Auto Refresh" /></a>';
} else {
        $urlrefresh='<a href="'.htmlentities($_SERVER['REQUEST_URI']).'&amp;auto_refresh=true"><img src="img/auto_refresh.png" title="'.ENABLE_AUTO_REFRESH.'" alt="Auto Refresh" /></a>';
}

echo '
<div id="left_menu">
	<div id="left_menu_show">
		<ul>			
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'3600\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1h</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'7200\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">2h</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'21600\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">6h</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'43200\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">12h</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'86400\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.DAY.'</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'172800\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">2 '.DAYS.'</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'604800\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.WEEK.'</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'2592000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.MONTH.'</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'15552000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">6 '.MONTHS.'</a></li>
			<li><a href="#" onclick="refresh_graph(\'dashboard\',\'31104000\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false">1 '.YEAR.'</a></li>
			<li><a href="#" onclick="Show_Popup($(\'.imggraph:first\').attr(\'src\')+\'&amp;x=800&amp;y=350\',\'\',\''.$time_start.'\',\''.$time_end.'\'); $(\'#left_menu_show\').hide(\'400\'); return false">'.CUSTOM.'</a></li>
		</ul>
	</div>
	<img src="img/refresh.png" style="cursor:pointer" onclick="refresh_graph(\'dashboard\',\'\',\'\',\'\'); return false" title="',REFRESH,'" alt="Refresh" />
	<br />
	<img src="img/clock.png" style="cursor:pointer" onclick="$(\'#left_menu_show\').toggle(\'400\'); return false;" title="',TIME_SELECTOR,'" alt="Time Selector" />
	<br />
	'.$urlrefresh.'
</div>';
if (isset($_GET['auto_refresh'])) {
	echo '
	<script type="text/javascript">
	$(document).ready(function() {
	  var auto_refresh=setInterval(function() {
	     refresh_graph(\'dashboard\',\'\',\'\',\'\');
	  }, 60000)
	});
	</script>';
}
?>
