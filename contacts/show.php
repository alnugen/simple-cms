<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS . '..' . DS);
define('BASE_URL', '../');

//-------------------------------------------------

require_once BASE_DIR . 'configs' . DS . 'dbconfig.php';
require_once BASE_DIR . 'autoload.php';

require_once BASE_DIR . 'db.php';

//-------------------------------------------------

Utils::$templatePath = BASE_DIR . 'templates' . DS;

//-------------------------------------------------

if (Request::Get("id") != "") {
	$id = (int) Request::Get("id");
	$contact = DbSingleton::Row(
		"SELECT `contacts`.* FROM `contacts` WHERE `contacts`.`id` = ?", array($id));
	if (is_null($contact)) {
		Utils::Show404();
	}
}

//-------------------------------------------------

echo Utils::Render('master.phtml', array(
	'page_title' => 'Contacts Listing Page',
	'errors' => Session::Flash("errors"),
	'error' => Session::Flash("error"),
	'success' => Session::Flash("success"),
	'content' => Utils::Render('contacts/show.phtml', array(
		'contact' => $contact,
	)),
));
