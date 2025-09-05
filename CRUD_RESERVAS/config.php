<?php
define('SERVIDOR', 'localhost');
define('USUARIO', 'Melvin1');       // Cambiado de 'root' a 'pro_as1'
define('PASSWORD', 'Dragon123'); // Reemplaza 'tu_contraseña' con la real
define('BD', 'restaurante');     // Cambiado a 'db_proyect_as1'

// Agrega el puerto 3306 si es necesario (opcional, ya que 3306 es el predeterminado)
$servidor = "mysql:dbname=" . BD . ";host=" . SERVIDOR . ";port=3307";

try {
    $pdo = new PDO($servidor, USUARIO, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    // echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}

$URL = "http://localhost/CRUD_RESERVAS";