<?php

require_once 'Default.class.php';

class Type_GenericStacked extends Type_Default {

	function rrd_gen_graph() {
		$rrdgraph = $this->rrd_options();

		$sources = $this->rrd_get_sources();

		$raw = null;
		if ($this->scale) {
			$raw = '_raw';
		}
		$i=0;
		if ($this->tinstances) {
			foreach ($this->tinstances as $tinstance) {
				foreach ($this->data_sources as $ds) {
					$rrdgraph[] = sprintf('DEF:min_%s%s=%s:%s:MIN', crc32hex($sources[$i]), $raw, $this->parse_filename($this->files[$tinstance]), $ds);
					$rrdgraph[] = sprintf('DEF:avg_%s%s=%s:%s:AVERAGE', crc32hex($sources[$i]), $raw, $this->parse_filename($this->files[$tinstance]), $ds);
					$rrdgraph[] = sprintf('DEF:max_%s%s=%s:%s:MAX', crc32hex($sources[$i]), $raw, $this->parse_filename($this->files[$tinstance]), $ds);
					$i++;
				}
			}
		}
		if ($this->scale) {
			$i=0;
			foreach ($this->tinstances as $tinstance) {
				foreach ($this->data_sources as $ds) {
					$rrdgraph[] = sprintf('CDEF:min_%s=min_%1$s_raw,%s,*', crc32hex($sources[$i]), $this->scale);
					$rrdgraph[] = sprintf('CDEF:avg_%s=avg_%1$s_raw,%s,*', crc32hex($sources[$i]), $this->scale);
					$rrdgraph[] = sprintf('CDEF:max_%s=max_%1$s_raw,%s,*', crc32hex($sources[$i]), $this->scale);
					$i++;
				}
			}
		}

		for ($i=count($sources)-1 ; $i>=0 ; $i--) {
			if ($i == (count($sources)-1))
				$rrdgraph[] = sprintf('CDEF:area_%s=avg_%1$s', crc32hex($sources[$i]));
			else
				$rrdgraph[] = sprintf('CDEF:area_%s=area_%s,avg_%1$s,ADDNAN', crc32hex($sources[$i]), crc32hex($sources[$i+1]));
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
			//$dsname = empty($this->ds_names[$source]) ? $source : $this->ds_names[$source];
			$color = is_array($this->colors) ? (isset($this->colors[$source])?$this->colors[$source]:$this->colors[$c++]) : $this->colors;
			$rrdgraph[] = sprintf('"LINE1:area_%s#%s:%s"', crc32hex($source), $this->validate_color($color), ucfirst(str_replace('_', ' ',$this->rrd_escape($dsname))));
			$rrdgraph[] = sprintf('"GPRINT:min_%s:MIN:%s Min,"', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('"GPRINT:avg_%s:AVERAGE:%s Avg,"', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('"GPRINT:max_%s:MAX:%s Max,"', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('"GPRINT:avg_%s:LAST:%s Last\\l"', crc32hex($source), $this->rrd_format);
		}

		return $rrdgraph;
	}
}

?>
