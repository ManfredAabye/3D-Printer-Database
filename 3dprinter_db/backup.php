<?php
require_once 'config.php';
require_once 'functions/backup.php';

$conn = db_connect();
$backup_type = isset($_GET['type']) ? sanitize_input($_GET['type']) : 'mysql';

if (isset($_GET['action'])) {
    $action = sanitize_input($_GET['action']);
    
    if ($action === 'create') {
        $filename = create_backup($conn, $backup_type);
        if ($filename) {
            echo "<div class='alert alert-success'>Backup erstellt: $filename</div>";
        }
    } elseif ($action === 'restore' && isset($_FILES['backup_file'])) {
        $result = restore_backup($conn, $backup_type, $_FILES['backup_file']);
        if ($result) {
            echo "<div class='alert alert-success'>Backup erfolgreich wiederhergestellt</div>";
        }
    }
}

include 'includes/header.php';
?>

<h2>Datenbank Backup</h2>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Backup erstellen</div>
            <div class="card-body">
                <p>Erstellen Sie ein Backup der aktuellen Datenbank.</p>
                <div class="btn-group">
                    <a href="?action=create&type=mysql" class="btn btn-primary">MySQL Backup</a>
                    <a href="?action=create&type=sqlite" class="btn btn-secondary">SQLite Backup</a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Backup wiederherstellen</div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="?action=restore">
                    <div class="form-group">
                        <label>Backup-Datei:</label>
                        <input type="file" name="backup_file" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Datenbanktyp:</label>
                        <select name="type" class="form-control" required>
                            <option value="mysql">MySQL</option>
                            <option value="sqlite">SQLite</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Wiederherstellen</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>