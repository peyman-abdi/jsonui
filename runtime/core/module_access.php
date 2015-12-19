<?php

class module_access {
    
    protected $access = array(
        'ip' => '*',
        'signed' => false,
        'allow' => 0,
        'permissions' => array(
        ),
        'certifications' => array(
            'self' => true,
            'shared' => false,
            'others' => array (
            )
        ),
    );

    public function isAccessible(user $user = null) {
        if ($this->access['signed'] && is_null($user)) {
            throw new jsonui_exception(jsonui_exception_codes::AccessDenied);
        } else {
            
            return true;
        }
    }
    
    public static function any_person() {
        return new module_access();
    }
    public static function any_user() {        
        return new module_access();
    }
    public static function any_person_or_app() {
        return new module_access();
    }
    
}
