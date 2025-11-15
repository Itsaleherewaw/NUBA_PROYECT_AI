<?php
/**
 * API de Logout
 * NUBA - Skincare Boutique Natural
 */

header('Content-Type: application/json');
require_once 'config.php';

iniciarSesion();

if (estaLogueado()) {
    $usuarioId = $_SESSION['usuario_id'];
    $email = $_SESSION['usuario_email'];
    
    // Registrar logout en bitácora
    registrarBitacora($conn, $usuarioId, "Logout: {$email}");
    
    // Cerrar sesión
    cerrarSesion();
    
    echo json_encode([
        'success' => true,
        'message' => 'Sesión cerrada exitosamente'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No hay sesión activa'
    ]);
}
?>
