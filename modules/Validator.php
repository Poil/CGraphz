<?php
class Validator{
    protected $form_error = array();

    public function add_field_error($name, $message){
        if(!isset($this->form_error[$name]))
            $this->form_error[$name] = array();

        $this->form_error[$name][] = $message;
    }

    public function has_field_error($name){
        return !empty($this->form_error[$name]);
    }

    public function get_field_error($name){
        return $this->has_field_error($name) ? $this->form_error[$name] : array();
    }

    public function get_field_errors($name){
        return $this->get_field_error($name);
    }

    public function is_valid_form(){
        return empty($this->form_error);
    }

    public function valid_field($name, \Closure $validator, $message, $http_method = 'POST'){
        $datas = $http_method == 'POST' ? $_POST : $_GET;

        $value = isset($datas[$name]) ? $datas[$name] : null;

        if(false === $validator($value))
            $this->add_field_error($name, $message);
    }

    public function print_field_error($name){
        if($this->has_field_error($name)){
            echo '<ul class="red">';
            foreach($this->get_field_error($name) as $error)
                echo \sprintf('<li>%s</li>', \htmlspecialchars($error));

            echo '</ul>';
        }
    }

    public function bind_field_error($name){
        $html = '';
        if($this->has_field_error($name)){
            $html .= '<ul class="red">';
            foreach($this->get_field_error($name) as $error)
                $html .= '<li>'.\htmlspecialchars($error).'</li>';

            $html .= '</ul>';
        }

        return $html;
    }

    public function bindform_error(){
        $form_error = array();

        foreach($this->form_error as $k=>$v)
            $form_error[$k] = $this->bind_field_error($k);

        return $form_error;
    }
}
