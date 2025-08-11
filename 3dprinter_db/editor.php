<?php
require_once 'includes/config.php';
require_once 'functions/printers.php';
require_once 'functions/profiles.php';
require_once 'functions/components.php';

$conn = db_connect();

// Aktionsverarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = sanitize_input($_POST['action']);
    
    switch ($action) {
        case 'add_printer':
            $data = [
                'name' => $_POST['name'],
                'manufacturer' => $_POST['manufacturer'],
                // Weitere Felder
            ];
            add_printer($conn, $data);
            break;
            
        case 'update_profile':
            // Profil aktualisieren
            break;
            
        // Weitere Aktionen...
    }
}

include 'includes/header.php';
?>

<div class="container">
    <h2>3D Drucker Datenbank Administration</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Drucker</div>
                <div class="card-body">
                    <?php include 'functions/printer_form.php'; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <?php include 'functions/profile_form.php'; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Komponenten</div>
                <div class="card-body">
                    <?php include 'functions/component_form.php'; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <h4>Druckerliste</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Hersteller</th>
                    <th>Firmware</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $printers = get_all_printers($conn);
                foreach ($printers as $printer) {
                    echo "<tr>
                        <td>{$printer['name']}</td>
                        <td>{$printer['manufacturer']}</td>
                        <td>{$printer['firmware']}</td>
                        <td>
                            <a href='?edit={$printer['printer_id']}' class='btn btn-sm btn-primary'>Bearbeiten</a>
                            <a href='?delete={$printer['printer_id']}' class='btn btn-sm btn-danger'>Löschen</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>