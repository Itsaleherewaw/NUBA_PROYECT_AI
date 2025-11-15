<?php
/**
 * API de Registro de Usuarios
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
$camposRequeridos = ['firstName', 'lastName', 'email', 'password'];
foreach ($camposRequeridos as $campo) {
    if (empty($data[$campo])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => "El campo {$campo} es requerido"
        ]);
        exit;
    }
}

// Sanitizar datos
$nombre = trim($data['firstName']);
$apellido = trim($data['lastName']);
$email = trim(strtolower($data['email']));
$telefono = isset($data['phone']) ? trim($data['phone']) : null;
$password = $data['password'];
$newsletter = isset($data['newsletter']) ? (bool)$data['newsletter'] : false;

// Validaciones
if (strlen($nombre) < 2) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El nombre debe tener al menos 2 caracteres']);
    exit;
}

if (strlen($apellido) < 2) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'El apellido debe tener al menos 2 caracteres']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email inválido']);
    exit;
}

if (strlen($password) < 8) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres']);
    exit;
}

try {
    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT idusuario FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'message' => 'Este correo electrónico ya está registrado'
        ]);
        exit;
    }
    
    // Hash de la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    // Insertar nuevo usuario
    $stmt = $conn->prepare("
        INSERT INTO usuarios (nombre, apellido, email, telefono, password_hash, rol, estado) 
        VALUES (?, ?, ?, ?, ?, 'cliente', 'activo')
    ");
    
    $stmt->execute([$nombre, $apellido, $email, $telefono, $passwordHash]);
    
    $usuarioId = $conn->lastInsertId();
    
    // Registrar en bitácora
    registrarBitacora($conn, $usuarioId, "Usuario registrado: {$email}");
    
    // Si el usuario se suscribió al newsletter, podrías guardarlo en otra tabla
    // Por ahora solo lo registramos en bitácora
    if ($newsletter) {
        registrarBitacora($conn, $usuarioId, "Usuario suscrito al newsletter");
    }
    
    // Respuesta exitosa
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => '¡Cuenta creada exitosamente!',
        'data' => [
            'id' => $usuarioId,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email
        ]
    ]);
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al crear la cuenta. Por favor intenta nuevamente.'
    ]);
    error_log("Error en registro: " . $e->getMessage());
}
?>
