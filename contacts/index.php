<?php
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS . '..' . DS);
define('BASE_URL', '../');

//-------------------------------------------------

require_once BASE_DIR . 'config.php';
require_once BASE_DIR . 'autoload.php';

//-------------------------------------------------

Utils::$templatePath = BASE_DIR . 'templates' . DS;

//-------------------------------------------------

$dbo = new Db($dbConfig);

if (Request::Get("id") != "") {
	$id = (int) Request::Get("id");
	$contact = $dbo->row(sprintf(
		"SELECT `contacts`.`id`, `contacts`.`fullname` FROM `contacts` WHERE `contacts`.`id` = %d",
		$id
	));
	if (!is_null($contact)) {
		$sql = sprintf("DELETE FROM `contacts` WHERE `contacts`.`id` = %d", $id);
		if ($dbo->execute($sql)) {
			Session::Flash("success", "Contact " . $contact['fullname'] . " deleted successfully.");
			Response::Redirect(BASE_URL . "contacts/index.php");
		} else {
			Session::Flash("error", "Could not delete contact. Please try again.");
			Response::Redirect(BASE_URL . "contacts/index.php");
		}
	} else {
		Utils::Show404();
	}
}

$dbo = new Db($dbConfig);

$sql = "SELECT * FROM `contacts`;";

//-------------------------------------------------

echo Utils::Render('master.phtml', array(
	'page_title' => 'Contacts Listing Page',
	'errors' => Session::Flash("errors"),
	'error' => Session::Flash("error"),
	'success' => Session::Flash("success"),
	'content' => Utils::Render('contacts/index.phtml', array(
		'contacts' => $dbo->rows($sql),
		'contacts_total' => $dbo->numRows($sql),
	)),
));