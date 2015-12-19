<?php

interface BaseEnum {
    
}

class Platforms {
    
}

class AppCertificates implements BaseEnum {
    const AccessContactData = 1;
    const AccessProfileData = 2;
}

class PermissionsA {
    const AccessUsersData   = 1;
    const AccessAppsData    = 2;
}

class Roles implements BaseEnum {
    
    const Root = 1;
    const Manager = 2;
    const TeamMemebr = 4;
    const Observer = 8;
    const Teacher = 16;
    const Student = 32;
    
    const StaffMembers = 7;
    const Any = 63;
    
    public function getMetaData() {
        
    }

    public function getString($value) {
        switch ($value) {
            case Roles::Root: return 'ریشه';
        }
    }

}

class jsonui_exception_codes implements BaseEnum {
    const AccessDenied = 1001;
    
    public static function getMetaData() {
        
    }
    public static function getString($value) {
        switch ($value) {
            case jsonui_exception_codes::AccessDenied: return 'اجازه دسترسی ندارید';
        }
    }

}