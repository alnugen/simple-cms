<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

require_once BASE_DIR . 'config.php';
require_once BASE_DIR . 'autoload.php';

// Schema Up
echo ContactsSchema::Up();

// Schema Up
// echo ContactsSchema::Down();
