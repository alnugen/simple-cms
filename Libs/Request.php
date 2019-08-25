<?php

class Request {

	private function __construct() {}

	public static function Get($key) {
		if (isset($_GET)) {
			if (array_key_exists($key, $_GET)) {
				return $_GET[$key];
			}
		}
		return null;
	}

	public static function Post($key) {
		if (isset($_POST)) {
			if (array_key_exists($key, $_POST)) {
				return $_POST[$key];
			}
		}
		return null;
	}

}