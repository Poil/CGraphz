<?php

# Collectd Default type

class Type_Base {
	var $datadir;
	var $rrdtool;
	var $rrdtool_opts = array();
	var $cache;
	var $args;
	var $seconds;
	var $seconds_end;
	var $data_sources = array('value');
	var $order;
	var $legend = array();
	var $colors = array();
	var $rrd_title;
	var $rrd_vertical;
	var $rrd_format = '%5.1lf%s';
	var $scale = 1;
	var $base;
	var $width;
	var $height;
	var $graph_type;
	var $negative_io;
	var $percentile = false;
	var $graph_smooth;
	var $graph_minmax;

	var $files;
	var $tinstances;
	var $identifiers;

	var $flush_socket;
	var $flush_type;
	var $flush_path;

	function __construct($config, $_get, $pluginconfig) {
		$this->log = new LOG();
		$this->datadir = $pluginconfig['rrd_path'];
		if (!empty($pluginconfig['flush_path'])) {
			$this->flush_path = $pluginconfig['flush_path'];
		}
		$this->rrdtool = $config['rrdtool'];
		if (!empty($config['rrdtool_opts'])) {
			if (is_array($config['rrdtool_opts'])) {
				$this->rrdtool_opts = $config['rrdtool_opts'];
			} else {
				$this->rrdtool_opts = explode(' ', $config['rrdtool_opts']);
			}
		}
		$this->cache = $config['cache'];
		$this->parse_get($_get);
		$this->rrd_title = sprintf(
			'%s%s%s%s',
			$this->args['plugin'],
			$this->args['type'] != $this->args['plugin']
				? sprintf(' %s', str_replace('"','',$this->args['type']))
				: '',
			(isset($this->args['pinstance']) and $this->args['pinstance'] != '')
				? sprintf(' (%s)', str_replace('"','',$this->args['pinstance']))
				: '',
			(isset($this->args['pcategory']) and $this->args['pcategory'] != '')
				? sprintf(' (%s)', str_replace('"','',$this->args['pcategory']))
				: ''
		);
		$this->rrd_files();
		$this->width = isset($_get['x']) ? $_get['x'] : $config['width'];
		$this->height = isset($_get['y']) ? $_get['y'] : $config['height'];
		$this->graph_type = isset($_get['graph_type']) ? $_get['graph_type'] : $config['graph_type'];
		$this->negative_io = $config['negative_io'];
		$this->graph_smooth = $config['graph_smooth'];
		$this->graph_minmax = $config['graph_minmax'];
		$this->flush_socket = $pluginconfig['socket'];
		$this->flush_type = $pluginconfig['flush_type'];
	}

	function rainbow_colors() {
		$c = 0;
		$sources = count($this->rrd_get_sources());
		foreach ($this->rrd_get_sources() as $ds) {
			# hue (saturnation=1, value=1)
			$h = $sources > 1 ? 360 - ($c * (330/($sources-1))) : 360;

			$h = ($h %= 360) / 60;
			$f = $h - floor($h);
			$q[0] = $q[1] = 0;
			$q[2] = 1*(1-1*(1-$f));
			$q[3] = $q[4] = 1;
			$q[5] = 1*(1-1*$f);

			$hex = '';
			foreach(array(4,2,0) as $j) {
				$hex .= sprintf('%02x', $q[(floor($h)+$j)%6] * 255);
			}
			$this->colors[$ds] = $hex;
			$c++;
		}
	}

	# parse $_GET values
	function parse_get($_get) {
		$this->args = array(
			'host' => isset($_get['h']) ? $_get['h'] : null,
			'plugin' => isset($_get['p']) ? $_get['p'] : null,
			'pcategory' => isset($_get['pc']) ? $_get['pc'] : null,
			'pinstance' => isset($_get['pi']) ? $_get['pi'] : null,
			'tcategory' => isset($_get['tc']) ? $_get['tc'] : null,
			'type' => isset($_get['t']) ? $_get['t'] : null,
			'tinstance' => isset($_get['ti']) ? $_get['ti'] : null,
		);
		$this->seconds = isset($_get['s']) ? $_get['s'] : null;
		$this->seconds_end = isset($_get['e']) ? $_get['e'] : null;
	}

	function validate_color($color) {
		if (!preg_match('/^[0-9a-f]{6}$/', $color))
			return '000000';
		else
			return $color;
	}

	function get_faded_color($fgc, $bgc='ffffff', $percent=0.25) {
		$fgc = $this->validate_color($fgc);
		if (!is_numeric($percent))
			$percent=0.25;

		$rgb = array('r', 'g', 'b');

		$fg['r'] = hexdec(substr($fgc,0,2));
		$fg['g'] = hexdec(substr($fgc,2,2));
		$fg['b'] = hexdec(substr($fgc,4,2));
		$bg['r'] = hexdec(substr($bgc,0,2));
		$bg['g'] = hexdec(substr($bgc,2,2));
		$bg['b'] = hexdec(substr($bgc,4,2));

		foreach ($rgb as $pri) {
			$c[$pri] = dechex(round($percent * $fg[$pri]) + ((1.0 - $percent) * $bg[$pri]));
			if ($c[$pri] == '0')
				$c[$pri] = '00';
		}

		return $c['r'].$c['g'].$c['b'];
	}

	function rrd_escape($value) {
		# In case people have really bizarre URLs in $CONFIG['rrd_url'],
		# it should not be dropped.
		$value = str_replace('\\', '\\\\', $value);
		# http://oss.oetiker.ch/rrdtool/doc/rrdgraph_graph.en.html#IEscaping_the_colon
		return str_replace(':', '\:', $value);
	}

	function parse_filename($file) {
		if ($this->graph_type == 'canvas') {
			$file = str_replace($this->datadir . '/', '', $file);
			# rawurlencode all but /
			$file = str_replace('%2F', '/', rawurlencode($file));
			$file = DIR_WEBROOT.'/rrd.php/'.getDatadirEntry($this->datadir).'/' . $file;
		}
		return $this->rrd_escape($file);
	}

	function rrd_files() {
		$files = $this->get_filenames();
		$this->tinstances = array();
		$this->files = array();
		$this->identifiers = array();

		$datadir_prefix = preg_quote($this->datadir, '#');
		foreach($files as $filename) {
			$basename=basename($filename,'.rrd');
			$instance = strpos($basename,'-')
				? substr($basename, strpos($basename,'-') + 1)
				: 'value';

			$this->tinstances[] = $instance;
			$this->files[$instance] = $filename;
			$this->identifiers[$instance] = preg_replace(
				"#^{$datadir_prefix}/(.*)\.rrd$#", '$1',
				$filename);
		}

		sort($this->tinstances);
		ksort($this->files);
		ksort($this->identifiers);
	}

	function get_filenames() {
		$identifier = sprintf('%s/%s%s%s/%s%s%s',
			$this->args['host'],
			$this->args['plugin'],
			strlen($this->args['pcategory']) ? '-'.$this->args['pcategory'] : '',
			strlen($this->args['pinstance']) ? '-'.$this->args['pinstance'] : '',
			$this->args['type'],
			strlen($this->args['tcategory']) ? '-'.$this->args['tcategory'] : '',
			(!strlen($this->args['tcategory']) && strlen($this->args['tinstance'])) ? '-'.$this->args['tinstance'].'' : ''
		);
		$identifier = preg_replace("/([*?[])/", '[$1]', $identifier);

		$wildcard = strlen($this->args['tinstance']) ? '.' : '[-.]*';
		
		$files = glob($this->datadir .'/'. $identifier . $wildcard . 'rrd');
		
		return $files ? $files : array();
	}

	function rrd_graph($debug = false) {
		$this->collectd_flush();

		$colors = $this->colors;
		$this->rainbow_colors();
		$this->colors = $colors + $this->colors;

		$graphoptions = $this->rrd_gen_graph();
		# $shellcmd contains escaped rrdtool arguments
		$shellcmd = array();
		foreach ($graphoptions as $arg)
			$shellcmd[] = escapeshellarg($arg);

		$style = $debug !== false ? $debug : $this->graph_type;
		switch ($style) {
			case 'cmd':
				print '<pre>';
				foreach ($shellcmd as $d) {
					printf("%s \\\n", $d);
				}
				print '</pre>';
			break;
			case 'canvas':
				printf('<canvas id="%s" class="rrd">', sha1(serialize($graphoptions)));
				foreach ($graphoptions as $d) {
					printf("\"%s\"\n", htmlentities($d));
				}
				print '</canvas>';
			break;
			case 'debug':
			case 1:
				print '<pre>';
				print htmlentities(print_r($shellcmd, TRUE));
				print '</pre>';
			break;
			case 'svg':
			case 'png':
			default:
				# caching
				if (is_numeric($this->cache) && $this->cache > 0)
					header("Expires: " . date(DATE_RFC822,strtotime($this->cache." seconds")));
				if ($style === 'svg')
					header("content-type: image/svg+xml");
				else
					header("content-type: image/png");
				
				$shellcmd = array_merge(
					$this->rrd_graph_command($style),
					$shellcmd
				);
				$shellcmd = implode(' ', $shellcmd);
				passthru($shellcmd, $exitcode);
				if ($exitcode !== 0) {
					header('HTTP/1.1 500 Internal Server Error');
				}
			break;
		}
	}
	
	function rrd_graph_command($imgformat) {
		if (!in_array($imgformat, array('png', 'svg')))
			$imgformat = 'png';
		
		return array(
			$this->rrdtool,
			'graph',
			'-',
			'-a', strtoupper($imgformat)
		);
	}	

	function rrd_options() {
		$rrdgraph = array();
		foreach($this->rrdtool_opts as $opt)
			$rrdgraph[] = $opt;
		if ($this->graph_smooth)
			$rrdgraph[] = '-E';
		if ($this->base) {
			$rrdgraph[] = '--base';
			$rrdgraph[] = $this->base;
		}
		$rrdgraph = array_merge($rrdgraph, array(
			'-w', is_numeric($this->width) ? $this->width : 400,
			'-h', is_numeric($this->height) ? $this->height : 175,
			'-t', $this->rrd_title
		));

		if (!array_search('-l',$rrdgraph)) {
			$rrdgraph[] = '-l';
			$rrdgraph[] = '0';
		}

		if (GRAPH_TITLE=='text' && $this->graph_type=='png') {
			$rrdgraph[] = '--border';
			$rrdgraph[] = '0';
		}

		if ($this->rrd_vertical) {
			$rrdgraph[] = '-v';
			$rrdgraph[] = $this->rrd_vertical;
		}

		$rrdgraph[] = '-s';
		if ($this->seconds_end == "") {
			$rrdgraph[] = sprintf(' e-%d', is_numeric($this->seconds) ? $this->seconds : 86400);
		} else {
			$rrdgraph[] = is_numeric($this -> seconds) ? $this -> seconds : 'now-86400';
			$rrdgraph[] = '-e';
			$rrdgraph[] = is_numeric($this -> seconds_end) ? $this -> seconds_end : 'now';
			//$rrdgraph[] = sprintf(' %s -e %s', is_numeric($this -> seconds) ? $this -> seconds : 'now-86400', is_numeric($this -> seconds_end) ? $this -> seconds_end : 'now');
		}

		return $rrdgraph;
	}

	function rrd_get_sources() {
		# is the source spread over multiple files?
		if (is_array($this->files) && count($this->files)>1) {
			# and must it be ordered?
			if (is_array($this->order)) {
				$this->tinstances = array_merge(array_unique(array_merge(array_intersect($this->order, $this->tinstances), $this->tinstances)));
			}
			# use tinstances as sources
			if(is_array($this->data_sources) && count($this->data_sources)>1) {
				$sources = array();
				foreach($this->tinstances as $f) {
					foreach($this->data_sources as $s) {
						$sources[] = $f . '-' . $s;
					}
				}
			}
			else {
				$sources = $this->tinstances;
			}
		}
		# or one file with multiple data_sources
		else {
			if(is_array($this->data_sources) && count($this->data_sources)==1 && in_array('value', $this->data_sources)) {
				# use tinstances as sources
				$sources = $this->tinstances;
			} else {
				# use data_sources as sources
				if (is_array($this->order)) {
					$sources = array_intersect($this->order,$this->data_sources);
				} else {
					$sources = $this->data_sources;
				}
				$this->data_sources = $sources;
			}
		}
		$this->parse_legend($sources);
		return $sources;
	}

	function parse_legend($sources) {
		# fill up legend by items that are not defined by plugin
		$this->legend = $this->legend + array_combine($sources, $sources);
		
		# detect length of longest legend
		$max = 0;
		foreach ($this->legend as $legend) {
			if(strlen((string)$legend) > $max)
				$max = strlen((string)$legend);
		}

		# make all legend equal in lenght
		$format = sprintf("%%-%ds", $max);
		foreach ($this->legend as $index => $value) {
			$this->legend[$index] = sprintf($format, $value);
		}
	}

	function socket_cmd($socket, $cmd) {
		$r = fwrite($socket, $cmd, strlen($cmd));
		if ($r === false || $r != strlen($cmd)) {
			$this->log->write(sprintf('ERROR: Failed to write full command to unix-socket: %d out of %d written',
				$r === false ? -1 : $r, strlen($cmd)));
			return FALSE;
		}

		$resp = fgets($socket,128);
		if ($resp === false) {
			$this->log->write(sprintf('ERROR: Failed to read response from collectd for command: %s',
				trim($cmd)));
			return FALSE;
		}

		$n = (int)$resp;
		while ($n-- > 0)
			fgets($socket,128);

		return TRUE;
	}

	# tell collectd to FLUSH all data of the identifier(s)
	function collectd_flush($debug=false) {
		$identifier = $this->identifiers;
		if ($debug == true) { $this->log->write('[Flush] - Socket: '.$this->flush_socket.' - Identifiers : '.join($identifier,' -- ')); }
		
		if (!$this->flush_socket)
			return FALSE;

		if (!$identifier || (is_array($identifier) && count($identifier) == 0) ||
				!(is_string($identifier) || is_array($identifier)))
			return FALSE;

		if (!is_array($identifier))
			$identifier = array($identifier);

		$u_errno  = 0;
		$u_errmsg = '';
		if (! $socket = @fsockopen($this->flush_socket, 0, $u_errno, $u_errmsg)) {
			$this->log->write(sprintf('ERROR: Failed to open unix-socket to %s (%d: %s)',
				$this->flush_socket, $u_errno, $u_errmsg));
			return FALSE;
		}

		if ($this->flush_type == 'collectd'){
			$cmd = 'FLUSH';
			foreach ($identifier as $val)
				$cmd .= sprintf(' identifier="%s"', $val);
			$cmd .= "\n";
			$this->socket_cmd($socket, $cmd);
		}
		elseif ($this->flush_type == 'rrdcached') {
			foreach ($identifier as $val) {
				$val = str_replace(' ', '\ ', $val);
				$cmd = sprintf("FLUSH %s.rrd\n", $this->flush_path.'/'.$val);
				if ($debug == true) { $this->log->write('[Flush] - Commands : FLUSH '.$this->flush_path.'/'.$val.'.rrd'); }
				$this->socket_cmd($socket, $cmd);
			}
		}

		fclose($socket);

		return TRUE;
	}
}

