<?php

$dbconfig = include BASE_DIR . 'configs' . DS . 'dbconfig.php';

try {

    $pdo = new PDO(
        sprintf(
            "%s:host=%s; dbname=%s",
            $dbconfig['driver'],
            $dbconfig['host'],
            $dbconfig['name']
        ),
        $dbconfig['user'],
        $dbconfig['pass']
    );

} catch (PDOException $ex) {
    die("Database Error: " . $ex->getMessage());
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

DbSingleton::SetDbInstance(new Db($pdo));
