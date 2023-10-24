<?php
// DB Credentials
define('DSN', 'mysql:host=localhost;dbname=task_tracker');
define('DBUSER', 'root');
define('DBPASS', '');

try {
    $db = new PDO(DSN, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>
