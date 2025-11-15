<?php
/**
 * API para verificar sesión activa
 * NUBA - Skincare Boutique Natural
 */

header('Content-Type: application/json');
require_once 'config.php';

iniciarSesion();

if (estaLogueado()) {
    $usuario = obtenerUsuarioActual();
    
    echo json_encode([
        'success' => true,
        'logueado' => true,
        'usuario' => $usuario
    ]);
} else {
    echo json_encode([
        'success' => true,
        'logueado' => false,
        'usuario' => null
    ]);
}
?>
