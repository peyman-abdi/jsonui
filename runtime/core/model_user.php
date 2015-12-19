<?php

/**
 * Description of User
 *
 * @author peyman
 */

class user extends model_base {
    
    protected $attributes = array(
        array(
            "attribitues" => array(
                "updated_at",
                "created_at",
                "flags",
                "roles",
                "perms_a",
                "perms_b",
                "perms_c",
            ),
            "rules" => array(
                array("mode" => "url", "roles" => Roles::StaffMembers, "perms_a" => PermissionsA::AccessUsersData)
            )
        ),
        array(
            "attributes" => array(
                "salt",
                "password"
            ),
            "rules" => "hide"
        ),
        array(
            "attributes" => array(
                "phone",
                "email"
            ),
            "rules" => array(
                array("mode" => "self"),
                array("mode" => "app", "certs" => AppCertificates::AccessContactData),
                array("mode" => "url", "roles" => Roles::StaffMembers, "perms_a" => PermissionsA::AccessUsersData)
            )
        ),
        array(
            "attributes" => array(
                "id",
            ),
            "rules" => "*"
        )
    );
    
    public function hasRole($role) {
        return ($this->roles & $role) != 0;
    }

}

