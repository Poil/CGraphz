<?php
$log = new LOG();	

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


