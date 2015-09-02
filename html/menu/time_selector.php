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

if (isset($time_start) && isset($time_end)) {
	$zoom='onclick="Show_Popup($(\'.imggraph:first\').attr(\'src\').split(\'?\')[1],\'\',\''.$time_start.'\',\''.$time_end.'\'); $(\'#left_menu_show\').hide(\'400\'); return false"';
} else {
	$zoom='onclick="Show_Popup($(\'.imggraph:first\').attr(\'src\').split(\'?\')[1],\''.$time_range.'\',\'\',\'\'); $(\'#left_menu_show\').hide(\'400\'); return false"';
}

/* form graph size selector */
if (isset($_POST['f_x'])) { $_SESSION['graph_width']=filter_input(INPUT_POST,'f_x',FILTER_SANITIZE_NUMBER_INT); }
if (isset($_POST['f_y'])) { $_SESSION['graph_height']=filter_input(INPUT_POST,'f_y',FILTER_SANITIZE_NUMBER_INT); }
$x = (!empty($_SESSION['graph_width']) && $_SESSION['graph_width'] != 0) ? $_SESSION['graph_width'] : $CONFIG['width'];
$y = (!empty($_SESSION['graph_height']) && $_SESSION['graph_height'] != 0) ? $_SESSION['graph_height'] : $CONFIG['height'];

$form = new Form('horizontal');
$form->fieldset(true);

$form->add('html', '<legend>'.GRAPH_SIZE_SELECTOR.'</legend>');
$form->add('text', 'f_x')
     ->label(WIDTH)
     ->labelGrid('col-xs-3 col-md-4')
     ->inputGrid('col-xs-10 col-md-8')
     ->value($x)
     ->placeholder(WIDTH);

$form->add('text', 'f_y')
     ->label(HEIGHT)
     ->labelGrid('col-xs-3 col-md-4')
     ->inputGrid('col-xs-10 col-md-8')
     ->value($y)
     ->placeholder(HEIGHT);
 
$form->add('submit', 'f_submit_graph_size')
     ->iType('primary')
     ->labelGrid('col-xs-offset-3 col-md-offset-4')
     ->inputGrid('col-xs-10 col-md-8')
     ->value(SUBMIT);

$form->bindValues($_POST);

echo '
<div id="left_menu">
	<div id="left_menu_show" class="modal-content">
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
			<li><a href="#" '.$zoom.'>'.CUSTOM.'</a></li>
		</ul>
	</div>
	<div id="left_menu_graph_show" class="modal-content">'.$form.'</div>
	<img src="img/go-top.png" style="cursor:pointer" onclick="$(\'html, body\').animate({ scrollTop: 0 }, \'slow\');"  title="',GOTO_TOP_OF_PAGE,'" alt="Top" />
	<br />
	<img src="img/refresh.png" style="cursor:pointer" onclick="refresh_graph(\'dashboard\',\'\',\'\',\'\'); return false" title="',REFRESH,'" alt="Refresh" />
	<br />
	<img src="img/clock.png" style="cursor:pointer" onclick="$(\'#left_menu_show\').toggle(\'400\'); return false;" title="',TIME_SELECTOR,'" alt="Time Selector" />
	<br />
	<img src="img/config.png" style="cursor:pointer" onclick="$(\'#left_menu_graph_show\').toggle(\'400\'); return false;" title="',GRAPH_SIZE_SELECTOR,'" alt="Graph Size Selector" />
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
