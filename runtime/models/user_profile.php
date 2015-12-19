<?php
class user_profile extends model_base {
    protected $attributes = array(
        array(
            "attributes" => array(
                "id",
                "user_id",
                "firstname",
                "lastname",
                "birthday",
                "gender",
                "country",
                "state",
                "city",
                "address"
            ),
            "rules" => "*"
        ),
        array(
            "attributes" => array(
                "avatar"
            ),
            "rules" => array(
                array("mode" => "urp", "roles" => Roles::StaffMembers, "perms_a" => PermissionsA::AccessUsersData)
            )
        )
    );
    
    
    
}
