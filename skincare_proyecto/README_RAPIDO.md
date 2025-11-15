# 🚀 INICIO RÁPIDO - NUBA

## ⚡ 5 Pasos para Empezar

### 1️⃣ Instalar XAMPP
- Descarga: https://www.apachefriends.org/download.html
- Instala y abre el Panel de Control
- Inicia **Apache** y **MySQL**

### 2️⃣ Copiar el Proyecto
```
Copia la carpeta "skincare_proyecto" a:
C:\xampp\htdocs\
```

### 3️⃣ Crear la Base de Datos
1. Abre: `http://localhost/phpmyadmin`
2. Click en pestaña **"SQL"**
3. Copia y pega el contenido de `sql/migracion.sql`
4. Click en **"Continuar"**

### 4️⃣ Probar la Conexión
Abre en tu navegador:
```
http://localhost/skincare_proyecto/php/test-conexion.php
```

Si todo está ✅ verde, ¡estás listo!

### 5️⃣ Usar el Sistema
- **Registro**: `http://localhost/skincare_proyecto/login/registro.html`
- **Login**: `http://localhost/skincare_proyecto/login/login.html`
- **Inicio**: `http://localhost/skincare_proyecto/`

---

## 🎯 Datos de Prueba

Puedes usar estos datos para probar:

**Usuario de Prueba:**
- Email: `test@nuba.com`
- Contraseña: `Test1234!`

---

## ❌ ¿Problemas?

### MySQL no inicia
- Cierra Skype (usa el puerto 3306)
- O cambia el puerto de MySQL en XAMPP

### Error de conexión
1. Verifica que MySQL esté corriendo
2. Revisa `php/config.php`:
   ```php
   define('DB_PASS', ''); // Debe estar vacío
   ```

### Página en blanco
- Abre la consola del navegador (F12)
- Revisa errores en la pestaña "Console"

---

## 📚 Documentación Completa
Lee `GUIA_INSTALACION.md` para más detalles.

---

**¡Listo! 🎉 Ahora tienes un sistema completo de registro/login funcionando.**
