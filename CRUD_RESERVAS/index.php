<?php
session_start();
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/app/helpers.php';

$hoy = (new DateTime('now'))->format('Y-m-d');

$fecha_listado = isset($_GET['fecha_listado']) && es_fecha_valida($_GET['fecha_listado'])
    ? $_GET['fecha_listado'] : $hoy;

$fecha_disp = isset($_GET['fecha_disp']) && es_fecha_valida($_GET['fecha_disp'])
    ? $_GET['fecha_disp'] : $hoy;

$hora_disp  = isset($_GET['hora_disp']) && es_hora_valida($_GET['hora_disp'])
    ? $_GET['hora_disp'] : '12:00';

$stMes = $pdo->query("SELECT MES_NUMERO FROM MESAS ORDER BY MES_NUMERO ASC");
$mesas_totales = array_map(fn($r) => (int)$r['MES_NUMERO'], $stMes->fetchAll(PDO::FETCH_ASSOC));

$sql = "
    SELECT r.RES_ID,
           r.RES_MESA_NUMERO,
           r.RES_FECHA,
           DATE_FORMAT(r.RES_HORA, '%H:%i') AS RES_HORA_STR,
           c.CLI_NOMBRE,
           c.CLI_TELEFONO
    FROM RESERVACIONES r
    JOIN CLIENTES c ON c.CLI_ID = r.RES_CLI_ID
    WHERE r.RES_FECHA = ?
    ORDER BY r.RES_MESA_NUMERO, r.RES_HORA
";
$st = $pdo->prepare($sql);
$st->execute([$fecha_listado]);
$listado_reservas = $st->fetchAll(PDO::FETCH_ASSOC);

$st2 = $pdo->prepare("SELECT RES_MESA_NUMERO FROM RESERVACIONES WHERE RES_FECHA = ? AND RES_HORA = ?");
$st2->execute([$fecha_disp, $hora_disp]);
$mesas_ocupadas = array_map(fn($r) => (int)$r['RES_MESA_NUMERO'], $st2->fetchAll(PDO::FETCH_ASSOC));

include __DIR__ . '/views/layout/header.php';

if (!empty($_SESSION['flash_success'])) {
    echo '<div class="container mt-3"><div class="alert alert-success alert-dismissible fade show">'
        . htmlspecialchars($_SESSION['flash_success']) .
        '<button type="button" class="close" data-dismiss="alert">&times;</button></div></div>';
    unset($_SESSION['flash_success']);
}
if (!empty($_SESSION['flash_errors'])) {
    echo '<div class="container mt-3"><div class="alert alert-danger"><ul class="mb-0">';
    foreach ($_SESSION['flash_errors'] as $err) {
        echo '<li>' . htmlspecialchars($err) . '</li>';
    }
    echo '</ul></div></div>';
    unset($_SESSION['flash_errors']);
}
?>
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="mb-0">Sistema de Reservaciones</h2>
        <button type="button" class="btn btn-primary" id="abrir-form">
            <i class="fa-regular fa-square-plus mr-1"></i> Nueva reserva
        </button>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <?php include __DIR__ . '/views/reservas.php'; ?>
            <?php
            $prefill_fecha = $fecha_disp;
            $prefill_hora  = $hora_disp;
            ?>
            <?php include __DIR__ . '/views/disponibilidad.php'; ?>
        </div>
    </div>
</div>

<script>
window.FLASH_SUCCESS = <?= json_encode($_SESSION['flash_success'] ?? null) ?>;
window.FLASH_ERRORS = <?= json_encode($_SESSION['flash_errors']  ?? []) ?>;
</script>
<?php
unset($_SESSION['flash_success'], $_SESSION['flash_errors']);
include __DIR__ . '/views/create.php';
include __DIR__ . '/views/layout/footer.php';