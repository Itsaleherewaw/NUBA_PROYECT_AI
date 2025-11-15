<?php
require_once 'auth.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validaciones básicas
    if (empty($email) || empty($password)) {
        $error = "Email y contraseña son obligatorios";
    } else {
        $resultado = iniciarSesion($email, $password);

        if ($resultado['success']) {
            // Redirigir según el tipo de usuario
            switch ($resultado['tipo_usuario']) {
                case 'admin':
                    header("Location: ../dashboards/admin.html");
                    break;
                case 'cliente':
                    header("Location: ../dashboards/cliente.html");
                    break;
                case 'empleado':
                    header("Location: ../dashboards/empleado.html");
                    break;
                default:
                    header("Location: ../index.html");
            }
            exit();
        } else {
            $error = $resultado['message'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tienda Dermatológica</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../login/login.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Iniciar Sesión</h2>

            <?php if (isset($error)): ?>
                <div class="error-message" style="color: red; margin-bottom: 15px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
                <div class="success-message" style="color: green; margin-bottom: 15px;">
                    ¡Registro exitoso! Ahora puedes iniciar sesión.
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn">Iniciar Sesión</button>
            </form>

            <p style="text-align: center; margin-top: 15px;">
                ¿No tienes cuenta? <a href="../login/registro.html">Registrarse</a>
            </p>
        </div>
    </div>
</body>
</html>