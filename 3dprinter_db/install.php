<?php
require_once 'config.php';
require_once 'functions/backup.php';

// SQL für MySQL
$mysql_sql = <<<SQL
CREATE TABLE IF NOT EXISTS printers (
    printer_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    manufacturer VARCHAR(100),
    model VARCHAR(100),
    firmware ENUM('klipper','marlin','repetier','smoothieware') NOT NULL DEFAULT 'klipper',
    kinematics ENUM('cartesian','corexy','delta','scara','polar') NOT NULL,
    max_velocity DECIMAL(10,2),
    max_accel DECIMAL(10,2),
    max_accel_to_decel DECIMAL(10,2),
    square_corner_velocity DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS printheads (
    printhead_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    manufacturer VARCHAR(100),
    compatible_with JSON,
    heat_time DECIMAL(10,2),
    max_temp DECIMAL(6,2) NOT NULL,
    heater_power DECIMAL(6,2),
    thermistor_type VARCHAR(50),
    heat_block VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Weitere Tabellen wie im vorherigen Schema...
SQL;

// SQLite-spezifische Anpassungen
$sqlite_sql = str_replace([
    'AUTO_INCREMENT', 
    'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
    'JSON'
], [
    'AUTOINCREMENT',
    '',
    'TEXT'
], $mysql_sql);

// Installation durchführen
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_type = sanitize_input($_POST['db_type']);
    $conn = db_connect($db_type === 'sqlite');
    
    if ($db_type === 'mysql') {
        $queries = explode(';', $mysql_sql);
    } else {
        $queries = explode(';', $sqlite_sql);
    }
    
    foreach ($queries as $query) {
        if (trim($query)) {
            if ($db_type === 'mysql') {
                mysqli_query($conn, $query);
            } else {
                $conn->exec($query);
            }
        }
    }
    
    // Grunddaten einfügen
    include 'functions/install_default_data.php';
    install_default_data($conn, $db_type);
    
    echo "<div class='alert alert-success'>Installation erfolgreich!</div>";
}

include 'includes/header.php';
?>
<h2>Datenbankinstallation</h2>
<form method="post">
    <div class="form-group">
        <label>Datenbanktyp:</label>
        <select name="db_type" class="form-control" required>
            <option value="mysql">MySQL</option>
            <option value="sqlite">SQLite</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Installieren</button>
</form>
<?php include 'includes/footer.php'; ?>