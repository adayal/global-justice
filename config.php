<?php

// path constants
define('SYSTEM_PATH', dirname(__FILE__)); # location of 'app' folder - don't change
define('BASE_URL','http://'.$_SERVER['SERVER_NAME']);
define('PUBLIC_FILES', "http://".$_SERVER['SERVER_NAME']."/global_justice/public/");
// database constants
define('DB_HOST','127.0.0.1');
define('DB_USER','root');
define('DB_PASS','');
define('DB_DATABASE','global_justice');

// admin credentials
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'mypass');
