<?php
session_name('CGRAPHZ');
session_start();

header('Content-type: application/json');
$time_start = (!empty($_SESSION['time_start']) ? $_SESSION['time_start'] : null);
$time_end = (!empty($_SESSION['time_end']) ? $_SESSION['time_end'] : null);
echo '{
	"time_start" : '.$time_start.',
	"time_end" : '.$time_end.'
}';
?>
