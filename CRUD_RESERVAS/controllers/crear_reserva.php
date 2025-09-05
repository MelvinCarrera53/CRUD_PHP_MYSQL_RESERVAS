<?php
session_start();
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/helpers.php';

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = limpiar($_POST['nombre'] ?? '');
    $telefono = limpiar($_POST['telefono'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mesa     = (int)($_POST['mesa'] ?? 0);
    $fecha    = $_POST['fecha'] ?? '';
    $hora     = $_POST['hora'] ?? '';
    $notas    = limpiar($_POST['notas'] ?? '');

    if ($nombre === '') {
        $errores[] = "El nombre es obligatorio.";
    }
    if ($telefono === '') {
        $errores[] = "El teléfono es obligatorio.";
    }
    if (!es_fecha_valida($fecha)) {
        $errores[] = "La fecha no es válida (YYYY-MM-DD).";
    }
    if (!es_hora_valida($hora)) {
        $errores[] = "La hora no es válida (HH:MM).";
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El correo electrónico no es válido.";
    }

    if ($mesa <= 0) {
        $errores[] = "Debe seleccionar una mesa válida.";
    } else {
        $qMesa = $pdo->prepare("SELECT COUNT(*) FROM MESAS WHERE MES_NUMERO = ?");
        $qMesa->execute([$mesa]);
        if ((int)$qMesa->fetchColumn() === 0) {
            $errores[] = "La mesa seleccionada no existe.";
        }
    }

    if (es_fecha_valida($fecha) && es_hora_valida($hora)) {
        $ahora = new DateTime('now');
        $dt = DateTime::createFromFormat('Y-m-d H:i', "$fecha $hora");
        if ($dt < $ahora) {
            $errores[] = "No se permite reservar en una fecha/hora pasada.";
        }
    }

    if (!$errores) {
        $q = $pdo->prepare("SELECT COUNT(*) FROM RESERVACIONES WHERE RES_MESA_NUMERO = ? AND RES_FECHA = ? AND RES_HORA = ?");
        $q->execute([$mesa, $fecha, $hora]);
        if ((int)$q->fetchColumn() > 0) {
            $errores[] = "La mesa $mesa ya está reservada el $fecha a las $hora.";
        }
    }

    if (!$errores) {
        try {
            $pdo->beginTransaction();

            $csel = $pdo->prepare("SELECT CLI_ID FROM CLIENTES WHERE CLI_TELEFONO = ?");
            $csel->execute([$telefono]);
            $cliente_id = $csel->fetchColumn();

            if (!$cliente_id) {
                $cins = $pdo->prepare("INSERT INTO CLIENTES (CLI_NOMBRE, CLI_TELEFONO, CLI_EMAIL) VALUES (?, ?, ?)");
                $cins->execute([$nombre, $telefono, $email !== '' ? $email : null]);
                $cliente_id = $pdo->lastInsertId();
            } else {
                $cupd = $pdo->prepare("UPDATE CLIENTES SET CLI_NOMBRE = ?, CLI_EMAIL = ? WHERE CLI_ID = ?");
                $cupd->execute([$nombre, $email !== '' ? $email : null, $cliente_id]);
            }

            $rins = $pdo->prepare("
                INSERT INTO RESERVACIONES (RES_CLI_ID, RES_MESA_NUMERO, RES_FECHA, RES_HORA, RES_NOTAS)
                VALUES (?, ?, ?, ?, ?)
            ");
            $rins->execute([$cliente_id, $mesa, $fecha, $hora, $notas !== '' ? $notas : null]);

            $pdo->commit();
            $_SESSION['flash_success'] = "✅ ¡Reserva registrada exitosamente! Mesa $mesa para $nombre el $fecha a las $hora.";
        } catch (Exception $e) {
            $pdo->rollBack();
            $errores[] = "Error al guardar la reserva: " . $e->getMessage();
            $_SESSION['flash_errors'] = $errores;
        }
    } else {
        $_SESSION['flash_errors'] = $errores;
    }
}

header("Location: " . $URL . "/index.php");
exit;