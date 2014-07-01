<?php
$log = new LOG();	

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

function parse_typesdb_file($file) {
	global $log;
	
	if (!is_array($file))
		$file = array($file);
	if (!file_exists($file[0]))
		$file = 'inc/types_collectd_5.db';

	$types = array();
	foreach ($file as $single_file) {
		if (!file_exists($single_file))
			continue;
		foreach (file($single_file) as $type) {
			if(!preg_match('/^(?P<dataset>[\w_]+)\s+(?P<datasources>.*)/', $type, $matches))
				continue;
			$dataset = $matches['dataset'];
			$datasources = explode(', ', $matches['datasources']);
	
			foreach ($datasources as $ds) {
				if (!preg_match('/^(?P<dsname>\w+):(?P<dstype>[\w]+):(?P<min>[\-\dU\.]+):(?P<max>[\dU\.]+)/', $ds, $matches))
					$log->write(sprintf('CGP Error: DS "%s" from dataset "%s" did not match', $ds, $dataset));
				$types[$dataset][$matches['dsname']] = array(
						'dstype' => $matches['dstype'],
						'min' => $matches['min'],
						'max' => $matches['max'],
						);
			}
		}
	}
	return $types;
}
