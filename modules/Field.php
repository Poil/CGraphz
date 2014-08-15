<?php
abstract class Field{
    protected $label = null;
    protected $labelclasses = null;
    protected $fieldclasses = null;
    protected $labelgrid = null;
    protected $inputgrid = null;
    protected $name;
    protected $formtype = null;
    protected $value;
    protected $placeholder;
    protected $important = false;
    protected $readonly = false;
    protected $onchange = null;
    protected $onclick = null;
    
    public function __construct($formtype, $name){
        $this->name($name);
        $this->formType($formtype);
    }
    
    public function hydrate($options){
        foreach($options as $k => $v){
            if(is_callable(array($this, $k)))
                $this->$k($v);
        }
    }
    
    abstract public function buildField();
    
    private function formType($v){
        $this->formtype = $v;
    }

    public function label($v){
        $this->label = $v;
        return $this;
    }

    public function inputGrid($v){
        $this->inputgrid = $v;
        return $this;
    }

    public function labelGrid($v){
        $this->labelgrid = $v;
        return $this;
    }

    public function name($v){
        $this->name = $v;
        return $this;
    }

    public function value($v){
        $this->value = $v;
        return $this;
    }

    public function placeholder($v){
        $this->placeholder = $v;
        return $this;
    }

    public function important($v=true){
        $this->important = $v;
        return $this;
    }

    public function readonly($v){
        $this->readonly = $v;
        return $this;
    }

    public function onchange($v){
        $this->onchange = 'onchange="'.$v.'"';
        return $this;
    }

    public function onclick($v){
        $this->onclick = 'onclick="'.$v.'"';
        return $this;
    }

    public function fieldClasses($v){
        $this->fieldclasses = $v;
        return $this;
    }
   
}
