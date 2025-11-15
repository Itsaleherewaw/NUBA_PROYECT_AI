<?php
require_once 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $telefono = trim($_POST['telefono']);
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validaciones
    $errores = [];

    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Email válido es obligatorio";
    }

    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria";
    } elseif (strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres";
    }

    if ($password !== $confirm_password) {
        $errores[] = "Las contraseñas no coinciden";
    }

    if (empty($tipo_usuario) || !in_array($tipo_usuario, ['admin', 'cliente', 'empleado'])) {
        $errores[] = "Tipo de usuario inválido";
    }

    if (empty($errores)) {
        $resultado = registrarUsuario($nombre, $email, $password, $telefono, $tipo_usuario);

        if ($resultado['success']) {
            // Redirigir al login con mensaje de éxito
            header("Location: ../login/login.html?registro=exitoso");
            exit();
        } else {
            $error = $resultado['message'];
        }
    } else {
        $error = implode("<br>", $errores);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tienda Dermatológica</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../login/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Registro de Usuario</h2>

            <?php if (isset($error)): ?>
                <div class="error-message" style="color: red; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre completo:</label>
                    <input type="text" id="nombre" name="nombre" required
                           value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono"
                           value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="tipo_usuario">Tipo de usuario:</label>
                    <select id="tipo_usuario" name="tipo_usuario" required>
                        <option value="">Seleccionar...</option>
                        <option value="cliente" <?php echo (($_POST['tipo_usuario'] ?? '') == 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                        <option value="empleado" <?php echo (($_POST['tipo_usuario'] ?? '') == 'empleado') ? 'selected' : ''; ?>>Empleado</option>
                        <option value="admin" <?php echo (($_POST['tipo_usuario'] ?? '') == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar contraseña:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <button type="submit" class="btn">Registrarse</button>
            </form>

            <p style="text-align: center; margin-top: 15px;">
                ¿Ya tienes cuenta? <a href="../login/login.html">Iniciar sesión</a>
            </p>
        </div>
    </div>
</body>
</html>