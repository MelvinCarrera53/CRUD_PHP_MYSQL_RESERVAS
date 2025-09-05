<?php
?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form class="form-inline mb-3" method="GET" action="<?= htmlspecialchars($URL) ?>/index.php">
            <label class="mr-2">Ver reservas del día:</label>
            <input type="date" name="fecha_listado" value="<?= htmlspecialchars($fecha_listado) ?>"
                class="form-control mr-2">
            <button class="btn btn-outline-secondary"><i class="fa-solid fa-magnifying-glass"></i> Filtrar</button>
        </form>
        <?php if (!empty($listado_reservas)): ?>
        <div class="table-responsive">
            <table id="tabla-reservas" class="table table-sm table-striped">
                <thead class="thead-light">
                    <tr>
                        <th><i class="fa-solid fa-chair"></i> Mesa</th>
                        <th><i class="fa-regular fa-clock"></i> Hora</th>
                        <th><i class="fa-regular fa-user"></i> Cliente</th>
                        <th><i class="fa-solid fa-phone"></i> Teléfono</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listado_reservas as $r): ?>
                    <tr>
                        <td><?= (int)$r['RES_MESA_NUMERO'] ?></td>
                        <td><?= htmlspecialchars($r['RES_HORA_STR']) ?></td>
                        <td><?= htmlspecialchars($r['CLI_NOMBRE']) ?></td>
                        <td><?= htmlspecialchars($r['CLI_TELEFONO']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="mb-0 small-muted">No hay reservas para la fecha seleccionada.</p>
        <?php endif; ?>
    </div>
</div>