<?php

class ContactsSchema implements SchemaInterface {

	private function __construct() {}

	public static function Up()
	{
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
		if (DbSingleton::Execute($sql)) {
			return "Contacts table created successfully.";
		} else {
			return "Error: Something went wrong.";
		}
	}

	public static function Down()
	{
		$sql = <<<SQL
DROP TABLE IF EXISTS `contacts`;
SQL;

		if (DbSingleton::Execute($sql)) {
			return "Contacts table dropped successfully.";
		} else {
			return "Error: Something went wrong.";
		}
	}
}
