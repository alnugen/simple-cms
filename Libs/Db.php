<?php

class Db {

	private $dbo;

	public function __construct($dbConfig = array()) {
		if (!empty($dbConfig)) {
			$this->dbo = @new mysqli(
				$dbConfig['host'],
				$dbConfig['user'],
				$dbConfig['pass'],
				$dbConfig['name']
			);
			if (mysqli_connect_error()) {
				die("Database Error: " . mysqli_connect_error());
			}
		} else {
			die("Database Error: Invalid database configuration file.");
		}
	}

	public function execute($sql = "") {
		if ($sql != "") {
			$return = $this->dbo->query($sql);
			if ($this->dbo->error) {
				die("Database Error: " . $this->dbo->error);
			}
			return $return;
		} else {
			die("Database Error: Empty query supplied.");
		}
	}

	public function row($sql = "") {
		if ($sql != "") {
			return FALSE !== $this->execute($sql) ? $this->execute($sql)->fetch_assoc() : NULL;
		} else {
			die("Database Error: Empty query supplied.");
		}
	}

	public function rows($sql = "") {
		if ($sql != "") {
			$rows = array();
			$result = $this->execute($sql);
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
			return $rows;
		} else {
			die("Database Error: Empty query supplied.");
		}
	}

	public function numRows($sql = "") {
		if ($sql != "") {
			return FALSE !== $this->execute($sql) ? $this->execute($sql)->num_rows : -1;
		} else {
			die("Database Error: Empty query supplied.");
		}
	}

	public function insertId() {
		return $this->dbo->insert_id;
	}

	public function escString($value) {
		return $this->dbo->real_escape_string($value);
	}
}