<?php
function add_printer($conn, $data) {
    $query = "INSERT INTO printers (name, manufacturer, model, firmware, kinematics, 
              max_velocity, max_accel, max_accel_to_decel, square_corner_velocity) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssdddd', 
        $data['name'], $data['manufacturer'], $data['model'], $data['firmware'], 
        $data['kinematics'], $data['max_velocity'], $data['max_accel'], 
        $data['max_accel_to_decel'], $data['square_corner_velocity']);
    
    return mysqli_stmt_execute($stmt);
}

function get_all_printers($conn) {
    $query = "SELECT * FROM printers ORDER BY name";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_printer($conn, $printer_id) {
    $query = "SELECT * FROM printers WHERE printer_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $printer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function update_printer($conn, $printer_id, $data) {
    $query = "UPDATE printers SET 
              name = ?, manufacturer = ?, model = ?, firmware = ?, kinematics = ?,
              max_velocity = ?, max_accel = ?, max_accel_to_decel = ?, square_corner_velocity = ?
              WHERE printer_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssssddddi', 
        $data['name'], $data['manufacturer'], $data['model'], $data['firmware'], 
        $data['kinematics'], $data['max_velocity'], $data['max_accel'], 
        $data['max_accel_to_decel'], $data['square_corner_velocity'], $printer_id);
    
    return mysqli_stmt_execute($stmt);
}

function delete_printer($conn, $printer_id) {
    $query = "DELETE FROM printers WHERE printer_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $printer_id);
    return mysqli_stmt_execute($stmt);
}
?>