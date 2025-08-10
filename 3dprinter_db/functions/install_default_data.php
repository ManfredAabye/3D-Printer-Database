<?php
function install_default_data($conn, $db_type) {
    // Standard-Drucker
    $printers = [
        [
            'name' => 'Voron 2.4',
            'manufacturer' => 'Voron Design',
            'model' => '2.4',
            'firmware' => 'klipper',
            'kinematics' => 'corexy',
            'max_velocity' => 300,
            'max_accel' => 5000,
            'square_corner_velocity' => 5
        ],
        [
            'name' => 'Prusa i3 MK3S+',
            'manufacturer' => 'Prusa Research',
            'model' => 'MK3S+',
            'firmware' => 'marlin',
            'kinematics' => 'cartesian',
            'max_velocity' => 200,
            'max_accel' => 2000,
            'square_corner_velocity' => 5
        ]
    ];
    
    foreach ($printers as $printer) {
        if ($db_type === 'mysql') {
            $query = "INSERT INTO printers (name, manufacturer, model, firmware, kinematics, 
                      max_velocity, max_accel, square_corner_velocity) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'sssssddd', 
                $printer['name'], $printer['manufacturer'], $printer['model'], 
                $printer['firmware'], $printer['kinematics'], $printer['max_velocity'], 
                $printer['max_accel'], $printer['square_corner_velocity']);
            mysqli_stmt_execute($stmt);
        } else {
            $query = "INSERT INTO printers (name, manufacturer, model, firmware, kinematics, 
                      max_velocity, max_accel, square_corner_velocity) 
                      VALUES ('" . implode("', '", array_map([$conn, 'escapeString'], $printer)) . "')";
            $conn->exec($query);
        }
    }
    
    // Weitere Standarddaten für Druckköpfe, Extruder, etc.
    // ...
}
?>