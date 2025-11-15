<?php
// Archivo de configuración y funciones de autenticación
// Conexión a la base de datos
function conectarDB() {
    $host = 'localhost';
    $usuario = 'root';
    $password = '';
    $base_datos = 'skincare';

    $conn = mysqli_connect($host, $usuario, $password, $base_datos);

    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    return $conn;
}

// Función para registrar usuario
function registrarUsuario($nombre, $email, $password, $telefono, $tipo_usuario) {
    $conn = conectarDB();

    // Verificar si el email ya existe
    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ["success" => false, "message" => "El email ya está registrado"];
    }

    mysqli_stmt_close($stmt);

    // Hash de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = mysqli_prepare($conn, "INSERT INTO usuarios (nombre, email, password, telefono, tipo_usuario) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $nombre, $email, $password_hash, $telefono, $tipo_usuario);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ["success" => true, "message" => "Usuario registrado exitosamente"];
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ["success" => false, "message" => "Error al registrar usuario"];
    }
}

// Función para iniciar sesión
function iniciarSesion($email, $password) {
    $conn = conectarDB();

    $stmt = mysqli_prepare($conn, "SELECT id, nombre, email, password, tipo_usuario FROM usuarios WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nombre, $db_email, $db_password, $tipo_usuario);
    mysqli_stmt_fetch($stmt);

    if (password_verify($password, $db_password)) {
        // Iniciar sesión
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['user_email'] = $db_email;
        $_SESSION['user_name'] = $nombre;
        $_SESSION['user_type'] = $tipo_usuario;

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ["success" => true, "message" => "Inicio de sesión exitoso", "tipo_usuario" => $tipo_usuario];
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return ["success" => false, "message" => "Email o contraseña incorrectos"];
    }
}

// Función para verificar si el usuario está autenticado
function estaAutenticado() {
    session_start();
    return isset($_SESSION['user_id']);
}

// Función para obtener el tipo de usuario
function obtenerTipoUsuario() {
    return $_SESSION['user_type'] ?? null;
}

// Función para cerrar sesión
function cerrarSesion() {
    session_start();
    session_destroy();
}

// Función para verificar acceso por rol
function verificarAcceso($roles_permitidos) {
    if (!estaAutenticado()) {
        header("Location: ../login/login.html");
        exit();
    }

    $tipo_usuario = obtenerTipoUsuario();
    if (!in_array($tipo_usuario, $roles_permitidos)) {
        header("Location: ../index.html");
        exit();
    }
}
?>