<?php
class validation {
    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() {
        $this->_db = db::getInstance();
    }

    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = trim($source[$item]);
                if($rule === 'required' && empty($value)) {
                    $this->addError("{$items[$item]['error']} doit être spécifé");
                } else if(!empty($value)){
                    switch($rule) {
                        case 'min' :
                            if(strlen($value) < $rule_value) {
                                $this->addError("{$items[$item]['error']} doit contenir au moins {$rule_value} characters");
                            }
                        break;
                        case 'max' :
                            if(strlen($value) > $rule_value) {
                                $this->addError("{$items[$item]['error']} ne peut contenir plus de {$rule_value} characters");
                            }
                        break;
                        case 'matches' :
                            if($value != $source[$rule_value]) {
                                $this->addError("{$items[$rule_value]['error']} doit être identique avec {$items[$item]['error']}");
                            }
                        break;
                        case 'unique' :
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError("{$items[$item]['error']} existe déjà");
                            }
                        break;
                        case 'numeric' :
                            if(is_numeric($value) != $rule_value) {
                                $error = ($rule_value === true) ? "has to" : "can't";
                                $this->addError("{$items[$item]['error']} {$error} doit être composé uniquement de chiffre");
                            }
                        break;
                    }
                }
            }
        }
        if(empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

}