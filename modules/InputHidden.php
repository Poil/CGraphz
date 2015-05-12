<?php
class InputHidden extends Field{
    public function buildField(){
        $field = '<input type="hidden" ';
            if(!empty($this->name))
                $field.= 'name="'.$this->name.'" ';
            if(!empty($this->value))
                $field.= 'value="'.$this->value.'" ';
            if(!empty($this->maxlength))
                $field.= 'maxlength="'.$this->maxlength.'" ';
            $field.= 'id="'.$this->name.'"/>';
       
        return $field;
    }
    
    public function maxlength($v){
        $v = intval($v);
        if($v > 0)
            $this->maxlength = $v;
    }
}
