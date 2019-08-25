<?php
date_default_timezone_set('Asia/Kathmandu');
define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__) . DS . '..' . DS);
define('BASE_URL', '../');

//-------------------------------------------------

require_once BASE_DIR . 'config.php';
require_once BASE_DIR . 'autoload.php';

//-------------------------------------------------

Utils::$templatePath = BASE_DIR . 'templates' . DS;

//-------------------------------------------------

if (Request::Post("token") == md5("contact.add")) {
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

		Response::Redirect(BASE_URL . "contacts/add.php");
	} else {
		$dbo = new Db($dbConfig);
		$sql = <<<SQL
INSERT INTO `contacts`
(`fullname`, `email`, `created_at`, `modified_at`)
VALUES
('%s', '%s', '%s', '%s');
SQL;
		$sql = sprintf(
			$sql,
			$dbo->escString($fullname),
			$dbo->escString($email),
			date('Y-m-d h:i:s'),
			date('Y-m-d h:i:s')
		);

		if ($dbo->execute($sql)) {
			Session::Flash("success", "New contact added successfully.");
			Response::Redirect(BASE_URL . "contacts/add.php");
		} else {
			Session::Flash("error", "Could not insert data. Plese try again.");
			Response::Redirect(BASE_URL . "contacts/add.php");
		}
	}

}

//-------------------------------------------------

echo Utils::Render('master.phtml', array(
	'page_title' => 'Contacts Listing Page',
	'errors' => Session::Flash("errors"),
	'error' => Session::Flash("error"),
	'success' => Session::Flash("success"),
	'content' => Utils::Render('contacts/add.phtml', array(
		'inputs' => Session::Flash('inputs'),
	)),
));