<?php
class InputCheckbox extends Field{
    private $checked = false;
    private $default = false;
    private $display = 'inline';
    
    public function buildField(){
        $field = '<div class="form-group">';

        switch($this->formtype) {
            case 'horizontal':
                $field.= '<div class="checkbox">';
                $this->labelclass.='';
            break;
            case 'inline':
                // In inline case we reset field, because not the same div
                $field = '<div class="checkbox">';
                $this->labelclass.='';
            break;
            default:
                // In default case we reset field, because not the same div
                $field = '<div class="checkbox">';
                $this->labelclass.='';
            break;
        }
        if ($this->readonly) { $ro='readonly="readonly"'; }
        else { $ro=''; }

        if (!empty($this->inputgrid)) {
            $field.= '<div class="'.$this->inputgrid.'">';
        }

        if(!empty($this->label)){
            $field.= '<label class="'.$this->labelclass.'" for="'.$this->name.'">';
        }

        $field.= '<input type="checkbox" name="'.$this->name.'" id="'.$this->name.'" '.$this->onclick.' value="'.$this->value.'" ';
        if($this->checked)
            $field.= ' checked /> ';
        else
            $field.= ' /> ';
        
        if(!empty($this->label)){
            $field.=$this->label; 
            if($this->important)
                $field.= ' <span class="red">*</span>'; 
            $field.= '</label>';
        }

        if (!empty($this->inputgrid)) {
            $field.= '</div>';
        }
        if ($this->formtype=='horizontal') {
            $field.= '</div>';
        }

        # formgroup     
        $field.= '</div>';

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
