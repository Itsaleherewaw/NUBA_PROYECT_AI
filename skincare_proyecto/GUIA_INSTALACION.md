# 🌸 GUÍA DE INSTALACIÓN - NUBA Skincare Boutique

## 📋 Tabla de Contenidos
1. [Requisitos Previos](#requisitos-previos)
2. [Instalación de la Base de Datos](#instalación-de-la-base-de-datos)
3. [Configuración del Proyecto](#configuración-del-proyecto)
4. [Estructura de Archivos](#estructura-de-archivos)
5. [Pruebas del Sistema](#pruebas-del-sistema)
6. [Solución de Problemas](#solución-de-problemas)

---

## 🔧 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **XAMPP** (o WAMP/MAMP) - Incluye:
  - Apache (servidor web)
  - MySQL (base de datos)
  - PHP 7.4 o superior
  
### Descargar XAMPP
- Windows: https://www.apachefriends.org/download.html
- Mac: https://www.apachefriends.org/download.html
- Linux: https://www.apachefriends.org/download.html

---

## 💾 Instalación de la Base de Datos

### Paso 1: Iniciar XAMPP

1. Abre el **Panel de Control de XAMPP**
2. Inicia los módulos:
   - ✅ **Apache** (click en "Start")
   - ✅ **MySQL** (click en "Start")

![XAMPP Panel](https://i.imgur.com/example.png)

### Paso 2: Acceder a phpMyAdmin

1. Abre tu navegador
2. Ve a: `http://localhost/phpmyadmin`
3. Deberías ver la interfaz de phpMyAdmin

### Paso 3: Crear la Base de Datos

**Opción A: Usando el archivo SQL (RECOMENDADO)**

1. En phpMyAdmin, haz click en la pestaña **"SQL"** en el menú superior
2. Abre el archivo `sql/migracion.sql` con un editor de texto
3. Copia TODO el contenido del archivo
4. Pégalo en el área de texto de phpMyAdmin
5. Haz click en el botón **"Continuar"** o **"Go"**
6. Deberías ver el mensaje: "✓ La consulta se ha ejecutado correctamente"

**Opción B: Importar el archivo SQL**

1. En phpMyAdmin, haz click en **"Importar"** en el menú superior
2. Click en **"Seleccionar archivo"**
3. Busca y selecciona el archivo `sql/migracion.sql`
4. Haz click en **"Continuar"** al final de la página
5. Espera a que termine la importación

### Paso 4: Verificar la Instalación

1. En el panel izquierdo de phpMyAdmin, deberías ver la base de datos **`nuba_db`**
2. Haz click en ella para expandirla
3. Deberías ver las siguientes tablas:
   - ✅ usuarios
   - ✅ productos
   - ✅ categorias
   - ✅ carrito
   - ✅ ordenes
   - ✅ orden_detalle
   - ✅ bitacora

---

## ⚙️ Configuración del Proyecto

### Paso 1: Ubicar el Proyecto

1. Copia la carpeta `skincare_proyecto` a la carpeta `htdocs` de XAMPP
   - **Windows**: `C:\xampp\htdocs\`
   - **Mac**: `/Applications/XAMPP/htdocs/`
   - **Linux**: `/opt/lampp/htdocs/`

2. La ruta final debería ser:
   ```
   C:\xampp\htdocs\skincare_proyecto\
   ```

### Paso 2: Configurar la Conexión a la Base de Datos

1. Abre el archivo `php/config.php`
2. Verifica que la configuración sea correcta:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'nuba_db');
define('DB_USER', 'root');
define('DB_PASS', '');  // Vacío por defecto en XAMPP
```

**⚠️ IMPORTANTE:** Si configuraste una contraseña para MySQL, cámbiala en `DB_PASS`

### Paso 3: Verificar Permisos (Solo Linux/Mac)

Si estás en Linux o Mac, asegúrate de que los archivos tengan los permisos correctos:

```bash
chmod -R 755 /opt/lampp/htdocs/skincare_proyecto
```

---

## 📁 Estructura de Archivos

```
skincare_proyecto/
│
├── css/                    # Estilos CSS
├── img/                    # Imágenes del proyecto
├── js/                     # JavaScript (si aplica)
│
├── login/                  # Sistema de autenticación
│   ├── login.html         # Página de inicio de sesión
│   └── registro.html      # Página de registro
│
├── php/                    # Backend PHP
│   ├── config.php         # ⭐ Configuración de BD
│   ├── registro.php       # ⭐ API de registro
│   ├── login.php          # ⭐ API de login
│   ├── logout.php         # ⭐ API de logout
│   ├── verificar-sesion.php  # ⭐ Verificar sesión
│   └── productos-data.php # Datos de productos
│
├── sql/                    # Base de datos
│   └── migracion.sql      # ⭐ Script de creación de BD
│
├── dashboards/             # Paneles de usuario
│   ├── admin.html         # Dashboard de administrador
│   ├── cliente.html       # Dashboard de cliente
│   └── empleado.html      # Dashboard de empleado
│
├── index.html             # Página principal
├── Productos.html         # Catálogo de productos
└── contacto.html          # Página de contacto
```

---

## 🧪 Pruebas del Sistema

### Prueba 1: Verificar que Apache y MySQL están corriendo

1. Abre tu navegador
2. Ve a: `http://localhost`
3. Deberías ver la página de bienvenida de XAMPP

### Prueba 2: Verificar la Base de Datos

1. Ve a: `http://localhost/phpmyadmin`
2. Selecciona la base de datos `nuba_db`
3. Haz click en la tabla `usuarios`
4. Deberías ver la estructura de la tabla (aunque esté vacía)

### Prueba 3: Acceder al Proyecto

1. Abre tu navegador
2. Ve a: `http://localhost/skincare_proyecto/`
3. Deberías ver la página principal de NUBA

### Prueba 4: Probar el Registro

1. Ve a: `http://localhost/skincare_proyecto/login/registro.html`
2. Llena el formulario con datos de prueba:
   - **Nombre**: María
   - **Apellido**: García
   - **Email**: maria@test.com
   - **Teléfono**: +591 70514802
   - **Contraseña**: Test1234!
   - **Confirmar Contraseña**: Test1234!
   - ✅ Acepta los términos
3. Haz click en **"Crear Cuenta"**
4. Deberías ver un mensaje de éxito y ser redirigido al login

### Prueba 5: Verificar el Usuario en la Base de Datos

1. Ve a phpMyAdmin: `http://localhost/phpmyadmin`
2. Selecciona `nuba_db` → tabla `usuarios`
3. Haz click en **"Examinar"**
4. Deberías ver el usuario que acabas de crear

### Prueba 6: Probar el Login

1. Ve a: `http://localhost/skincare_proyecto/login/login.html`
2. Ingresa las credenciales:
   - **Email**: maria@test.com
   - **Contraseña**: Test1234!
3. Haz click en **"Iniciar Sesión"**
4. Deberías ser redirigido al dashboard de cliente

---

## 🔍 Solución de Problemas

### ❌ Error: "No se puede conectar a la base de datos"

**Solución:**
1. Verifica que MySQL esté corriendo en XAMPP
2. Revisa las credenciales en `php/config.php`
3. Asegúrate de que la base de datos `nuba_db` existe

### ❌ Error: "Call to undefined function password_hash()"

**Solución:**
- Tu versión de PHP es muy antigua
- Actualiza XAMPP a una versión con PHP 7.4 o superior

### ❌ Error: "Access denied for user 'root'@'localhost'"

**Solución:**
1. Abre phpMyAdmin
2. Ve a la pestaña "Cuentas de usuario"
3. Verifica la contraseña del usuario `root`
4. Actualiza `DB_PASS` en `php/config.php` con la contraseña correcta

### ❌ Error 404: "Not Found"

**Solución:**
1. Verifica que Apache esté corriendo
2. Asegúrate de que el proyecto esté en la carpeta `htdocs`
3. Verifica la URL: `http://localhost/skincare_proyecto/`

### ❌ Los formularios no envían datos

**Solución:**
1. Abre la consola del navegador (F12)
2. Ve a la pestaña "Network" o "Red"
3. Intenta enviar el formulario nuevamente
4. Revisa si hay errores en las peticiones
5. Verifica que las rutas en el código sean correctas:
   - `../php/registro.php`
   - `../php/login.php`

### ❌ Error: "CORS policy"

**Solución:**
- Asegúrate de acceder al proyecto a través de `http://localhost/`
- NO abras los archivos HTML directamente desde el explorador de archivos

---

## 🔐 Seguridad

### Recomendaciones para Producción:

1. **Cambiar credenciales de base de datos**
   ```php
   define('DB_USER', 'tu_usuario_seguro');
   define('DB_PASS', 'tu_contraseña_segura');
   ```

2. **Habilitar HTTPS**
   ```php
   ini_set('session.cookie_secure', 1); // En config.php
   ```

3. **Configurar variables de entorno**
   - No dejar credenciales en el código
   - Usar archivos `.env`

4. **Actualizar permisos de archivos**
   ```bash
   chmod 644 php/config.php
   ```

---

## 📊 Estructura de la Base de Datos

### Tabla: usuarios
| Campo | Tipo | Descripción |
|-------|------|-------------|
| idusuario | INT | ID único (auto-increment) |
| nombre | VARCHAR(50) | Nombre del usuario |
| apellido | VARCHAR(50) | Apellido del usuario |
| email | VARCHAR(120) | Email único |
| telefono | VARCHAR(20) | Teléfono (opcional) |
| direccion | VARCHAR(255) | Dirección (opcional) |
| password_hash | VARCHAR(255) | Contraseña encriptada |
| rol | ENUM | 'cliente' o 'admin' |
| estado | ENUM | 'activo' o 'inactivo' |
| fecha_registro | TIMESTAMP | Fecha de creación |

### Tabla: bitacora
| Campo | Tipo | Descripción |
|-------|------|-------------|
| idbitacora | INT | ID único |
| usuario_id | INT | ID del usuario |
| accion | VARCHAR(200) | Descripción de la acción |
| fecha | TIMESTAMP | Fecha y hora |

---

## 🎯 Próximos Pasos

Una vez que el sistema de login/registro esté funcionando:

1. ✅ Implementar recuperación de contraseña
2. ✅ Agregar validación de email
3. ✅ Implementar el carrito de compras
4. ✅ Conectar el catálogo de productos con la BD
5. ✅ Implementar el sistema de órdenes
6. ✅ Integrar el chatbot

---

## 📞 Soporte

Si tienes problemas:

1. Revisa la sección de [Solución de Problemas](#solución-de-problemas)
2. Verifica los logs de error de Apache:
   - Windows: `C:\xampp\apache\logs\error.log`
   - Linux: `/opt/lampp/logs/error_log`
3. Revisa la consola del navegador (F12)

---

## ✨ ¡Listo!

Tu sistema de registro y login está configurado y funcionando. Ahora puedes:

- ✅ Registrar nuevos usuarios
- ✅ Iniciar sesión
- ✅ Cerrar sesión
- ✅ Verificar sesiones activas
- ✅ Registrar acciones en bitácora

**¡Felicidades! 🎉**

---

*Desarrollado para NUBA - Skincare Boutique Natural* 🌸
