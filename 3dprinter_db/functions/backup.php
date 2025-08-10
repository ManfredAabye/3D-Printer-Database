<?php
function create_backup($conn, $type = 'mysql') {
    $backup_dir = __DIR__ . '/../backups/';
    if (!file_exists($backup_dir)) {
        mkdir($backup_dir, 0755, true);
    }
    
    $filename = $backup_dir . 'backup_' . date('Y-m-d_H-i-s') . '.' . ($type === 'mysql' ? 'sql' : 'db');
    
    if ($type === 'mysql') {
        // MySQL Backup
        $tables = ['printers', 'printheads', 'extruders', 'nozzles', 'filaments', 'printer_profiles', 'process_profiles'];
        $sql = "";
        
        foreach ($tables as $table) {
            // Tabellenstruktur
            $result = mysqli_query($conn, "SHOW CREATE TABLE $table");
            $row = mysqli_fetch_row($result);
            $sql .= "\n\n" . $row[1] . ";\n\n";
            
            // Daten
            $result = mysqli_query($conn, "SELECT * FROM $table");
            while ($row = mysqli_fetch_assoc($result)) {
                $sql .= "INSERT INTO $table VALUES(";
                $values = array_map(function($v) use ($conn) {
                    return "'" . mysqli_real_escape_string($conn, $v) . "'";
                }, array_values($row));
                $sql .= implode(', ', $values) . ");\n";
            }
        }
        
        file_put_contents($filename, $sql);
    } else {
        // SQLite Backup - einfach die Datei kopieren
        copy(SQLITE_PATH, $filename);
    }
    
    return $filename;
}

function restore_backup($conn, $type, $backup_file) {
    if ($type === 'mysql') {
        // MySQL Restore
        $sql = file_get_contents($backup_file['tmp_name']);
        $queries = explode(';', $sql);
        
        foreach ($queries as $query) {
            if (trim($query)) {
                mysqli_query($conn, $query);
            }
        }
    } else {
        // SQLite Restore
        move_uploaded_file($backup_file['tmp_name'], SQLITE_PATH);
    }
    
    return true;
}
?>