<?php

if($_SERVER['SERVER_NAME']=='localhost'){
    define('ROOT','http://localhost/group_project_1.0/public');
    #db config
    define('DBNAME','lastlastlast');
    define('DBHOST','localhost');
    define('DBUSER','root');
    define('DBPASS','');
}

ini_set('session.use_only_cookies', '1');  
ini_set('session.use_strict_mode', '1');   
session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if (!isset($_SESSION['last_regeneration'])) {
    regenerate_session_id();
} else {
    $interval = 60 * 30;
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_destroy();
        exit;
    }
}
function regenerate_session_id(){
    session_regenerate_id();
    $_SESSION['last_regeneration'] = time();
}