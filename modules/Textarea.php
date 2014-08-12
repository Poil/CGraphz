<?php
class Textarea extends Field{
    private $extendable = false;
    
    public function buildField(){
        $field = '';
        
        if(!empty($this->label)){
            $field.= '<label for="input_'.$this->name.'"> '.$this->label; 
                if($this->important)
                    $field.= ' <span class="red">*</span>'; 
            $field.= '</label>';
        }
        
        $field.= '<textarea ';
            if(!empty($this->name))
                $field.= 'name="'.$this->name.'" ';
            if(!empty($this->placeholder))
                $field.= 'placeholder="'.$this->placeholder.'" ';
            $field.= 'id="input_'.$this->name.'"';
        
            if($this->extendable)
                $field.= 'class="extendable"';
                
            $field.= '>';
            
            if(!empty($this->value))
                $field.= $this->value;
        $field.= '</textarea>';
        
        return $field.'<br/>';
    }
    
    public function extendable($v=true){
        $this->extendable = $v;
        return $this;
    }
}
