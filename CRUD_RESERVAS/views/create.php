<?php
// views/reservas/form_create.php
$hoy = (new DateTime('now'))->format('Y-m-d');
?>

<div id="form-flotante" class="form-flotante">
    <div class="form-contenido">
        <span class="cerrar" id="cerrar-form">&times;</span>
        <h5>Crear nueva reserva</h5>
        <form action="controllers/crear_reserva.php" method="POST" novalidate>

            <div class="form-group">
                <label>Nombre del cliente *</label>
                <input type="text" name="nombre" class="form-control" required maxlength="120">
            </div>
            <div class="form-group">
                <label>Teléfono *</label>
                <input type="text" name="telefono" class="form-control" required maxlength="30">
            </div>
            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" class="form-control" maxlength="120" placeholder="opcional">
            </div>
            <div class="form-group">
                <label>Mesa *</label>
                <select name="mesa" class="form-control" required>
                    <option value="">--</option>
                    <?php foreach ($mesas_totales as $numMesa): ?>
                    <option value="<?= (int)$numMesa ?>"><?= (int)$numMesa ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Fecha *</label>
                <input type="date" name="fecha" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Hora *</label>
                <input type="time" name="hora" class="form-control" value="12:00" required>
            </div>
            <div class="form-group">
                <label>Notas (opcional)</label>
                <input type="text" name="notas" class="form-control" maxlength="255">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Guardar reserva</button>
        </form>
    </div>
</div>