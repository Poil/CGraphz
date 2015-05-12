<?php

# global functions

function GET($index) {
	if (isset($_GET[$index]))
		return $_GET[$index];
	return null;
}

function validate_get($value, $type) {
	switch($type) {
		case 'host':
			if (!preg_match('/^[\w-.:]+$/u', $value))
				return NULL;
		break;
		case 'plugin':
		case 'type':
			if (!preg_match('/^\w+$/u', $value))
				return NULL;
		break;
		case 'pinstance':
		case 'tinstance':
			if (!preg_match('/^[\w-]+$/u', $value))
				return NULL;
		break;
	}

	return $value;
}

function validateRRDPath($base,$path) {
	$base=preg_replace('{/$}','',$base);
	if (is_link($base)) {
		$base=realpath($base);
	}

	$realpath = realpath(sprintf('%s/%s', $base, $path));

	if (strpos($realpath, $base) === false)
		return false;

	if (strpos($realpath, $base) !== 0)
		return false;

	if (!preg_match('/\.rrd$/', $realpath))
		return false;

	return $realpath;
}

function crc32hex($str) {
	return sprintf("%x",crc32($str));
}

function error_image($text="[ERROR] Permission denied") {
	global $CONFIG;
	$width=$CONFIG['width']+98;
	$height=$CONFIG['height']+72;

	header("Content-Type: image/png", true, 400);
	// Création de l'image
	$im = imagecreatetruecolor($width, $height);
	
	// Création de quelques couleurs
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 0, 0, 0);

	imagefilledrectangle($im, 0, 0, $width, $height, $grey);
	imagefilledrectangle($im, 1, 1, ($width-2), ($height-2), $white);
	
	// Remplacez le chemin par votre propre chemin de police
	$font = DIR_FSROOT.'/fonts/UbuntuMono-R.ttf';
	
	// Ajout du texte
	imagettftext($im, 12, 0, 10, 20, $black, $font, $text);
	
	// Utiliser imagepng() donnera un texte plus claire,
	// comparé à l'utilisation de la fonction imagejpeg()
	imagepng($im);
	imagedestroy($im);
	exit;
}

function is_blank($value) {
	return empty($value) && !is_numeric($value);
}

function sort_plugins($hostpath, $plugins, $filters) {
	$plugins_ordered = array();
	$i=0;
	foreach ($plugins as $plugin) {
		foreach ($filters as $filter) {
			$myregex='#^('.$hostpath.'/)('.$filter->plugin.')(?:\-('.$filter->plugin_instance.'))?/('.$filter->type.')(?:\-('.$filter->type_instance.'))?\.rrd#';
			if (preg_match($myregex, $plugin)) {
				$plugins_ordered[$i]['index']=$filter->plugin_order;
				$plugins_ordered[$i]['content']=$plugin;
				break;
			}
		}
		if (empty($plugins_ordered[$i]['index'])) {
			$plugins_ordered[$i]['index']=99999;
			$plugins_ordered[$i]['content']=$plugin;
		}
		$i++;
	}
	asort($plugins_ordered);
	return $plugins_ordered;
}

function gen_title($h, $p, $pc, $pi, $t, $tc, $ti) {
	global $CONFIG;

	$auth = new AUTH_USER();
	$log = new LOG();	
	
	if (!$auth->verif_auth()) {
		echo 'Error auth'; 
		die();
	}
				
	if (strpos($h,':')!=FALSE) {
		$tmp=explode(':',$h);
		$h=$tmp[0];
	}
	
	if (!$authorized=$auth->check_access_right($h)) {
		$log->write('CGRAPHZ ERROR: Permission denied for host : '.$h);
		echo 'Error host';
		die();
	}
	
	if (validate_get($h, 'host') === NULL) {
		$log->write('CGRAPHZ ERROR: host contains unknown characters');
		echo 'Error char';
		die();
	}
	
	if ($p == 'aggregation') {
		$p = $pc;
	}

    if (preg_match($CONFIG['plugin_tcategory'], $p) && !empty($tc)) {
      $t_orig=$t;
      $t = $t.'-'.$tc;
    }
	
	# plugin json
	if (function_exists('json_decode') && file_exists('plugin/'.$p.'-'.$pi.'.json')) {
		$json = file_get_contents('plugin/'.$p.'-'.$pi.'.json');
		$plugin_json = json_decode($json, true);
		
		if (is_null($plugin_json))
			$log->write('CGP Error: invalid json in plugin/'.$p.'.json');
	} else if (function_exists('json_decode') && file_exists('plugin/'.$p.'-'.$pc.'.json')) {
		$json = file_get_contents('plugin/'.$p.'-'.$pc.'.json');
		$plugin_json = json_decode($json, true);
		
		if (is_null($plugin_json))
			$log->write('CGP Error: invalid json in plugin/'.$p.'.json');
	} else if (function_exists('json_decode') && file_exists('plugin/'.$p.'-'.$pc.'-'.$pi.'.json')) {
		$json = file_get_contents('plugin/'.$p.'-'.$pc.'-'.$pi.'.json');
		$plugin_json = json_decode($json, true);
		
		if (is_null($plugin_json))
			$log->write('CGP Error: invalid json in plugin/'.$p.'.json');
	} else {
		if (function_exists('json_decode') && file_exists('plugin/'.$p.'.json')) {
			$json = file_get_contents('plugin/'.$p.'.json');
			$plugin_json = json_decode($json, true);
		
			if (is_null($plugin_json))
				$log->write('CGP Error: invalid json in plugin/'.$p.'.json');
		} else {
		        $log->write(sprintf('CGRAPHZ ERROR: plugin "%s" is not available', $p));
		}
	}
	if (isset($plugin_json[$t]['title'])) {
		$rrd_title = $plugin_json[$t]['title'];
		$replacements = array(
			'{{PI}}' => $pi,
			'{{PC}}' => $pc,
			'{{TI}}' => $ti,
			'{{TC}}' => $tc,
			'{{HOST}}' => $h
		);
		$rrd_title = str_replace(array_keys($replacements), array_values($replacements), $rrd_title);
	} else if (array_key_exists($t, $plugin_json) and $plugin_json[$t]['type']=='iowpm') {
		foreach (getAllDatadir() as $key => $value) {
			if (file_exists($value.'/'.$h.'/'.$p.'-'.$pi.'/ItemName.txt')) {
				$ItemName=file_get_contents($value.'/'.$h.'/'.$p.'-'.$pi.'/ItemName.txt');
				continue;
			}
		}
		$rrd_title = isset($ItemName) ? "$ItemName on $h" : "$pi on $h";
	} else {
		$rrd_title = "$h $p $pc $pi $ti $tc";
	}
	return $rrd_title;
}

function getAllDatadir(){
	global $CONFIG;
	return array_map(function($item) { return $item['rrd_path']; }, $CONFIG['datadir']);
}

function getDatadirEntry($rrd_path) {
	global $CONFIG;
	foreach ($CONFIG['datadir'] as $key => $value) {
		if (is_array($value) && strpos($rrd_path, $value['rrd_path']) !== false) {
			return $key;
		}
	}
}

