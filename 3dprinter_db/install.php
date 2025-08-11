<?php
require_once 'includes/config.php';
require_once 'functions/backup.php';

// SQL für MySQL (inkl. Prüfung und Ergänzung fehlender Tabellen)
$mysql_sql = [
    // printers
    "CREATE TABLE IF NOT EXISTS printers (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    // components
    "CREATE TABLE IF NOT EXISTS components (
        component_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        type ENUM('printhead','extruder','nozzle') NOT NULL,
        manufacturer VARCHAR(100),
        nozzle_diameter DECIMAL(4,2),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    // profiles
    "CREATE TABLE IF NOT EXISTS profiles (
        profile_id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        printer_id INT NOT NULL,
        printhead_id INT,
        extruder_id INT,
        nozzle_id INT,
        klipper_config TEXT,
        FOREIGN KEY (printer_id) REFERENCES printers(printer_id),
        FOREIGN KEY (printhead_id) REFERENCES components(component_id),
        FOREIGN KEY (extruder_id) REFERENCES components(component_id),
        FOREIGN KEY (nozzle_id) REFERENCES components(component_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    // printheads
    "CREATE TABLE IF NOT EXISTS printheads (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    // ...weitere Tabellen nach Bedarf...
];

// SQLite-spezifische Anpassungen
$sqlite_sql = array_map(function($sql) {
    return str_replace([
        'AUTO_INCREMENT', 
        'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
        'JSON'
    ], [
        'AUTOINCREMENT',
        '',
        'TEXT'
    ], $sql);
}, $mysql_sql);

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
    
    $queries = ($db_type === 'mysql') ? $mysql_sql : $sqlite_sql;
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