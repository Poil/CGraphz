<?php

require_once 'Default.class.php';

class Type_Uptime extends Type_Default {

	function rrd_gen_graph() {
		$rrdgraph = $this->rrd_options();

		$sources = $this->rrd_get_sources();

		$i=0;
		foreach ($this->tinstances as $tinstance) {
			foreach ($this->data_sources as $ds) {
				$rrdgraph[] = sprintf('DEF:avg_%s=%s:%s:AVERAGE', crc32hex($sources[$i]), $this->parse_filename($this->files[$tinstance]), $ds);
				$rrdgraph[] = sprintf('DEF:max_%s=%s:%s:MAX', crc32hex($sources[$i]), $this->parse_filename($this->files[$tinstance]), $ds);

				$rrdgraph[] = sprintf('CDEF:c_avg_%s=avg_%1$s,86400,/', crc32hex($sources[$i]));
				$rrdgraph[] = sprintf('CDEF:c_max_%s=max_%1$s,86400,/', crc32hex($sources[$i]));

				$rrdgraph[] = sprintf('VDEF:v_avg_%s=c_avg_%1$s,AVERAGE', crc32hex($sources[$i]));
				$rrdgraph[] = sprintf('VDEF:v_max_%s=c_max_%1$s,MAXIMUM', crc32hex($sources[$i]));

				$i++;
			}
		}

		for ($i=count($sources)-1 ; $i>=0 ; $i--) {
			if ($i == (count($sources)-1))
				$rrdgraph[] = sprintf('CDEF:area_%s=c_avg_%1$s', crc32hex($sources[$i]));
			else
				$rrdgraph[] = sprintf('CDEF:area_%s=area_%s,c_avg_%1$s,+', crc32hex($sources[$i]), crc32hex($sources[$i+1]));
		}

		$c = 0;
		foreach ($sources as $source) {
			$color = is_array($this->colors) ? (isset($this->colors[$source])?$this->colors[$source]:$this->colors[$c++]) : $this->colors;
			$color = $this->get_faded_color($color);
			$rrdgraph[] = sprintf('AREA:area_%s#%s', crc32hex($source), $color);
		}

		$lengths = array_map('strlen', $sources);
		$max_src = max($lengths);
		$max_src = $max_src > MAX_LEGEND_LENGTH ? MAX_LEGEND_LENGTH : $max_src; 

		$lengths = array_map('strlen', $this->ds_names);
		$max_ds = max($lengths);
		$max_ds = $max_ds > MAX_LEGEND_LENGTH ? MAX_LEGEND_LENGTH : $max_ds;

		$c = 0;
		foreach ($sources as $source) {
			if (empty($this->ds_names[$source])) {
				//$dsname =  sprintf('%1$-'.$max_src.'s', $source);
				$dsname = sprintf('%1$-'.$max_src.'s',preg_replace('/\s+?(\S+)?$/u', '', mb_substr($source, 0, $max_src)));
			} else {
				//$dsname = sprintf('%1$-'.$max_ds.'s', $this->ds_names[$source]);
				$dsname = sprintf('%1$-'.$max_ds.'s',preg_replace('/\s+?(\S+)?$/u', '', mb_substr($this->ds_names[$source], 0, $max_ds)));
			}
			//$dsname = $this->ds_names[$source] != '' ? $this->ds_names[$source] : $source;
			$color = is_array($this->colors) ? (isset($this->colors[$source])?$this->colors[$source]:$this->colors[$c++]) : $this->colors;

			//current value
			$rrdgraph[] = sprintf('"LINE1:area_%s#%s:%s"', crc32hex($source), $this->validate_color($color), $this->rrd_escape($dsname));
			$rrdgraph[] = sprintf('"GPRINT:c_avg_%s:LAST:%s days\\l"', crc32hex($source), $this->rrd_format);

			//max value
			$rrdgraph[] = sprintf('"LINE1:v_max_%s#FF0000:Maximum:dashes"', crc32hex($source));
			$rrdgraph[] = sprintf('"GPRINT:v_max_%s:%s days\\l"', crc32hex($source), $this->rrd_format);

			//avg value
			$rrdgraph[] = sprintf('"LINE1:v_avg_%s#0000FF:Average:dashes"', crc32hex($source));
			$rrdgraph[] = sprintf('"GPRINT:v_avg_%s:%s days\\l"', crc32hex($source), $this->rrd_format);
		}

		return $rrdgraph;
	}
}

?>
