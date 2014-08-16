<?php
class InputCheckbox extends Field{
    private $checked = false;
    private $default = false;
    private $display = 'inline';
    
    public function buildField(){
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

        $field.= '<input type="checkbox" name="'.$this->name.'" id="'.$this->name.'" '.$this->onclick.' value="'.$this->value.'" ';
        if($this->checked)
            $field.= ' checked /> ';
        else
            $field.= ' /> ';
        
        if (!empty($this->inputgrid)) {
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
