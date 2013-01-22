<?php
session_name('CGRAPHZ');
session_start();

header('Content-type: application/json');
echo '{
	"time_start" : '.$_SESSION['time_start'].',
	"time_end" : '.$_SESSION['time_end'].'
}';
?>