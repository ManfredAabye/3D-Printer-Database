<?php
$printer = isset($printer_id) ? get_printer(db_connect(), $printer_id) : null;
?>
<form method="post" action="editor.php">
    <input type="hidden" name="action" value="<?php echo $printer ? 'update_printer' : 'add_printer'; ?>">
    <?php if ($printer): ?>
        <input type="hidden" name="printer_id" value="<?php echo $printer['printer_id']; ?>">
    <?php endif; ?>
    
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" required 
               value="<?php echo $printer['name'] ?? ''; ?>">
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Hersteller</label>
            <input type="text" class="form-control" name="manufacturer" 
                   value="<?php echo $printer['manufacturer'] ?? ''; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Modell</label>
            <input type="text" class="form-control" name="model" 
                   value="<?php echo $printer['model'] ?? ''; ?>">
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Firmware</label>
            <select class="form-select" name="firmware" required>
                <?php foreach (['klipper', 'marlin', 'repetier', 'smoothieware'] as $fw): ?>
                    <option value="<?php echo $fw; ?>" <?php echo ($printer['firmware'] ?? DEFAULT_FIRMWARE) === $fw ? 'selected' : ''; ?>>
                        <?php echo ucfirst($fw); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Kinematik</label>
            <select class="form-select" name="kinematics" required>
                <?php foreach (['cartesian', 'corexy', 'delta', 'scara', 'polar'] as $kin): ?>
                    <option value="<?php echo $kin; ?>" <?php echo ($printer['kinematics'] ?? '') === $kin ? 'selected' : ''; ?>>
                        <?php echo ucfirst($kin); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary">
        <?php echo $printer ? 'Aktualisieren' : 'Hinzufügen'; ?>
    </button>
</form>