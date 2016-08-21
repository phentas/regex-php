<?php

// regular expressions for linguistical structures

define('LINGUISTICAL_EXCLUSIONS', '^\.^\?^!' );

/*
define('PROMPT',          '/[^ '.LINGUISTICAL_EXCLUSIONS.'](['.LINGUISTICAL_EXCLUSIONS.'])*!/' );
define('QUESTION',        '/[^ '.LINGUISTICAL_EXCLUSIONS.'](['.LINGUISTICAL_EXCLUSIONS.')*\?/' );
define('SENTENCE',        '/[^ '.LINGUISTICAL_EXCLUSIONS.'](['.LINGUISTICAL_EXCLUSIONS.'])*[\.\?!]/' );
define('PURE_SENTENCE',   '/[^ '.LINGUISTICAL_EXCLUSIONS.'](['.LINGUISTICAL_EXCLUSIONS.'])*\./' );
define('SUBSENTENCE',     '/[^ ^\.^\?^!^,]([^,^\.^\?^!])*,/' );
*/

define('PROMPT',          '/[^ ^\.^\?^!]([^\.^\?^!])*!/' );
define('QUESTION',        '/[^ ^\.^\?^!]([^\.^\?^!])*\?/' );
define('SENTENCE',        '/[^ ^\.^\?^!]([^\.^\?^!])*[\.\?!]/' );
define('PURE_SENTENCE',   '/[^ ^\.^\?^!]([^\.^\?^!])*\./' );
define('SUBSENTENCE',     '/[^ ^\.^\?^!^,]([^,^\.^\?^!])*,/' );
define('QUOTED',          '/("(.([^"])*)")/' );
define('SIMPLE_QUOTED',   '/(\'(.([^\'])*)\')/' );
define('BRACKED',         '/(\[(.([^\[^\]])*)\])/' );
define('CLUTCHED',        '/(\(((.)*)\))/' );



// regular expressions for math parts

define('NUMBER_FLOAT',     '/([0-9]{0,}\.)([0-9]{0,}/' );



// regular expressions for IT structures

define('JSON',             '/(\{((.)*)\})/' );
define('JSON_OBJECT',      JSON );
define('JSON_ARRAY',       BRACKED );



// regular expressions for IT parts

define('IP',               '/([0-9]{1,3}.){3}([0-9]{1,3}.)/' );

// file formats
define('FILE_FORMAT',         '/(.([^ ])*)\.[fmt]/' );
define('VIDEO_FILE_FORMATS',  '/(.([^ ])*)\.(avi|mkv|mp4|m4v|mpg|mov)/' );
define('AUDIO_FILE_FORMATS',  '/(.([^ ])*)\.(ogg|mp3|wav|aac)/' );
define('OFFICE_FILE_FORMATS', '/(.([^ ])*)\.(pdf|doc|xls|aac)/' );



// return types

define('GET_AS_ARRAY',  1 );
define('GET_AS_STRING', 2 );
define('GET_AS_JSON',   3 );





class StringPattern {
    
    
    
    
    public static function get_parted ( $_s, $_p, $_f = GET_AS_ARRAY ) {
        
        preg_match_all ( $_p, $_s, $m );
        return self::get_format ( $m[0], $_f );
    }
    
    
    public static function has_pattern ( $_s, $_p ) {
        
        preg_match_all ( $_p, $_s, $m );
        return $m[0]>0 ;
    }
    
    
    public static function is_pattern ( $_s, $_p ) {
        
        preg_match_all ( $_p, $_s, $m );
        return $m[0]>0 ;
    }
    
    
    // private area
    
    private static function get_format ( $_r, $_f ) {
        
        switch( $_f ) {
                
            case GET_AS_STRING :
                
                return self::get_as_string ( $_r );
                break;
            
            case GET_AS_JSON :
                
                return self::get_as_json ( $_r );
                break;
                
            default :
                
                return $_r;
                break;

        }
    }
    
    
    private static function get_as_string ( $_r, $_d = " " ) {
        
        return implode ( $_d, $_r);    
    }
    
    
    private static function get_as_json ( $_r ) {
        
        return json_encode ( $_r );    
    }
}

?>