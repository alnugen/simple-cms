<?php

class ContactsSchema extends BaseSchema {

	private function __construct() {}

	public static function Up() {
		parent::init();
		$sql = <<<SQL
CREATE TABLE IF NOT EXISTS `contacts` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `fullname` VARCHAR(255) NOT NULL DEFAULT '',
    `email` VARCHAR(255) NOT NULL DEFAULT '',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);
SQL;
		if (parent::$dbo->execute($sql)) {
			return "Contacts table created successfully.";
		} else {
			return "Error: Something went wrong.";
		}
	}

	public static function Down() {
		parent::init();
		$sql = <<<SQL
DROP TABLE IF EXISTS `contacts`;
SQL;
		parent::$dbo->execute($sql);
		if (parent::$dbo->execute($sql)) {
			return "Contacts table dropped successfully.";
		} else {
			return "Error: Something went wrong.";
		}
	}
}
