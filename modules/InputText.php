<?php
class InputText extends Field{
    private $maxlength;
    
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
        
        $field.= '<input class="form-control" type="text" ';
            if(!empty($this->name))
                $field.= 'name="'.$this->name.'" ';
            if(!empty($this->value))
                $field.= 'value="'.$this->value.'" ';
            if(!empty($this->placeholder))
                $field.= 'placeholder="'.$this->placeholder.'" ';
            if(!empty($this->maxlength))
                $field.= 'maxlength="'.$this->maxlength.'" ';
            $field.= 'id="input_'.$this->name.'"/>';
       
        if (!empty($this->inputgrid)) {
            $field.= '</div>';
        }

        # formgroup     
        $field.= '</div>';
        
        return $field;
    }
    
    public function maxlength($v){
        $v = intval($v);
        if($v > 0)
            $this->maxlength = $v;
    }
}
