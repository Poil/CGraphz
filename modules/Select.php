<?php
class Select extends Field{
    private $_options = array();
    private $_selected = false;
    private $_multiple = false;
    
    public function buildField(){
        $field = '';
        if(!empty($this->label)){
            $labelclass='sr-only'
            $field = '<div class="form-group">';
            $field.= '<label class="'.$labelclass.'" for="'.$this->name.'"> '.$this->label; 
                if($this->important)
                    $field.= ' <span class="red">*</span>'; 
            $field.= '</label>';
        }
            
        $field.= '<select name="'.$this->name.'" id="'.$this->name.'" ';
        
        if($this->_multiple)
            $field.= 'multiple="multiple" ';
            
        $field.= '>';
        
        foreach($this->_options as $k=>$v){
            $field.= '<option value="'.$k.'"';
            if($this->_selected == $k)
                $field.= ' selected';
            $field.= ' >'.$v.'</option>';
        }
        
        $field.= '</select>';
        if(!empty($this->label))
            $field.= '</div>';
        
        return $field.'<br/>';
    }
    
    public function options($k, $v=null){
        if(\is_array($k)){
            $options = $this->_options;
            $this->_options = \array_merge($options, $k);
        }else
            $this->_options[$k] = $v;
        
        return $this;
    }
    public function selected($k){
        $this->_selected = $k;
        return $this;
    }
    
    public function multiple($k=true){
        $this->_multiple = $k;
        return $this;
    }
}
