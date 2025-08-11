<?php
require_once 'config.php';

header('Content-Type: application/json');

$printer_id = (int)$_GET['printer_id'];
$type = $_GET['type'];

$conn = db_connect();
$components = [];

switch ($type) {
    case 'printhead':
        $query = "SELECT printhead_id as id, name FROM printheads 
                 WHERE JSON_CONTAINS(compatible_with, ?)";
        $stmt = mysqli_prepare($conn, $query);
        $printer_json = json_encode($printer_id);
        mysqli_stmt_bind_param($stmt, 's', $printer_json);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $components = mysqli_fetch_all($result, MYSQLI_ASSOC);
        break;
        
    // Ähnlich für andere Komponententypen
}

echo json_encode($components);
?>