<?php

# generate identifier that collectd's FLUSH command understands
function collectd_identifier($host, $plugin, $pinst, $type, $tinst) {
	global $CONFIG;

	$identifier = sprintf('%s/%s%s%s/%s%s%s', $host,
		$plugin, strlen($pinst) ? '-' : '', $pinst,
		$type, strlen($tinst) ? '-' : '', $tinst);

	if (is_file($CONFIG['datadir'].'/'.$identifier.'.rrd'))
		return $identifier;
	else
		return FALSE;
}

function socket_cmd($socket, $cmd) {
	$r = fwrite($socket, $cmd, strlen($cmd));
	if ($r === false || $r != strlen($cmd)) {
		error_log(sprintf('ERROR: Failed to write full command to unix-socket: %d out of %d written',
			$r === false ? -1 : $r, strlen($cmd)));
		return FALSE;
	}

	$resp = fgets($socket,128);
	if ($resp === false) {
		error_log(sprintf('ERROR: Failed to read response from collectd for command: %s',
			trim($cmd)));
		return FALSE;
	}

	$n = (int)$resp;
	while ($n-- > 0)
		fgets($socket,128);

	return TRUE;
}

# tell collectd to FLUSH all data of the identifier(s)
function collectd_flush($identifier) {
	global $CONFIG;

	if (!$CONFIG['socket'])
		return FALSE;

	if (!$identifier || (is_array($identifier) && count($identifier) == 0) ||
			!(is_string($identifier) || is_array($identifier)))
		return FALSE;

	if (!is_array($identifier))
		$identifier = array($identifier);

	$u_errno  = 0;
	$u_errmsg = '';
	if (! $socket = @fsockopen($CONFIG['socket'], 0, $u_errno, $u_errmsg)) {
		error_log(sprintf('ERROR: Failed to open unix-socket to %s (%d: %s)',
			$CONFIG['socket'], $u_errno, $u_errmsg));
		return FALSE;
	}

	if ($CONFIG['flush_type'] == 'collectd'){
		$cmd = 'FLUSH';
		foreach ($identifier as $val)
			$cmd .= sprintf(' identifier="%s"', $val);
		$cmd .= "\n";
		socket_cmd($socket, $cmd);
	}
	elseif ($CONFIG['flush_type'] == 'rrdcached') {
		foreach ($identifier as $val) {
			$cmd = sprintf("FLUSH %s.rrd\n", $val);
			socket_cmd($socket, $cmd);
		}
	}

	fclose($socket);

	return TRUE;
}

