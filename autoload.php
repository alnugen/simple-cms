<?php

function my_autoloader($className) {
	$autoloadPaths = array(
		'Libs/',
		'Dev/Schemas/',
		'Dev/Seeds/',
	);

	foreach ($autoloadPaths as $autoloadPath) {
		$autoloadPath = str_replace('/', DS, $autoloadPath);
		$classPath = BASE_DIR . $autoloadPath . $className . '.php';
		if (file_exists($classPath)) {
			require_once $classPath;
		}
	}
}

spl_autoload_register('my_autoloader');