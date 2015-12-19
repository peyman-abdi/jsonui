<?php
/**
 * Description of database
 *
 * @author peyman
 */

class database extends singleton {
    
    public function init() {
        DB::$host = config::get('database.hostname');
        DB::$dbName = config::get('database.database');
        DB::$user = config::get('database.username');
        DB::$password = config::get('database.password');
        DB::$port = config::get('database.port');
        
        
    }
    
    
    
}
