<?php

/**
 * Description of JSONException
 *
 * @author peyman
 */
class jsonui_exception extends Exception {
    
    public function __construct($code) {
        parent::__construct(jsonui_exception_codes::getString($code), $code, null);
    }
    
}
