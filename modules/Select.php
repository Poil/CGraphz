<?php
class Select extends Field{
    private $options;
    private $col_id;
    private $col_text;
    private $selected = false;
    private $multiple = false;
    private $optionseparator = ' ';
    private $enable_data = false;
    
    public function buildField(){
        $field = '';
      
        if($this->multiple) {
           $name_prefix='[]';
        } else {
           $name_prefix='';
        }

        if(!empty($this->fieldclasses)) {
           $fieldclass=$this->fieldclasses;
        } else {
           $fieldclass='';
        }
        $field = '<div class="form-group">';

        switch($this->formtype) {
            case 'horizontal':
                $this->labelclass.='control-label';
            break;
            case 'inline':
                $this->labelclass.='sr-only';
            break;
            default:
                $this->labelclass.='';
            break;
        }

        $cpt_elem=count($this->options);
        if ($cpt_elem==0) { $this->readonly=true; }

        if ($this->readonly) { $ro='readonly="readonly"'; }
        else { $ro=''; }

        if(!empty($this->label)){
            if (!empty($this->labelgrid)) {
                $this->labelclass.=' '.$this->labelgrid;
            }

            $field.= '<label class="'.$this->labelclass.'" for="'.$this->name.'">'.$this->label; 
                if($this->important)
                    $field.= ' <span class="red">*</span>'; 
            $field.= '</label>';
        }

        if (!empty($this->inputgrid)) {
            $field.= '<div class="'.$this->inputgrid.'">';
        }
        

        $field.= '<select class="form-control '.$fieldclass.'" '.$ro.' name="'.$this->name.$name_prefix.'" id="'.$this->name.'" ';
        
        if($this->multiple)
            $field.= 'multiple="multiple" ';
            
        $field.= '>';
        if ($cpt_elem > 0) {
            if (is_object($this->options[0])) {
                for ($i=0; $i<$cpt_elem; $i++) {
                    $selected=($this->options[$i]->{$this->col_id}==$this->value) ? ' selected="selected" ' : '';
                    if ($this->enable_data) {
                        if (is_array($this->col_text)) {
                            $data='';
                            foreach ($this->col_text as $curcol_text) {
                               $data.='data-'.$curcol_text.'="'.$this->options[$i]->{$curcol_text}.'" ';
                            }
                        } else {
                           $data='data-'.$this->col_text.'="'.$this->options[$i]->{$this->col_text}.'"';
                        }
                    }
                    $field.= '<option '.$selected.' value="'.$this->options[$i]->{$this->col_id}.'" '.$data.'>';
                        if (is_array($this->col_text)) {
                            foreach ($this->col_text as $curcol_text) {
                                if ($this->options[$i]->{$curcol_text}!='') {
                                    $field.= $this->options[$i]->{$curcol_text}.$this->optionseparator;
                                }
                            }
                            $field=trim($field, $this->optionseparator);
                        } else {
                            $field.= $this->options[$i]->{$this->col_text};
                        }
                    $field.= '</option>';
                }
            } else {
                if ($this->col_id!=null) {
                    for ($i=0; $i<$cpt_elem; $i++) {
                        $selected=($this->options[$i][$this->col_id]==$this->value) ? ' selected="selected" ' : '';
                        $field.= '<option '.$selected.' value="'.$this->options[$i][$this->col_id].'">';
                            $field.= $this->options[$i][$this->col_text];
                        $field.= '</option>';
                    }
                } else {
                    for ($i=0; $i<$cpt_elem; $i++) {
                        $selected=($this->options[$i]==$this->value) ? ' selected="selected" ' : '';
                        $field.= '<option '.$selected.' value="'.$this->options[$i].'">';
                            $field.= $this->options[$i];
                        $field.= '</option>';
                    }
                }
            }
        }
        $field.= '</select>';
        if (!empty($this->inputgrid)) {
            $field.= '</div>';
        }

        # formgroup     
        $field.= '</div>';
        
        return $field;
    }
    
    public function options($options, $col_id=null, $col_text=null){
        $this->options=$options;
        $this->col_id=$col_id;
        $this->col_text=$col_text;
        
        return $this;
    }

    public function optionSeparator($k){
        $this->optionseparator = $k;
        return $this;
    }

    public function selected($k){
        $this->selected = $k;
        return $this;
    }
    
    public function multiple($k=true){
        $this->multiple = $k;
        return $this;
    }

    public function enableData($k){
        $this->enable_data = $k;
        return $this;
    }
}
