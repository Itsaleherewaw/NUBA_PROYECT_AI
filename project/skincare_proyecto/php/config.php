<?php
/**
 * Archivo de configuración de base de datos
 * NUBA - Skincare Boutique Natural
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_NAME', 'nuba_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de sesión
define('SESSION_TIMEOUT', 3600); // 1 hora en segundos

// Intentar conexión a la base de datos
try {
    $conn = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    // En producción, no mostrar detalles del error
    die(json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos'
    ]));
}

// Función para iniciar sesión segura
function iniciarSesion() {
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_secure', 0); // Cambiar a 1 si usas HTTPS
        session_start();
    }
}

// Función para verificar si el usuario está logueado
function estaLogueado() {
    iniciarSesion();
    return isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_email']);
}

// Función para obtener datos del usuario actual
function obtenerUsuarioActual() {
    if (!estaLogueado()) {
        return null;
    }
    return [
        'id' => $_SESSION['usuario_id'],
        'nombre' => $_SESSION['usuario_nombre'] ?? '',
        'apellido' => $_SESSION['usuario_apellido'] ?? '',
        'email' => $_SESSION['usuario_email'],
        'rol' => $_SESSION['usuario_rol'] ?? 'cliente'
    ];
}

// Función para cerrar sesión
function cerrarSesion() {
    iniciarSesion();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    session_destroy();
}

// Función para registrar en bitácora
function registrarBitacora($conn, $usuario_id, $accion) {
    try {
        $stmt = $conn->prepare("INSERT INTO bitacora (usuario_id, accion) VALUES (?, ?)");
        $stmt->execute([$usuario_id, $accion]);
    } catch(PDOException $e) {
        // Log error pero no detener ejecución
        error_log("Error en bitácora: " . $e->getMessage());
    }
}
?>
