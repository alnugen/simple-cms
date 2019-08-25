<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

require_once BASE_DIR . 'configs' . DS . 'dbconfig.php';
require_once BASE_DIR . 'autoload.php';

require_once BASE_DIR . 'db.php';

// Schema Up
echo ContactsSchema::Up();

// Schema Down
// echo ContactsSchema::Down();
