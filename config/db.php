<?php
class Database {
private static $instance = null;

public static function getConnexion() {
if (self::$instance === null) {
$host = '127.0.0.1';
$dbname = 'green-galsen';
$username = 'root';
$password = '';

try {
self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Erreur de connexion : " . $e->getMessage());
}
}
return self::$instance;
}
}
?>
