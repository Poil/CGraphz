<?php
class Select extends Field{
    private $options;
    private $col_id;
    private $col_text;
    private $selected = false;
    private $multiple = false;
    
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

        if(!empty($this->label)){
            $labelclass='sr-only';
            $field.= '<div class="form-group">';
            $field.= '<label class="'.$labelclass.'" for="'.$this->name.$name_prefix.'"> '.$this->label; 
                if($this->important)
                    $field.= ' <span class="red">*</span>'; 
            $field.= '</label>';
        }
            
        $field.= '<select class="'.$fieldclass.'" name="'.$this->name.$name_prefix.'" id="'.$this->name.'" ';
        
        if($this->multiple)
            $field.= 'multiple="multiple" ';
            
        $field.= '>';

        $cpt_elem=count($this->options);
        for ($i=0; $i<$cpt_elem; $i++) {
            $field.= '<option value="'.$this->options[$i]->{$this->col_id}.'">';
                $field.= $this->options[$i]->{$this->col_text};
            $field.= '</option>';
        }
        
        $field.= '</select>';
        if(!empty($this->label))
            $field.= '</div>';
        
        return $field;
    }
    
    public function options($options, $col_id, $col_text){
        $this->options=$options;
        $this->col_id=$col_id;
        $this->col_text=$col_text;
        
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
}
