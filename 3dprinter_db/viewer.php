<?php
require_once 'includes/config.php';
require_once 'functions/printers.php';
require_once 'functions/profiles.php';

$conn = db_connect();
$printer_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

include 'includes/header.php';

if ($printer_id > 0) {
    // Detailansicht eines Druckers
    $printer = get_printer($conn, $printer_id);
    $profiles = get_printer_profiles($conn, $printer_id);
    
    echo "<h2>{$printer['name']} ({$printer['manufacturer']})</h2>";
    echo "<p><strong>Firmware:</strong> {$printer['firmware']}</p>";
    
    // Profile anzeigen
    echo "<h3>Druckprofile</h3>";
    foreach ($profiles as $profile) {
        echo "<div class='card mb-3'>
            <div class='card-header'>{$profile['name']}</div>
            <div class='card-body'>
                <h5>Komponenten</h5>
                <ul>
                    <li>Druckkopf: {$profile['printhead_name']}</li>
                    <li>Extruder: {$profile['extruder_name']}</li>
                    <li>Düse: {$profile['nozzle_diameter']}mm</li>
                </ul>
                <h5>Klipper-Einstellungen</h5>
                <pre>{$profile['klipper_config']}</pre>
            </div>
        </div>";
    }
} else {
    // Übersicht aller Drucker
    $printers = get_all_printers($conn);
    
    echo "<h2>3D Drucker Übersicht</h2>";
    echo "<div class='row'>";
    foreach ($printers as $printer) {
        echo "<div class='col-md-4 mb-4'>
            <div class='card'>
                <div class='card-body'>
                    <h5 class='card-title'>{$printer['name']}</h5>
                    <p class='card-text'>{$printer['manufacturer']} - {$printer['model']}</p>
                    <p class='card-text'><small class='text-muted'>Firmware: {$printer['firmware']}</small></p>
                    <a href='viewer.php?id={$printer['printer_id']}' class='btn btn-primary'>Details</a>
                </div>
            </div>
        </div>";
    }
    echo "</div>";
}

include 'includes/footer.php';
?>