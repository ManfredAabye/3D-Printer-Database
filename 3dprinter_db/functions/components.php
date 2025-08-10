<?php
function get_compatible_printheads($conn, $printer_id) {
    $query = "SELECT * FROM printheads 
              WHERE JSON_CONTAINS(compatible_with, CAST(? AS JSON))";
    
    $stmt = mysqli_prepare($conn, $query);
    $printer_json = json_encode($printer_id);
    mysqli_stmt_bind_param($stmt, 's', $printer_json);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function update_printer_profile_components($conn, $profile_id, $components) {
    $query = "UPDATE printer_profiles SET 
              printhead_id = ?, extruder_id = ?, nozzle_id = ?
              WHERE profile_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'iiii', 
        $components['printhead_id'],
        $components['extruder_id'],
        $components['nozzle_id'],
        $profile_id);
    
    return mysqli_stmt_execute($stmt);
}

function get_filament_settings($conn, $filament_id, $printer_id) {
    // Holt die empfohlenen Einstellungen für ein Filament auf einem bestimmten Drucker
    $query = "SELECT * FROM process_profiles 
              WHERE filament_id = ? AND profile_id IN 
              (SELECT profile_id FROM printer_profiles WHERE printer_id = ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $filament_id, $printer_id);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>