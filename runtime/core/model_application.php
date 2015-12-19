<?php
/**
 * Description of app
 *
 * @author peyman
 */
class model_application extends model_base {
    
    protected $attributes = array(
        array(
            "attributes" => array(
                'id',
                'owner_id',
                'secret',
                'app_token',
                'app_uid',
                'flags',
                'title',
                'description',
                'certificates',
                'vendor',
                'created_at',
                'updated_at',                
            ),
            "rules" => array(
                array("mode" => "owner", "column" => "owner_id"),
                array("mode" => "urp", "roles" => Roles::StaffMembers, "perms_a" => PermissionsA::AccessAppsData),
            )
        )
    );
    
    
    
}
