<?php
?>
<div class="card shadow-sm">
    <div class="card-body">
        <form class="form-inline mb-3" method="GET" action="<?= htmlspecialchars($URL) ?>/index.php">
            <label class="mr-2">Disponibilidad para: </label>
            <input type="date" name="fecha_disp" value="<?= htmlspecialchars($fecha_disp) ?>" class="form-control mr-2">
            <input type="time" name="hora_disp" value="<?= htmlspecialchars($hora_disp) ?>" class="form-control mr-2">
            <button class="btn btn-outline-success">Consultar</button>
        </form>

        <div class="grid-mesas">
            <?php foreach ($mesas_totales as $m): ?>
            <?php if (in_array((int)$m, $mesas_ocupadas, true)): ?>
            <div class="mesa-ocu">Mesa <?= (int)$m ?><br><small>Ocupada</small></div>
            <?php else: ?>
            <button type="button" class="mesa-dispo abrir-modal-reserva" data-mesa="<?= (int)$m ?>"
                data-fecha="<?= htmlspecialchars($fecha_disp) ?>" data-hora="<?= htmlspecialchars($hora_disp) ?>">
                Mesa <?= (int)$m ?><br><small>Disponible</small>
            </button>

            <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <p class="mt-2 small-muted">
            Mostrando disponibilidad el <b><?= htmlspecialchars($fecha_disp) ?></b> a las
            <b><?= htmlspecialchars($hora_disp) ?></b>.
        </p>
    </div>
</div>