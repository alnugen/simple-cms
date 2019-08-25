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
		"SELECT `contacts`.`id`, `contacts`.`fullname` FROM `contacts` WHERE `contacts`.`id` = ?",
		array($id));
	if (!is_null($contact)) {
		if (DbSingleton::Execute("DELETE FROM `contacts` WHERE `contacts`.`id` = ?", array($id))) {
			Session::Flash("success", "Contact " . $contact->fullname . " deleted successfully.");
			Response::Redirect(BASE_URL . "contacts/index.php");
		} else {
			Session::Flash("error", "Could not delete contact. Please try again.");
			Response::Redirect(BASE_URL . "contacts/index.php");
		}
	} else {
		Utils::Show404();
	}
}

$sql = "SELECT * FROM `contacts`;";

//-------------------------------------------------

echo Utils::Render('master.phtml', array(
	'page_title' => 'Contacts Listing Page',
	'errors' => Session::Flash("errors"),
	'error' => Session::Flash("error"),
	'success' => Session::Flash("success"),
	'content' => Utils::Render('contacts/index.phtml', array(
		'contacts' => DbSingleton::Rows($sql),
		'contacts_total' => DbSingleton::NumRows($sql),
	)),
));
