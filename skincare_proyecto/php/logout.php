<?php
require_once 'auth.php';

cerrarSesion();

// Redirigir al inicio
header("Location: ../index.html");
exit();
?>