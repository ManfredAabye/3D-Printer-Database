<?php
// Form zum Hinzufügen einer neuen Komponente
?>
<form method="post" action="">
    <input type="hidden" name="action" value="add_component">
    <div class="mb-3">
        <label for="component_name" class="form-label">Komponentenname</label>
        <input type="text" class="form-control" id="component_name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="component_type" class="form-label">Typ</label>
        <input type="text" class="form-control" id="component_type" name="type" required>
    </div>
    <div class="mb-3">
        <label for="component_description" class="form-label">Beschreibung</label>
        <textarea class="form-control" id="component_description" name="description" rows="2"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Komponente hinzufügen</button>
</form>