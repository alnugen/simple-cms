<?php
date_default_timezone_set('Australia/Sydney');
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
    $id      = (int) Request::Get("id");
    $contact = DbSingleton::Row("SELECT `contacts`.* FROM `contacts` WHERE `contacts`.`id` = ?", array($id));
} else {
    Utils::Show404();
}

if (Request::Post("token") == md5("contact.edit")) {
	$errors = array();
	$fullname = trim(Request::Post("fullname"));
	$email = trim(Request::Post("email"));

	if ($fullname == "") {
		$errors['fullname'][] = "Full Name cannot be empty";
	}

	if ($email == "") {
		$errors['email'][] = "Email cannot be empty";
	}

	if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		$errors['email'][] = "Email is not valid email.";
	}

	if (!empty($errors)) {

		Session::Flash("errors", $errors);

		Session::Flash("inputs", array(
			'fullname' => Request::Post("fullname"),
			'email' => Request::Post("email"),
		));

		Response::Redirect(BASE_URL . "contacts/edit.php?id=". $id);
	} else {
		$sql = <<<SQL
UPDATE `contacts`
SET
`contacts`.`fullname` = ?,
`contacts`.`email` = ?,
`contacts`.`created_at` = ?,
`contacts`.`modified_at` = ?
WHERE
`contacts`.`id` = ?;
SQL;

		if (DbSingleton::Execute($sql, array($fullname, $email, $contact->created_at, date('Y-m-d h:i:s'), $id ))) {
			Session::Flash("success", "Contact edited successfully.");
			Response::Redirect(BASE_URL . "contacts/show.php?id=". $contact->id );
		} else {
			Session::Flash("error", "Could not insert data. Plese try again.");
			Response::Redirect(BASE_URL . "contacts/edit.php?id=". $contact->id);
		}
	}

}

//-------------------------------------------------

echo Utils::Render('master.phtml', array(
	'page_title' => 'Contacts Listing Page',
	'errors' => Session::Flash("errors"),
	'error' => Session::Flash("error"),
	'success' => Session::Flash("success"),
	'content' => Utils::Render('contacts/edit.phtml', array(
		'inputs' => $contact,
	)),
));
