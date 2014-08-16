<?php
class InputText extends Field{
    private $maxlength;
    private $itype='text';
    
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
        
        $field.= '<input '.$ro.' class="form-control" type="'.$this->itype.'" ';
            if(!empty($this->name))
                $field.= 'name="'.$this->name.'" ';
            if(!empty($this->value))
                $field.= 'value="'.$this->value.'" ';
            if(!empty($this->placeholder))
                $field.= 'placeholder="'.$this->placeholder.'" ';
            if(!empty($this->maxlength))
                $field.= 'maxlength="'.$this->maxlength.'" ';
            $field.= 'id="'.$this->name.'"/>';
       
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

    public function itype($v) {
        $this->itype = $v;
        return $this;
    }
}
