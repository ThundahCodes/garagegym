<?php
/*
 * This PHP Script makes the connection to the database
 * The idea of db.php is to use the parameters "server, database, user, pwd, charset" to connect to the database
 */
$server = "localhost";
$database = "garagegymsql1";
$user = "garagegymsql1";
$pwd = 'lF-U4@5j';
$charset = 'utf8';

/*
 * Here the connection will be created with the MySQL server with the given hostname, username, password and charset
 * In any case the errors will be handled with a message and a reason by the Try-Catch Exception Handlers
 */
try {
    $con = new PDO("mysql:host=$server;dbname=$database;charset=$charset", $user, $pwd);
    $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    echo "<p>Es konnte keine Verbindung zur Datenbank hergestellt werden: " . $e->getMessage() . "</p>";
}

?>
