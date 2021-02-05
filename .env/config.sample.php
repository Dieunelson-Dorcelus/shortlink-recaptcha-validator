<?php

define('PRODUCTION', true);

if(PRODUCTION){
    
    ini_set("display_errors",0);

    define('API', '');
    define('API_VERSION', '');
    define('APP_ORIGIN', '');
    define('APP_AUTHORIZATION', '');
    define('RECAPTCHA_SECRET', '');

}else{
    require_once 'config.dev.php';  
}

