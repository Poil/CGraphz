<?php
function select_template($name, $id, $table, $row_display, $row_value, $selected='', $js_func='') {
    $lib='
        SELECT
            '.$row_display.' AS row_display,
            '.$row_value.' AS row_value
        FROM
            '.$table.'
        GROUP BY
            row_display,
            row_value
        ORDER by
            row_display,
            row_value';
    //echo $lib;
    $connSQL=new DB();
    $res=$connSQL->query($lib);
    $cpt_res=count($res);

    $s='<select name="'.$name.'" id="'.$id.'"';
    if ($js_func!='') {
        $s.=' '.$js_func.' ';
    }
    $s.='>';
    $s.='<option value=""></option>';

    for ($i=0; $i<$cpt_res; $i++) {
        $s.='<option value="'.$res[$i]->row_value.'">'.$res[$i]->row_display.'</option>';
    }
    $s.='</select>';

    return $s;
}


function select_count_template($name, $id, $table, $row_value, $selected='', $js_func='') {
    $lib='
        SELECT
            '.$row_value.' AS row_value
        FROM
            '.$table.'
        GROUP BY
            row_value
        ORDER by
            row_value';

    //echo $lib;
    $connSQL=new DB();
    $res=$connSQL->row($lib);

    $s='<select name="'.$name.'" id="'.$id.'"';
    if ($js_func!='') {
        $s.=' onchange="'.$js_func.'"';
    }
    $s.='>';

    for ($i=0; $i<=$res->row_value; $i++) {
        $s.='<option value="'.$i.'">'.$i.'</option>';
    }
    $s.='</select>';

    return $s;
}


function options_template($table, $row_display, $row_value, $filter='', $typefilter='') {

    if ($filter!='' && $typefilter!='') {
        $lib='
            SELECT
                '.$row_display.' AS row_display,
                '.$row_value.' AS row_value,
                '.$typefilter.'('.$filter.') AS filter_value
            FROM
                '.$table.'
            GROUP BY
                row_display
            ORDER BY
                row_display';

    } else {
        $lib='
            SELECT
                '.$row_display.' AS row_display,
                '.$row_value.' AS row_value
            FROM
                '.$table.'
            GROUP BY
                row_display,
                row_value
            ORDER by
                row_display,
                row_value';
    }
    $connSQL=new DB();
    $res=$connSQL->query($lib);
    $cpt_res=count($res);

    $s='[';
    $s.='{optionValue:'.php2js('').', optionDisplay:'.php2js('').'},';
    for ($i=0; $i<$cpt_res; $i++) {
        $s.='{optionValue:'.php2js($res[$i]->row_value).', optionDisplay:'.php2js($res[$i]->row_display).'}';
        if ($i+1<$cpt_res) $s.=', ';
    }
    $s.=']';

    return $s;
}

function options_count_template($table, $row_value) {
    $lib='
        SELECT
            '.$row_value.' AS row_value
        FROM
            '.$table.'
        GROUP BY
            row_value
        ORDER by
            row_value';

    $connSQL=new DB();
    $res=$connSQL->row($lib);

    $s='[';
    for ($i=1; $i<=$res->row_value; $i++) {
        $s.='{optionValue:'.php2js($i).', optionDisplay:'.php2js($i).'}';
        if ($i+1<=$res->row_value) $s.=', ';
    }
    $s.=']';

    return $s;
}

function single_value($table, $row_value) {
    $lib='
        SELECT
            '.$row_value.' AS row_value
        FROM
            '.$table;

    $connSQL=new DB();
    $res=$connSQL->row($lib);
    echo '[{optionValue:'.php2js($res->row_value).'}]';
}

function load_profile($table, $myurl, $mycpt, $mytarget, $mylabelname) {
    $lib='
        SELECT
            *
        FROM
            '.$table;

    $connSQL=new DB();
    $res=$connSQL->query($lib);
    $cpt_res=count($res);
    echo '<script type="text/javascript">'."\n";
    echo 'removeFormFields(\''.$mytarget.'\');'."\n";

    foreach($res as $key => $value) {
        $i=1;
        if (strpos($myurl,'?')) {
            $url=$myurl.'&';
        } else {
            $url=$myurl.'?';
        }
        foreach($value as $val) {
            if ($i!=1 && count($value)!=$i) $url.='&';
            $url.='f_'.$i.'='.$val;
            $i++;
        }
        echo 'addFormField(\''.$mycpt.'\',\''.$mytarget.'\', \''.$mylabelname.'\', \''.$url.'\', \'\');'."\n";
    }
    echo '</script>'."\n";
}


function neat_r($arr, $return = false, $endline) {
    $out = array();
    $oldtab = "  ";
    $newtab = "  ";
    $lines = explode("\n", print_r($arr, true));

    foreach ($lines as $line) {
        if (substr($line, -5) != "Array") {    $line = preg_replace("/^(\s*)\[[0-9]+\] => /", "$1", $line, 1); }
        foreach (array(
            "Array"        => "",
            "["            => "",
            "geoplugin_"            => "",
            "]"            => "",
            " =>"        => ":",
        ) as $old => $new) {
            $out = str_replace($old, $new, $out);
        }
        if (in_array(trim($line), array("Array", "(", ")", ""))) continue;
        $indent = "";
        $indents = floor((substr_count($line, $oldtab) - 1) / 2);
        if ($indents > 0) { for ($i = 0; $i < $indents; $i++) { $indent .= $newtab; } }
        $out[] = $indent . trim($line) . $endline;
    }
    $out = implode("\n", $out);
    $out=substr($out, 0, -1). "\n";
    if ($return == true) return $out;
    echo $out;
}


function print_nice(&$elem,$max_level=10,$print_nice_stack=array()){
    if(is_array($elem) || is_object($elem)){
        if(in_array($elem,$print_nice_stack,true)){
            echo "<font color=red>RECURSION</font>";
            return;
        }
        $print_nice_stack[]=$elem;
        if($max_level<1){
            echo "<font color=red>nivel maximo alcanzado</font>";
            return;
        }
        $max_level--;
        echo "<table border=1 cellspacing=0 cellpadding=3 width=100%>";
        if(is_array($elem)){
            echo '<tr><td colspan=2 style="background-color:#261C1A;"><strong><font color=#f2e1d8>ARRAY</font></strong></td></tr>';
        }else{
            echo '<tr><td colspan=2 style="background-color:#bf8924;"><strong>';
            echo '<font color=#F2E1D8>OBJECT Type: '.get_class($elem).'</font></strong></td></tr>';
        }
        $color=0;
        foreach($elem as $k => $v){

            if($max_level%2){
                $rgb=($color++%2)?"#a66c26":"#BF8924";
            }else{
                $rgb=($color++%2)?"#bf8924":"#735949";
            }
            echo '<tr><td valign="top" style="width:40px;background-color:'.$rgb.';">';
            echo '<strong><font color=WHITE face="MS-DOS CP 932">'.$k."</font></strong></td><td>";
            print_nice($v,$max_level,$print_nice_stack);
            echo "</td></tr>";
        }
        echo "</table>";
        return;
    }
    if($elem === null){
        echo "<font color=green>NULL</font>";
    }elseif($elem === 0){
        echo "0";
    }elseif($elem === true){
        echo "<font color=green>TRUE</font>";
    }elseif($elem === false){
        echo "<font color=green>FALSE</font>";
    }elseif($elem === ""){
        echo "<font color=green>EMPTY STRING</font>";
    }else{
        echo str_replace("\n","<strong><font color=red>*</font></strong><br>\n",$elem);
    }
}

function sortArray($data, $field) {
    if(!is_array($field)) $field = array($field);
    usort($data, function($a, $b) use($field) {
         $retval = 0;
         foreach($field as $fieldname) {
              if($retval == 0) $retval = strnatcmp($a[$fieldname],$b[$fieldname]);
         }
         return $retval;
    });
    return $data;
}
?>
