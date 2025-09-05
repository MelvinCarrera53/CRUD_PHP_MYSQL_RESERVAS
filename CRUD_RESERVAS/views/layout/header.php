<?php // views/layout/header.php 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservaciones | Restaurante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS locales -->
    <link rel="stylesheet" href="<?= $URL ?>/css/estilos.css">
    <link rel="stylesheet" href="<?= $URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $URL ?>/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="<?= $URL ?>/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= $URL ?>/css/all.min.css">
    <link rel="stylesheet" href="<?= $URL ?>/css/sweetalert2.min.css">

    <style>
    .card {
        border-radius: 1rem;
    }

    .grid-mesas {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        grid-gap: .5rem;
    }

    .mesa-dispo {
        border: 1px solid #28a745;
        color: #155724;
        background: #d4edda;
        border-radius: .75rem;
        padding: .5rem;
        text-align: center;
    }

    .mesa-ocu {
        border: 1px solid #dc3545;
        color: #721c24;
        background: #f8d7da;
        border-radius: .75rem;
        padding: .5rem;
        text-align: center;
    }

    .small-muted {
        font-size: .9rem;
        color: #6c757d;
    }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?= htmlspecialchars($URL) ?>/index.php">
            <i class="fa-solid fa-utensils mr-1"></i> CRUD-RESERVAS
        </a>
    </nav>