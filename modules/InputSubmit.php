<?php
class InputSubmit extends Field{
    private $itype = 'default';

    public function buildField(){
        if (!isset($this->btnclass)) $this->btnclass='';
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
                $field = '<div class="form-group">'."\n";
                if (!empty($this->labelgrid)) { $divclass = $this->labelgrid; }
                else { $divclass = 'col-sm-10'; }
                if (!empty($this->inputgrid)) { $divclass.= ' '.$this->inputgrid; }
                else { $divclass .= ' col-sm-offset-2'; }
                $field.= '<div class="'.$divclass.'">'."\n";
            break;
            default:
            break;
        }

        $field.= '<button name="'.$this->name.'" id="'.$this->name.'" type="submit" value="'.$this->value.'" class="btn '.$this->btnclass.'">'.$this->value.'</button>'."\n";

        switch($this->formtype) {
            case 'horizontal':
                $field.= '</div>'."\n".'</div>'."\n";
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
