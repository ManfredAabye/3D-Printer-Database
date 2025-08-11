<?php
// Formular zum Hinzufügen eines neuen Profils
?>
<form method="post" action="">
    <input type="hidden" name="action" value="add_profile">
    <div class="mb-3">
        <label for="profile_name" class="form-label">Profilname</label>
        <input type="text" class="form-control" id="profile_name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="profile_description" class="form-label">Beschreibung</label>
        <textarea class="form-control" id="profile_description" name="description" rows="2"></textarea>
    </div>
    <!-- Optional: Auswahl eines Druckers, falls benötigt -->
    <!--
    <div class="mb-3">
        <label for="printer_id" class="form-label">Drucker</label>
        <select class="form-control" id="printer_id" name="printer_id">
            <option value="">Bitte wählen</option>
            <?php
            // Beispiel: Druckerliste ausgeben
            // $printers = get_all_printers($conn);
            // foreach ($printers as $printer) {
            //     echo \"<option value='{$printer['printer_id']}'>{$printer['name']}</option>\";
            // }
            ?>
        </select>
    </div>
    -->
    <button type="submit" class="btn btn-success">Profil hinzufügen</button>
</form>