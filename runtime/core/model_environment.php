<?php

/**
 * Description of model_environment
 *
 * @author peyman
 */
class model_environment {
    const Any = '*';
    const Condition = 'if';
    
    protected $rules = array();
    
    public function __construct($rules = NULL) {
        if (!is_null($rules)) {
            $this->rules = $rules;
        }
    }
    
    public function filter_values($values) {
        
    }
    
}
