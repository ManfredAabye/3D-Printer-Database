<?php
// profiles.php - Funktionen für Profile
require_once __DIR__ . '/../includes/config.php';

function get_all_profiles($conn) {
    $sql = "SELECT profiles.*, printers.name AS printer_name FROM profiles LEFT JOIN printers ON profiles.printer_id = printers.printer_id";
    $result = $conn->query($sql);
    $profiles = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $profiles[] = $row;
        }
    }
    return $profiles;
}

// Gibt alle Profile zu einem bestimmten Drucker zurück
function get_printer_profiles($conn, $printer_id) {
    $sql = "SELECT p.*, 
                   c1.name AS printhead_name, 
                   c2.name AS extruder_name, 
                   c3.nozzle_diameter, 
                   p.klipper_config
            FROM profiles p
            LEFT JOIN components c1 ON p.printhead_id = c1.component_id
            LEFT JOIN components c2 ON p.extruder_id = c2.component_id
            LEFT JOIN components c3 ON p.nozzle_id = c3.component_id
            WHERE p.printer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $printer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profiles = [];
    while ($row = $result->fetch_assoc()) {
        $profiles[] = $row;
    }
    $stmt->close();
    return $profiles;
}

function add_profile($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO profiles (name, printer_id) VALUES (?, ?)");
    $stmt->bind_param("si", $data['name'], $data['printer_id']);
    $stmt->execute();
    $stmt->close();
}

function update_profile($conn, $id, $data) {
    $stmt = $conn->prepare("UPDATE profiles SET name=?, printer_id=? WHERE profile_id=?");
    $stmt->bind_param("sii", $data['name'], $data['printer_id'], $id);
    $stmt->execute();
    $stmt->close();
}

function delete_profile($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM profiles WHERE profile_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
