<?php

require_once 'Base.class.php';

class Type_GenericAggregation extends Type_Base {
    function rrd_files(){
        $files=array();

        $rep=$this->datadir."/".$this->args['host']."/";
        $files=glob($rep."cpu*/*.rrd");

        $this->tinstances = array();
        $this->files = array();
        $this->identifiers = array();

        $datadir_prefix = preg_quote($this->datadir, '#');
        foreach($files as $filename) {
            $basename=basename($filename,'.rrd');
            $instance = strpos($basename,'-')
                ? substr($basename, strpos($basename,'-') + 1)
                : 'value';
            if(!in_array($instance,$this->tinstances)) $this->tinstances[] = $instance;
            $this->files[$instance] = $filename;
            $this->identifiers[$instance]=$basename;
        }

        $this->files=glob($rep."cpu*/");

        sort($this->tinstances);
        ksort($this->files);
        ksort($this->identifiers);

    }

    function rrd_gen_graph() {
        $rrdgraph = $this->rrd_options();

        $sources = $this->rrd_get_sources();

        $raw = null;
        if ($this->scale)
            $raw = '_raw';
        $i=0;

        foreach ($this->tinstances as $tinstance) {
            foreach ($this->data_sources as $ds) {
                $num_f=0;
                foreach($this->files as $pathrrd){
                    $rrdgraph[] = sprintf('DEF:min_%s_%s%s=%s:%s:MIN', crc32hex($sources[$i]),$num_f, $raw, $this->parse_filename($pathrrd.$this->identifiers[$tinstance].".rrd"), $ds);
                    $rrdgraph[] = sprintf('DEF:avg_%s_%s%s=%s:%s:AVERAGE', crc32hex($sources[$i]),$num_f, $raw, $this->parse_filename($pathrrd.$this->identifiers[$tinstance].".rrd"), $ds);
                    $rrdgraph[] = sprintf('DEF:max_%s_%s%s=%s:%s:MAX', crc32hex($sources[$i]),$num_f, $raw, $this->parse_filename($pathrrd.$this->identifiers[$tinstance].".rrd"), $ds);
                    $num_f++;
                }
                $i++;
            }
        }

        if ($this->scale) {
            $i=0;
            foreach ($this->tinstances as $tinstance) {
                foreach ($this->data_sources as $ds) {
                    $num_f=0;
                    foreach($this->files as $pathrrd){
                        $rrdgraph[] = sprintf('CDEF:min_%s_%s=min_%1$s_%2$s_raw,%s,*', crc32hex($sources[$i]), $num_f, $this->scale);
                        $rrdgraph[] = sprintf('CDEF:avg_%s_%s=avg_%1$s_%2$s_raw,%s,*', crc32hex($sources[$i]), $num_f, $this->scale);
                        $rrdgraph[] = sprintf('CDEF:max_%s_%s=max_%1$s_%2$s_raw,%s,*', crc32hex($sources[$i]), $num_f, $this->scale);
                        $num_f++;
                    }
                    $i++;
                }
            }
        }


        $i=0;
        foreach ($this->tinstances as $tinstance) {
            foreach ($this->data_sources as $ds) {
                $num_f=0;
                $cdef_min="";
                $cdef_avg="";
                $cdef_max="";
                foreach($this->files as $pathrrd){
                    if($num_f>0){
                        $cdef_min.=",";
                        $cdef_avg.=",";
                        $cdef_max.=",";
                    }
                    $cdef_min.=sprintf("min_%s_%s", crc32hex($sources[$i]), $num_f);
                    $cdef_avg.=sprintf("avg_%s_%s", crc32hex($sources[$i]), $num_f);
                    $cdef_max.=sprintf("max_%s_%s", crc32hex($sources[$i]), $num_f);
                    if($num_f>0){
                        $cdef_min.=",+";
                        $cdef_avg.=",+";
                        $cdef_max.=",+";
                    }
                    $num_f++;
                }
                if($num_f>1){
                    $rrdgraph[] = sprintf('CDEF:min_%s=%s,%s,/', crc32hex($sources[$i]), $cdef_min,$num_f);
                    $rrdgraph[] = sprintf('CDEF:avg_%s=%s,%s,/', crc32hex($sources[$i]), $cdef_avg,$num_f);
                    $rrdgraph[] = sprintf('CDEF:max_%s=%s,%s,/', crc32hex($sources[$i]), $cdef_max,$num_f);
                }else{
                    $rrdgraph[] = sprintf('CDEF:min_%s=min_%1$s_0', crc32hex($sources[$i]));
                    $rrdgraph[] = sprintf('CDEF:avg_%s=avg_%1$s_0', crc32hex($sources[$i]));
                    $rrdgraph[] = sprintf('CDEF:max_%s=max_%1$s_0', crc32hex($sources[$i]));
                }
                $i++;
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

        $c = 0;
        foreach ($sources as $source) {
            $legend = empty($this->legend[$source]) ? $source : $this->legend[$source];
            $color = is_array($this->colors) ? (isset($this->colors[$source])?$this->colors[$source]:$this->colors[$c++]) : $this->colors;
            $rrdgraph[] = sprintf('LINE1:area_%s#%s:%s', crc32hex($source), $this->validate_color($color), $this->rrd_escape($legend));
            $rrdgraph[] = sprintf('GPRINT:min_%s:MIN:%s Min,', crc32hex($source), $this->rrd_format);
            $rrdgraph[] = sprintf('GPRINT:avg_%s:AVERAGE:%s Avg,', crc32hex($source), $this->rrd_format);
            $rrdgraph[] = sprintf('GPRINT:max_%s:MAX:%s Max,', crc32hex($source), $this->rrd_format);
            $rrdgraph[] = sprintf('GPRINT:avg_%s:LAST:%s Last\\l', crc32hex($source), $this->rrd_format);
        }

        return $rrdgraph;
    }
}

?>
