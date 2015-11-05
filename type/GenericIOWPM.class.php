<?php

require_once 'Base.class.php';

class Type_GenericIOWPM extends Type_Base {
	private $ds_names=array(
		'wpm_Time_namelookup',
		'wpm_Time_connect',
		'wpm_Time_starttransfer',
		'wpm_Time_total'
	);

	function rrd_gen_graph() {
		$rrdgraph = $this->rrd_options();

		$sources = $this->rrd_get_sources();

		$raw = null;
		if ($this->scale)
			$raw = '_raw';
		
		// Permet d'afficher seulement les graphes présent dans ds_names
		$new_sources=array();
		$i=0;
		foreach($this->ds_names as $rrd_name){
			if(in_array($rrd_name,$sources)){
				$new_sources[]=$rrd_name;
				$i++;
			}
		}
		$sources=array_reverse($new_sources);
		$this->tinstances=array_reverse($new_sources);
		// ajoute la definition du graphe d'erreur et du temps total
		$isCanvas=false;
		foreach($this->files as $file){
            if (basename($file,'.rrd')=='gauge-wpm_error'){
				// verifie si le rrd est en format canvas ou non
				if(!$isCanvas){
					$isCanvas=($file!=$this->parse_filename($file));
				}
//                $rrdgraph[] = sprintf('DEF:a=%s:%s:MAX', $this->parse_filename($file),'value');
                $rrdgraph[] = sprintf('DEF:a=%s:%s:AVERAGE', $this->parse_filename($file),'value');
            } elseif(basename($file,'.rrd')=='gauge-wpm_Time_total'){
                $rrdgraph[] = sprintf("DEF:b=%s:value:AVERAGE",$this->parse_filename($file),'value');
            }
        }
		$i=0;
		foreach ($this->tinstances as $tinstance) {
			foreach ($this->data_sources as $ds) {
//				$rrdgraph[] = sprintf('DEF:min_%s%s=%s:%s:MIN', crc32hex($sources[$i]), $raw, $this->parse_filename($this->files[$tinstance]), $ds);
				$rrdgraph[] = sprintf('DEF:avg_%s_raw=%s:%s:AVERAGE', crc32hex($sources[$i]), $this->parse_filename($this->files[$tinstance]), $ds);
//				$rrdgraph[] = sprintf('DEF:max_%s%s=%s:%s:MAX', crc32hex($sources[$i]), $raw, $this->parse_filename($this->files[$tinstance]), $ds);
				if (!$this->scale)
					$rrdgraph[] = sprintf('VDEF:tot_%s=avg_%1$s,TOTAL', crc32hex($sources[$i]));
				$i++;
			}
		}
		if ($this->scale) {
			$i=0;
			foreach ($this->tinstances as $tinstance) {
				foreach ($this->data_sources as $ds) {
//					$rrdgraph[] = sprintf('CDEF:min_%s=min_%1$s_raw,%s,*', crc32hex($sources[$i]), $this->scale);
					$rrdgraph[] = sprintf('CDEF:avg_%s=avg_%1$s_raw,%s,*', crc32hex($sources[$i]), $this->scale);
//					$rrdgraph[] = sprintf('CDEF:max_%s=max_%1$s_raw,%s,*', crc32hex($sources[$i]), $this->scale);
					if ($i == 1)
						$rrdgraph[] = sprintf('CDEF:avg_%s_neg=avg_%1$s_raw,%s%s,*', crc32hex($sources[$i]), $this->negative_io ? '-' : '', $this->scale);
					$rrdgraph[] = sprintf('VDEF:tot_%1$s=avg_%1$s,TOTAL', crc32hex($sources[$i]));
					$i++;
				}
			}
		}

		// ajoute les calculs du taux de dispo et affichage des maintenance, erreur et OK
		$rrdgraph[] = "CDEF:cdefa=a,0,EQ,INF,UNKN,IF";
        //$rrdgraph[] = "CDEF:cdefb=a,0.00001,EQ,INF,UNKN,IF";
        $rrdgraph[] = "CDEF:cdefb=a,0,GT,a,0.1,LT,*,INF,UNKN,IF";
        $rrdgraph[] = "CDEF:cdefcd=a,0.1,GT,INF,UNKN,IF";

		// Affichage des AREA pour les maintenance et OK
		$rrdgraph[] = 'AREA:cdefa#71FF067F';
        $rrdgraph[] = 'AREA:cdefb#7CB3F1FF';
	
		$i = 0;
		foreach($sources as $source) {
			$rrdgraph[] = sprintf('AREA:avg_%s%s#%s', crc32hex($source), $i == 1 ? '_neg' : '', $this->get_faded_color($this->colors[$source]));
			$i++;
		}

		$i = 0;
		foreach ($sources as $source) {
			$legend = empty($this->legend[$source]) ? $source : $this->legend[$source];
			$rrdgraph[] = sprintf('LINE1:avg_%s%s#%s:%s', crc32hex($source), $i == 1 ? '_neg' : '', $this->colors[$source], $this->rrd_escape($legend));
//			$rrdgraph[] = sprintf('GPRINT:min_%s:MIN:%s Min,', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('GPRINT:avg_%s:MIN:%s Min,', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('GPRINT:avg_%s:AVERAGE:%s Avg,', crc32hex($source), $this->rrd_format);
//			$rrdgraph[] = sprintf('GPRINT:max_%s:MAX:%s Max,', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('GPRINT:avg_%s:MAX:%s Max,', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('GPRINT:avg_%s:LAST:%s Last', crc32hex($source), $this->rrd_format);
			$rrdgraph[] = sprintf('GPRINT:tot_%s:%s Total\l',crc32hex($source), $this->rrd_format);
			$i++;
		}
/*
		// Calculs et affichage du taux de dispo
		$rrdgraph[] = "CDEF:cdefce=b,POP,TIME,PREV,UN,INF,PREV,IF,MIN";
        $rrdgraph[] = "CDEF:cdefcf=a,POP,TIME";
        $rrdgraph[] = "CDEF:cdefcg=a,POP,TIME,cdefce,-";

		$rrdgraph[] = "CDEF:cdefch=PREV(a),UN,0,PREV(a),IF,0.1,GT,PREV,UN,0,PREV,IF,cdefcf,UN,0,cdefcf,IF,PREV(cdefcf),UN,0,PREV(cdefcf),IF,-,ADDNAN,PREV,UN,0,PREV,IF,IF";

		$rrdgraph[] = "CDEF:dispo=1,cdefch,cdefcg,/,-,100,*";
        //$rrdgraph[] = 'GPRINT:dispo:LAST:Taux de disponibilite\: %5.1lf%s%%';
*/
		// Affichage du AREA pour les erreurs ( en dernier pour que le reste des graphes ne soient pas visibles )
        $rrdgraph[] = 'AREA:cdefcd#dd0000FF';

		return $rrdgraph;
	}
}

?>
