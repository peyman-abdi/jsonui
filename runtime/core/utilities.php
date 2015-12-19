<?php

class utilities {
    public static function starts_with($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
    public static function ends_with($haystack, $needle) {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }
    
    public static function module_valid($module) {
        return true;
    }
    public static function glob_recursive($pattern, $flags = 0) {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, utilities::glob_recursive($dir.'/'.basename($pattern), $flags));
        }
        return $files;
    }
    
    public static function response_object($code, $object, $data) {
	return array("code" => $code, "object" => $object, "data" => $data);
    }
}

