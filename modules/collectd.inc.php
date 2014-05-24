<?php

# generate identifier that collectd's FLUSH command understands
function collectd_identifier($host, $plugin, $pinst, $type, $tinst) {
	global $RRD;

	$identifier = sprintf('%s/%s%s%s/%s%s%s', $host,
		$plugin, strlen($pinst) ? '-' : '', $pinst,
		$type, strlen($tinst) ? '-' : '', $tinst);

	if (is_file($RRD['rrdroot_dir'].'/'.$identifier.'.rrd'))
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
	global $COLLECTD;

	if (!$COLLECT['socket'])
		return FALSE;

	if (!$identifier || (is_array($identifier) && count($identifier) == 0) ||
			!(is_string($identifier) || is_array($identifier)))
		return FALSE;

	if (!is_array($identifier))
		$identifier = array($identifier);

	$u_errno  = 0;
	$u_errmsg = '';
	if (! $socket = @fsockopen($COLLECTD['socket'], 0, $u_errno, $u_errmsg)) {
		error_log(sprintf('ERROR: Failed to open unix-socket to %s (%d: %s)',
			$COLLECTD['socket'], $u_errno, $u_errmsg));
		return FALSE;
	}

	if ($COLLECTD['flush_type'] == 'collectd'){
		$cmd = 'FLUSH';
		foreach ($identifier as $val)
			$cmd .= sprintf(' identifier="%s"', $val);
		$cmd .= "\n";
		socket_cmd($socket, $cmd);
	}
	elseif ($COLLECTD['flush_type'] == 'rrdcached') {
		foreach ($identifier as $val) {
			$cmd = sprintf("FLUSH %s.rrd\n", $val);
			socket_cmd($socket, $cmd);
		}
	}

	fclose($socket);

	return TRUE;
}

function parse_typesdb_file($file = '/usr/share/collectd/types.db') {
	if (!file_exists($file))
		$file = 'inc/types.db';

	$types = array();
	foreach (file($file) as $type) {
		if(!preg_match('/^(?P<dataset>[\w_]+)\s+(?P<datasources>.*)/', $type, $matches))
			continue;
		$dataset = $matches['dataset'];
		$datasources = explode(', ', $matches['datasources']);

		foreach ($datasources as $ds) {
			if (!preg_match('/^(?P<dsname>\w+):(?P<dstype>[\w]+):(?P<min>[\-\dU\.]+):(?P<max>[\dU\.]+)/', $ds, $matches))
				error_log(sprintf('CGP Error: DS "%s" from dataset "%s" did not match', $ds, $dataset));
			$types[$dataset][$matches['dsname']] = array(
					'dstype' => $matches['dstype'],
					'min' => $matches['min'],
					'max' => $matches['max'],
					);
		}
	}
	return $types;
}
