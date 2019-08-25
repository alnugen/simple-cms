<?php

class BaseSchema {

	private function __construct() {}

	protected static $dbo;

	protected static function init() {
		global $dbConfig;
		self::$dbo = new Db($dbConfig);
	}

}