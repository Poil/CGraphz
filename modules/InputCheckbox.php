<?php
class InputCheckbox extends Field{
    private $checked = false;
    private $default = false;
    private $display = 'inline';
    
    public function buildField(){
        $field = '<label for="'.$this->name.'" class="checkbox '.$this->display.'">';
            if($this->default !== false)
                $field.= '<input type="hidden" name="'.$this->name.'" value="'.$this->default.'"/> ';

            $field.= '<input type="checkbox" name="'.$this->name.'" id="'.$this->name.'" '.$this->onclick.' value="'.$this->value.'" ';
            if($this->checked)
                $field.= ' checked /> ';
            else
                $field.= ' /> ';
        $field.= $this->label.'</label>';
        
        if($this->display == 'inline')
            $field.='<br/>';
        
        return $field;
    }
    
    
    public function checked($v=true){
        $this->checked = $v;
        return $this;
    }

    public function defaultValue($v){
        $this->default = $v;
        return $this;
    }
    
    public function display($v){
        if($v == 'inline' OR $v == 'block' OR $v == 'hidden')
            $this->display = $v;
    }
}
