<?php
class InputCheckbox extends Field{
    private $checked = false;
    private $default = false;
    private $labelclass = null;

    public function buildField(){
        $field = '<div class="form-group">'."\n";

        switch($this->formtype) {
            case 'horizontal':
                $field.= '<div class="checkbox">'."\n";
                $this->labelclass.='';
            break;
            case 'inline':
                // In inline case we reset field, because not the same div
                $field = '<div class="checkbox">'."\n";
                $this->labelclass.='';
            break;
            default:
                // In default case we reset field, because not the same div
                $field = '<div class="checkbox">'."\n";
                $this->labelclass.='';
            break;
        }
        if ($this->readonly) { $ro='readonly="readonly"'; }
        else { $ro=''; }

        if (!empty($this->inputgrid)) {
            $field.= '<div class="'.$this->inputgrid.'">'."\n";
        }

        if(!empty($this->label)){
            $field.= '<label class="'.$this->labelclass.'" for="'.$this->name.'">'."\n";
        }

        $field.= '<input type="checkbox" name="'.$this->name.'" id="'.$this->name.'" '.$this->onclick.' value="'.$this->value.'" ';
        if($this->checked)
            $field.= ' checked />'."\n";
        else
            $field.= ' />'."\n";

        if(!empty($this->label)){
            $field.=$this->label;
            if($this->important)
                $field.= '<span class="red">*</span>'."\n";
            $field.= '</label>'."\n";
        }

        if (!empty($this->inputgrid)) {
            $field.= '</div>'."\n";
        }
        if ($this->formtype=='horizontal') {
            $field.= '</div>'."\n";
        }

        # formgroup
        $field.= '</div>'."\n";

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

}
