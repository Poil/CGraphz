<?php
class InputSubmit extends Field{
    private $itype = 'default';
    
    public function buildField(){
        switch($this->itype) {
            case 'add':
                $this->btnclass.='btn-success';
            break;
            case 'delete':
                $this->btnclass.='btn-danger';
            break;
            default:
                $this->btnclass.='btn-'.$this->itype;
            break;
        }
        $field = '';

        switch($this->formtype) {
            case 'horizontal':
                $field = '<div class="form-group">';
                if (!empty($this->labelgrid)) { $divclass = $this->labelgrid; }
                else { $divclass = 'col-sm-10'; }
                if (!empty($this->inputgrid)) { $divclass.= ' '.$this->inputgrid; }
                else { $divclass .= ' col-sm-offset-2'; }
                $field.= '<div class="'.$divclass.'">';
            break;
            default:
            break;
        }
        
        $field.= '<button name="'.$this->name.'" id="'.$this->name.'" type="submit" class="btn '.$this->btnclass.'">'.$this->value.'</button>';

        switch($this->formtype) {
            case 'horizontal':
                $field.= '</div></div>';
            break;
            default:
            break;
        }

        return $field;
    }
    
    public function iType($v){
        $this->itype = $v;
        return $this;
    }
}
