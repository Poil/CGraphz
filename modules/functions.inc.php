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
			if (!preg_match('/^[\d\w\W]+$/u', $value))
				return NULL;
		break;
		case 'plugin':
		case 'type':
			if (!preg_match('/^\w+$/u', $value))
				return NULL;
		break;
		case 'pinstance':
		case 'tinstance':
			if (!preg_match('/^[\d\w-]+$/u', $value))
				return NULL;
		break;
	}

	return $value;
}

function validateRRDPath($base, $path) {
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

	header("Content-Type: image/png");
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
?>
