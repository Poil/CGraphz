<?php
	include(DIR_FSROOT.'/html/menu/time_selector.php');
 
	echo '<link rel="stylesheet" href="'.DIR_WEBROOT.'/modules/claranet/component/compare/lib/treeview/themes/proton/style.css" />';
	echo '<script src="'.DIR_WEBROOT.'/modules/claranet/component/compare/lib/treeview/jstree.js"></script>';
	echo '<link rel="stylesheet" href="'.DIR_WEBROOT.'/modules/claranet/component/compare/css/compare.css">';

	echo '<script type="text/javascript" src="'.DIR_WEBROOT.'/modules/claranet/component/compare/js/compare.js"> </script>';

//	$_GET['id_prj']=2275;

$c=new Compare($CONFIG);

if(isset($_GET['id_project'])){
	$id_prj=$_GET['id_project'];
}else if(isset($_GET['f_host'])){
	$id_prj=$c->getIdPrjFromHostname($_GET['f_host']);
}else{
	die();
}

?>
<div id="dashboard" style="margin-left : 0px;">
    <div id="dashboard_content" >
<?php
	
	$serverNames=$c->getServeur($id_prj);
    
	$withGraph=false;
	$srcGraph="";
    if(isset($_GET['p']) && isset($_GET['pc']) && isset($_GET['pi']) && isset($_GET['t']) && isset($_GET['tc'])){
        $withGraph=true;
		$srcGraph="&p=".$_GET['p']."&pc=".$_GET['pc']."&pi=".$_GET['pi']."&t=".$_GET['t']."&tc=".$_GET['tc'];
        if(empty($_GET['p'])) $_GET['p']="null";
        if(empty($_GET['pc'])) $_GET['pc']="null";
        if(empty($_GET['pi'])) $_GET['pi']="null";
        if(empty($_GET['t'])) $_GET['t']="null";
    }

	echo "<table id='servers' >
			<tr>";
				
	foreach($serverNames as $server_name){
		echo "<th><span class='serverName' value='".$server_name."'>".$server_name."</span><a href='#' onclick='removeHost($(this));return false;'>&nbsp;<i class='glyphicon glyphicon-remove'></i></a></th>";
	}
	echo "		<th><span class='serverName' value='patron-graph'></span></th>";
	echo '</tr>
			<tr style="display : none;">
				<td>';
	
	if (isset($time_start) && isset($time_end)) {
	    $zoom='onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\'\',\''.$time_start.'\',\''.$time_end.'\')"';
	} else {
		$zoom='onclick="Show_Popup($(this).attr(\'src\').split(\'?\')[1],\''.$time_range.'\',\'\',\'\')"';
	}
	// graph invisible servant simplement a retenir les timeranges
	if ($time_range!='') {
		echo '		<img class="imggraph imggraph-pattron" '.$zoom.' title="Click to Zoom" alt="rrd" src="/CGraphz/graph.php?h=&amp;p=&amp;pc=&amp;pi=&amp;t=&amp;tc=&amp;ti=&amp;s='.$time_range.'">';
	}else{
		echo '      <img class="imggraph imggraph-pattron" '.$zoom.' title="Click to Zoom" alt="rrd" src="/CGraphz/graph.php?h=&amp;p=&amp;pc=&amp;pi=&amp;t=&amp;tc=&amp;ti=&amp;s='.$time_start.'&amp;e='.$time_end.'">';
	}	
	echo '		</td>
			 </tr>
		</table>';
?>

    </div>
</div>


<div id="dashboard_menu">
	<div id="menu_left">
		<div class="jstree-spinner"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>&nbsp;Loading...</div> 
		<div id='plugin_choice' style="direction : ltr;" >
        </div> 
<script>
	var ajaxURL="<?php echo DIR_WEBROOT."/modules/claranet/component/compare/ajax/";?>";
	var pluginJs=[];
	
	$(function() {
		$.getJSON( '<?php echo DIR_WEBROOT."/modules/claranet/component/compare/ajax/initCompare.ajax.php?id_prj=".$id_prj.$srcGraph; ?>', function( data ) {
			pluginJs=data.pluginJs;
			$('.jstree-spinner').remove();
			$('#plugin_choice').jstree({
				'plugins': ["wholerow", "checkbox"],
				'core': {
					'data': data.jsonPlugin,
					'themes': {
						'name': 'proton',
						'responsive': true
					}
				}
			});
		});
<?php
	if($withGraph){
		echo "addGraphInit('".$_GET['p']."','".$_GET['pc']."','".$_GET['pi']."','".$_GET['t']."','".$_GET['tc']."');";
	}
?>
    });
	
    </script>
<?php
	echo "  </div>";
	echo "</div>";
	?>
</div>
