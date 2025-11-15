<?php
/**
 * API de Login de Usuarios
 * NUBA - Skincare Boutique Natural
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

// Solo aceptar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos del POST
$data = json_decode(file_get_contents('php://input'), true);

// Si no hay datos JSON, intentar con $_POST
if (!$data) {
    $data = $_POST;
}

// Validar campos requeridos
if (empty($data['email']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Email y contraseña son requeridos'
    ]);
    exit;
}

$email = trim(strtolower($data['email']));
$password = $data['password'];
$remember = isset($data['remember']) ? (bool)$data['remember'] : false;

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email inválido']);
    exit;
}

try {
    // Buscar usuario por email
    $stmt = $conn->prepare("
        SELECT idusuario, nombre, apellido, email, password_hash, rol, estado 
        FROM usuarios 
        WHERE email = ?
    ");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    
    // Verificar si el usuario existe
    if (!$usuario) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
        exit;
    }
    
    // Verificar si el usuario está activo
    if ($usuario['estado'] !== 'activo') {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Tu cuenta está inactiva. Contacta al administrador.'
        ]);
        exit;
    }
    
    // Verificar contraseña
    if (!password_verify($password, $usuario['password_hash'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
        
        // Registrar intento fallido
        registrarBitacora($conn, $usuario['idusuario'], "Intento de login fallido");
        exit;
    }
    
    // Login exitoso - Iniciar sesión
    iniciarSesion();
    
    $_SESSION['usuario_id'] = $usuario['idusuario'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['usuario_apellido'] = $usuario['apellido'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['usuario_rol'] = $usuario['rol'];
    $_SESSION['login_time'] = time();
    
    // Si marcó "recordarme", extender la sesión
    if ($remember) {
        ini_set('session.gc_maxlifetime', 30 * 24 * 60 * 60); // 30 días
        session_set_cookie_params(30 * 24 * 60 * 60);
    }
    
    // Registrar login exitoso
    registrarBitacora($conn, $usuario['idusuario'], "Login exitoso");
    
    // Determinar dashboard según rol
    $dashboard = '../dashboards/cliente.html';
    if ($usuario['rol'] === 'admin') {
        $dashboard = '../dashboards/admin.html';
    } elseif ($usuario['rol'] === 'empleado') {
        $dashboard = '../dashboards/empleado.html';
    }
    
    // Respuesta exitosa
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => '¡Bienvenida a NUBA!',
        'data' => [
            'id' => $usuario['idusuario'],
            'nombre' => $usuario['nombre'],
            'apellido' => $usuario['apellido'],
            'email' => $usuario['email'],
            'rol' => $usuario['rol'],
            'dashboard' => $dashboard
        ]
    ]);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al iniciar sesión. Por favor intenta nuevamente.'
    ]);
    error_log("Error en login: " . $e->getMessage());
}
?>
