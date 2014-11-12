<?php
class InputText extends Field{
    private $formcontrol=true;
    private $maxlength;
    private $itype='text';
    private $autocomplete=true;
    
    public function buildField(){
        $field = '<div class="form-group">'."\n";

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

        if (!$this->autocomplete) { $autocomplete='autocomplete="off"'; }
        else { $autocomplete=''; }

        if ($formcontrol==true) {
           $fieldclass='form-control';
	}

        if(!empty($this->label)){
            if (!empty($this->labelgrid)) {
                $this->labelclass.=' '.$this->labelgrid;
            }

            $field.= '<label class="'.$this->labelclass.'" for="'.$this->name.'">'.$this->label; 
                if($this->important)
                    $field.= ' <span class="red">*</span>'; 
            $field.= '</label>'."\n";
        }

        if (!empty($this->inputgrid)) {
            $field.= '<div class="'.$this->inputgrid.'">'."\n";
        }
        
        $field.= '<input '.$ro.' '.$autocomplete.' class="'.$fieldclass.'" type="'.$this->itype.'" ';
            if(!empty($this->name))
                $field.= 'name="'.$this->name.'" ';
            if(!empty($this->value))
                $field.= 'value="'.$this->value.'" ';
            if(!empty($this->placeholder))
                $field.= 'placeholder="'.$this->placeholder.'" ';
            if(!empty($this->maxlength))
                $field.= 'maxlength="'.$this->maxlength.'" ';
            $field.= 'id="'.$this->name.'"/>'."\n";
       
        if (!empty($this->inputgrid)) {
            $field.= '</div>'."\n";
        }

        # formgroup     
        $field.= '</div>'."\n";
        
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

    public function autocomplete($v) {
        $this->autocomplete = $v;
        return $this;
    }
    public function formcontrol($k){
        $this->formcontrol= $k;
        return $this;
    }
}
