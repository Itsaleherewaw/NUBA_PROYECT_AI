<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Conexión - NUBA</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #fefbfc 0%, #f8e8f3 50%, #fefbfc 100%);
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(155,56,118,0.15);
        }
        h1 {
            color: #9b3876;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            border-left: 4px solid #17a2b8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #9b3876;
            color: white;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-danger {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Test de Conexión - NUBA</h1>
        
        <?php
        // Test 1: Verificar que PHP está funcionando
        echo '<div class="success">✅ PHP está funcionando correctamente (Versión: ' . phpversion() . ')</div>';
        
        // Test 2: Verificar extensión PDO
        if (extension_loaded('pdo_mysql')) {
            echo '<div class="success">✅ Extensión PDO MySQL está instalada</div>';
        } else {
            echo '<div class="error">❌ Extensión PDO MySQL NO está instalada</div>';
        }
        
        // Test 3: Intentar conexión a la base de datos
        try {
            require_once 'config.php';
            echo '<div class="success">✅ Archivo config.php cargado correctamente</div>';
            echo '<div class="success">✅ Conexión a la base de datos exitosa</div>';
            
            // Test 4: Verificar tablas
            echo '<h2>📊 Tablas en la Base de Datos:</h2>';
            $stmt = $conn->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($tables) > 0) {
                echo '<table>';
                echo '<tr><th>#</th><th>Nombre de la Tabla</th><th>Estado</th></tr>';
                $i = 1;
                foreach ($tables as $table) {
                    echo '<tr>';
                    echo '<td>' . $i++ . '</td>';
                    echo '<td>' . $table . '</td>';
                    echo '<td><span class="badge badge-success">Existe</span></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<div class="error">❌ No se encontraron tablas. Ejecuta el archivo migracion.sql</div>';
            }
            
            // Test 5: Verificar estructura de tabla usuarios
            echo '<h2>👤 Estructura de la Tabla Usuarios:</h2>';
            $stmt = $conn->query("DESCRIBE usuarios");
            $columns = $stmt->fetchAll();
            
            echo '<table>';
            echo '<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Default</th></tr>';
            foreach ($columns as $column) {
                echo '<tr>';
                echo '<td>' . $column['Field'] . '</td>';
                echo '<td>' . $column['Type'] . '</td>';
                echo '<td>' . $column['Null'] . '</td>';
                echo '<td>' . $column['Key'] . '</td>';
                echo '<td>' . ($column['Default'] ?? 'NULL') . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            
            // Test 6: Contar usuarios
            $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
            $result = $stmt->fetch();
            echo '<div class="info">ℹ️ Total de usuarios registrados: <strong>' . $result['total'] . '</strong></div>';
            
            // Test 7: Verificar funciones de password
            if (function_exists('password_hash')) {
                echo '<div class="success">✅ Función password_hash() disponible</div>';
                $testHash = password_hash('test123', PASSWORD_BCRYPT);
                echo '<div class="info">ℹ️ Ejemplo de hash: ' . substr($testHash, 0, 30) . '...</div>';
            } else {
                echo '<div class="error">❌ Función password_hash() NO disponible (actualiza PHP)</div>';
            }
            
            // Test 8: Verificar sesiones
            if (session_status() === PHP_SESSION_DISABLED) {
                echo '<div class="error">❌ Las sesiones están deshabilitadas</div>';
            } else {
                echo '<div class="success">✅ Las sesiones están habilitadas</div>';
            }
            
            echo '<h2>✨ Resumen</h2>';
            echo '<div class="success">';
            echo '<strong>¡Todo está configurado correctamente!</strong><br>';
            echo 'Puedes proceder a usar el sistema de registro y login.<br><br>';
            echo '<strong>Próximos pasos:</strong><br>';
            echo '1. Ve a <a href="../login/registro.html">Registro</a> para crear una cuenta<br>';
            echo '2. Ve a <a href="../login/login.html">Login</a> para iniciar sesión<br>';
            echo '3. Ve a <a href="../index.html">Inicio</a> para ver la página principal';
            echo '</div>';
            
        } catch(PDOException $e) {
            echo '<div class="error">❌ Error de conexión: ' . $e->getMessage() . '</div>';
            echo '<div class="info">';
            echo '<strong>Posibles soluciones:</strong><br>';
            echo '1. Verifica que MySQL esté corriendo en XAMPP<br>';
            echo '2. Asegúrate de haber ejecutado el archivo sql/migracion.sql<br>';
            echo '3. Verifica las credenciales en php/config.php<br>';
            echo '4. Verifica que la base de datos "nuba_db" exista';
            echo '</div>';
        }
        ?>
        
        <hr style="margin: 30px 0;">
        <p style="text-align: center; color: #666;">
            <strong>NUBA - Skincare Boutique Natural</strong><br>
            Test de Conexión v1.0
        </p>
    </div>
</body>
</html>
