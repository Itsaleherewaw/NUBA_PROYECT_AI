-- CREACIÓN DE BASE DE DATOS
CREATE DATABASE IF NOT EXISTS nuba_db;
USE nuba_db;

-- =====================================
-- TABLA USUARIOS (registro y login)
-- =====================================
CREATE TABLE IF NOT EXISTS usuarios (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('cliente','admin') DEFAULT 'cliente',
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================
-- TABLA PRODUCTOS
-- =====================================
CREATE TABLE IF NOT EXISTS productos (
    idproducto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    imagen VARCHAR(200),
    categoria_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================================
-- TABLA CATEGORÍAS
-- =====================================
CREATE TABLE IF NOT EXISTS categorias (
    idcategoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL
);

ALTER TABLE productos
ADD CONSTRAINT fk_producto_categoria
FOREIGN KEY (categoria_id) REFERENCES categorias(idcategoria);

-- =====================================
-- TABLA CARRITO
-- =====================================
CREATE TABLE IF NOT EXISTS carrito (
    idcarrito INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1
);

ALTER TABLE carrito
ADD CONSTRAINT fk_carrito_usuario
FOREIGN KEY (usuario_id) REFERENCES usuarios(idusuario);

ALTER TABLE carrito
ADD CONSTRAINT fk_carrito_producto
FOREIGN KEY (producto_id) REFERENCES productos(idproducto);

-- =====================================
-- TABLA ÓRDENES
-- =====================================
CREATE TABLE IF NOT EXISTS ordenes (
    idorden INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    estado ENUM('pendiente','pagado','cancelado','enviado','entregado')
           DEFAULT 'pendiente',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE ordenes
ADD CONSTRAINT fk_orden_usuario
FOREIGN KEY (usuario_id) REFERENCES usuarios(idusuario);

-- =====================================
-- TABLA DETALLE DE ÓRDENES
-- =====================================
CREATE TABLE IF NOT EXISTS orden_detalle (
    iddetalle INT AUTO_INCREMENT PRIMARY KEY,
    orden_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL
);

ALTER TABLE orden_detalle
ADD CONSTRAINT fk_detalle_orden
FOREIGN KEY (orden_id) REFERENCES ordenes(idorden);

ALTER TABLE orden_detalle
ADD CONSTRAINT fk_detalle_producto
FOREIGN KEY (producto_id) REFERENCES productos(idproducto);

-- =====================================
-- TABLA BITÁCORA
-- =====================================

CREATE TABLE IF NOT EXISTS bitacora (
    idbitacora INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    accion VARCHAR(200),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE bitacora
ADD CONSTRAINT fk_bitacora_usuario
FOREIGN KEY (usuario_id) REFERENCES usuarios(idusuario);
