# 🏗️ ARQUITECTURA DEL SISTEMA - NUBA

## 📐 Diagrama de Flujo del Sistema

```
┌─────────────────────────────────────────────────────────────┐
│                    USUARIO (Navegador)                       │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                  FRONTEND (HTML/CSS/JS)                      │
├─────────────────────────────────────────────────────────────┤
│  • login.html          → Formulario de inicio de sesión     │
│  • registro.html       → Formulario de registro             │
│  • index.html          → Página principal                   │
│  • dashboards/*.html   → Paneles de usuario                 │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ (Fetch API / AJAX)
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                   BACKEND (PHP)                              │
├─────────────────────────────────────────────────────────────┤
│  • config.php          → Configuración y conexión BD        │
│  • registro.php        → API de registro                    │
│  • login.php           → API de autenticación               │
│  • logout.php          → API de cierre de sesión            │
│  • verificar-sesion.php → Verificar estado de sesión        │
└─────────────────────┬───────────────────────────────────────┘
                      │
                      │ (PDO)
                      ▼
┌─────────────────────────────────────────────────────────────┐
│                BASE DE DATOS (MySQL)                         │
├─────────────────────────────────────────────────────────────┤
│  • usuarios            → Datos de usuarios                  │
│  • productos           → Catálogo de productos              │
│  • categorias          → Categorías de productos            │
│  • carrito             → Carrito de compras                 │
│  • ordenes             → Órdenes de compra                  │
│  • orden_detalle       → Detalle de órdenes                 │
│  • bitacora            → Registro de actividades            │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔄 Flujo de Registro de Usuario

```
1. Usuario llena formulario (registro.html)
   ↓
2. JavaScript valida datos en el cliente
   ↓
3. Envía datos a registro.php (POST JSON)
   ↓
4. PHP valida datos en el servidor
   ↓
5. Verifica que el email no exista
   ↓
6. Encripta la contraseña (password_hash)
   ↓
7. Inserta usuario en la BD
   ↓
8. Registra acción en bitácora
   ↓
9. Retorna respuesta JSON
   ↓
10. JavaScript redirige a login.html
```

---

## 🔐 Flujo de Login

```
1. Usuario ingresa credenciales (login.html)
   ↓
2. JavaScript envía datos a login.php (POST JSON)
   ↓
3. PHP busca usuario por email
   ↓
4. Verifica que el usuario exista y esté activo
   ↓
5. Compara contraseña (password_verify)
   ↓
6. Si es correcto: Crea sesión PHP
   ↓
7. Guarda datos en $_SESSION
   ↓
8. Registra login en bitácora
   ↓
9. Retorna respuesta JSON con dashboard según rol
   ↓
10. JavaScript redirige al dashboard correspondiente
```

---

## 🗄️ Modelo de Datos

### Tabla: usuarios
```sql
usuarios
├── idusuario (PK)
├── nombre
├── apellido
├── email (UNIQUE)
├── telefono
├── direccion
├── password_hash
├── rol (cliente/admin)
├── estado (activo/inactivo)
└── fecha_registro
```

### Relaciones
```
usuarios (1) ──────── (N) carrito
usuarios (1) ──────── (N) ordenes
usuarios (1) ──────── (N) bitacora

productos (1) ──────── (N) carrito
productos (N) ──────── (1) categorias
productos (1) ──────── (N) orden_detalle

ordenes (1) ──────── (N) orden_detalle
```

---

## 🔒 Seguridad Implementada

### 1. Contraseñas
- ✅ Hash con `password_hash()` (BCRYPT, cost 12)
- ✅ Verificación con `password_verify()`
- ✅ Nunca se almacenan en texto plano

### 2. SQL Injection
- ✅ Prepared Statements (PDO)
- ✅ Parámetros vinculados
- ✅ Sin concatenación de SQL

### 3. Sesiones
- ✅ `session.cookie_httponly = 1`
- ✅ `session.use_only_cookies = 1`
- ✅ Timeout de sesión configurado

### 4. Validación
- ✅ Validación en cliente (JavaScript)
- ✅ Validación en servidor (PHP)
- ✅ Sanitización de datos

### 5. Headers HTTP
- ✅ Content-Type: application/json
- ✅ CORS configurado
- ✅ Códigos de estado HTTP apropiados

---

## 📡 API Endpoints

### POST /php/registro.php
**Request:**
```json
{
  "firstName": "María",
  "lastName": "García",
  "email": "maria@test.com",
  "phone": "+591 70514802",
  "password": "Test1234!",
  "newsletter": true
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "¡Cuenta creada exitosamente!",
  "data": {
    "id": 1,
    "nombre": "María",
    "apellido": "García",
    "email": "maria@test.com"
  }
}
```

**Response (Error):**
```json
{
  "success": false,
  "message": "Este correo electrónico ya está registrado"
}
```

---

### POST /php/login.php
**Request:**
```json
{
  "email": "maria@test.com",
  "password": "Test1234!",
  "remember": true
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "¡Bienvenida a NUBA!",
  "data": {
    "id": 1,
    "nombre": "María",
    "apellido": "García",
    "email": "maria@test.com",
    "rol": "cliente",
    "dashboard": "../dashboards/cliente.html"
  }
}
```

**Response (Error):**
```json
{
  "success": false,
  "message": "Credenciales incorrectas"
}
```

---

### GET /php/verificar-sesion.php
**Response (Logueado):**
```json
{
  "success": true,
  "logueado": true,
  "usuario": {
    "id": 1,
    "nombre": "María",
    "apellido": "García",
    "email": "maria@test.com",
    "rol": "cliente"
  }
}
```

**Response (No logueado):**
```json
{
  "success": true,
  "logueado": false,
  "usuario": null
}
```

---

### GET /php/logout.php
**Response:**
```json
{
  "success": true,
  "message": "Sesión cerrada exitosamente"
}
```

---

## 🎨 Stack Tecnológico

### Frontend
- **HTML5** - Estructura
- **CSS3** - Estilos (con variables CSS)
- **JavaScript (ES6+)** - Lógica del cliente
- **Fetch API** - Comunicación con backend
- **Bootstrap 5.3.2** - Framework CSS
- **Google Fonts** - Tipografías (Playfair Display, Inter)

### Backend
- **PHP 7.4+** - Lenguaje del servidor
- **PDO** - Capa de abstracción de base de datos
- **JSON** - Formato de intercambio de datos
- **Sessions** - Manejo de estado

### Base de Datos
- **MySQL 5.7+** - Sistema de gestión de BD
- **InnoDB** - Motor de almacenamiento
- **UTF-8** - Codificación de caracteres

### Servidor
- **Apache 2.4** - Servidor web
- **XAMPP** - Paquete de desarrollo

---

## 📊 Códigos de Estado HTTP

| Código | Significado | Uso en NUBA |
|--------|-------------|-------------|
| 200 | OK | Login exitoso |
| 201 | Created | Usuario registrado |
| 400 | Bad Request | Datos inválidos |
| 401 | Unauthorized | Credenciales incorrectas |
| 403 | Forbidden | Usuario inactivo |
| 405 | Method Not Allowed | Método HTTP incorrecto |
| 409 | Conflict | Email ya registrado |
| 500 | Internal Server Error | Error del servidor |

---

## 🔄 Estados de Sesión

```
┌──────────────┐
│   No Login   │
└──────┬───────┘
       │
       │ Login exitoso
       ▼
┌──────────────┐
│   Logueado   │ ◄──┐
└──────┬───────┘    │
       │            │ Actividad
       │            │
       │ Timeout    │
       │ o Logout   │
       ▼            │
┌──────────────┐    │
│   Expirado   │────┘
└──────────────┘
```

---

## 🚀 Escalabilidad Futura

### Mejoras Recomendadas:

1. **Autenticación**
   - OAuth 2.0 (Google, Facebook)
   - JWT (JSON Web Tokens)
   - Autenticación de dos factores (2FA)

2. **Base de Datos**
   - Índices en campos frecuentes
   - Caché (Redis/Memcached)
   - Replicación master-slave

3. **Seguridad**
   - HTTPS obligatorio
   - Rate limiting
   - CAPTCHA en formularios
   - Logs de seguridad

4. **Performance**
   - CDN para assets estáticos
   - Compresión GZIP
   - Lazy loading de imágenes
   - Minificación de CSS/JS

5. **Funcionalidades**
   - Recuperación de contraseña
   - Verificación de email
   - Perfil de usuario editable
   - Sistema de roles avanzado

---

## 📝 Convenciones de Código

### PHP
- Nombres de archivos: `kebab-case.php`
- Funciones: `camelCase()`
- Constantes: `UPPER_SNAKE_CASE`
- Clases: `PascalCase`

### JavaScript
- Variables: `camelCase`
- Constantes: `UPPER_SNAKE_CASE`
- Funciones: `camelCase()`
- Async/await para promesas

### SQL
- Tablas: `snake_case` (plural)
- Columnas: `snake_case`
- Primary keys: `id{tabla}`
- Foreign keys: `{tabla}_id`

### CSS
- Clases: `kebab-case`
- IDs: `camelCase`
- Variables CSS: `--kebab-case`

---

## 🧪 Testing

### Checklist de Pruebas:

- [ ] Registro con datos válidos
- [ ] Registro con email duplicado
- [ ] Registro con contraseña débil
- [ ] Login con credenciales correctas
- [ ] Login con credenciales incorrectas
- [ ] Login con usuario inactivo
- [ ] Verificar sesión activa
- [ ] Verificar sesión expirada
- [ ] Logout exitoso
- [ ] Protección contra SQL injection
- [ ] Validación de campos vacíos
- [ ] Validación de formato de email
- [ ] Encriptación de contraseñas
- [ ] Registro en bitácora

---

*Documentación técnica - NUBA Skincare Boutique Natural* 🌸
