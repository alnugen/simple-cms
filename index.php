<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS);

require_once BASE_DIR . 'config.php';
require_once BASE_DIR . 'autoload.php';

echo "{message: 'alive'}";
