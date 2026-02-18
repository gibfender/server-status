<?php
/**
 * Returns a shared PDO connection. The connection is created once per request
 * and reused on subsequent calls.
 */
function get_db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        global $servername, $dbname, $username, $password;
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $username, $password, $options);
    }
    return $pdo;
}
