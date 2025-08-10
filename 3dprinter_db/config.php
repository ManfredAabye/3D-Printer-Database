<?php
// Datenbankkonfiguration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'passwd');
define('DB_NAME', 'printerdb');
define('SQLITE_PATH', __DIR__ . '/db/3dprinter.db');

// Anwendungseinstellungen
define('APP_NAME', '3D Printer Database');
define('APP_VERSION', '1.0');
define('DEFAULT_FIRMWARE', 'klipper');

// Fehlerberichterstattung
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Datenbankverbindung herstellen
function db_connect($use_sqlite = false) {
    static $connection;
    
    if (!isset($connection)) {
        if ($use_sqlite) {
            if (!file_exists(SQLITE_PATH)) {
                touch(SQLITE_PATH);
            }
            $connection = new SQLite3(SQLITE_PATH);
        } else {
            $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$connection) {
                die("Datenbankverbindung fehlgeschlagen: " . mysqli_connect_error());
            }
            mysqli_set_charset($connection, 'utf8mb4');
        }
    }
    
    return $connection;
}

// Basisfunktionen
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)));
}
?>