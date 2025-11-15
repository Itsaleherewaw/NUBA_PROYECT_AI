-- =====================================
-- DATOS DE EJEMPLO PARA NUBA
-- =====================================
-- Ejecuta este archivo DESPUÉS de migracion.sql
-- para tener datos de prueba en tu base de datos

USE nuba_db;

-- =====================================
-- USUARIOS DE EJEMPLO
-- =====================================
-- Contraseña para todos: Test1234!
-- Hash generado con password_hash('Test1234!', PASSWORD_BCRYPT)

INSERT INTO usuarios (nombre, apellido, email, telefono, direccion, password_hash, rol, estado) VALUES
('María', 'García', 'maria@test.com', '+591 70514802', 'Av. Principal 123, La Paz', '$2y$12$LQv3c1ydemgWZ8hSBxVCeOeH69YaBdZHWq6l7mFkl6pX7KFvdCKlO', 'cliente', 'activo'),
('Ana', 'López', 'ana@test.com', '+591 71234567', 'Calle Secundaria 456, Santa Cruz', '$2y$12$LQv3c1ydemgWZ8hSBxVCeOeH69YaBdZHWq6l7mFkl6pX7KFvdCKlO', 'cliente', 'activo'),
('Admin', 'NUBA', 'admin@nuba.com', '+591 70000000', 'Oficina Central', '$2y$12$LQv3c1ydemgWZ8hSBxVCeOeH69YaBdZHWq6l7mFkl6pX7KFvdCKlO', 'admin', 'activo'),
('Laura', 'Martínez', 'laura@test.com', '+591 72345678', 'Zona Sur 789, Cochabamba', '$2y$12$LQv3c1ydemgWZ8hSBxVCeOeH69YaBdZHWq6l7mFkl6pX7KFvdCKlO', 'cliente', 'activo'),
('Sofia', 'Rodríguez', 'sofia@test.com', '+591 73456789', 'Centro 321, Tarija', '$2y$12$LQv3c1ydemgWZ8hSBxVCeOeH69YaBdZHWq6l7mFkl6pX7KFvdCKlO', 'cliente', 'activo');

-- =====================================
-- CATEGORÍAS DE PRODUCTOS
-- =====================================

INSERT INTO categorias (nombre) VALUES
('Limpiadores'),
('Serums'),
('Cremas Hidratantes'),
('Protectores Solares'),
('Aceites Faciales'),
('Mascarillas'),
('Exfoliantes'),
('Contorno de Ojos');

-- =====================================
-- PRODUCTOS
-- =====================================

INSERT INTO productos (nombre, descripcion, precio, stock, imagen, categoria_id) VALUES
-- Limpiadores
('Limpiador Suave Daily', 'Limpiador espumoso sin sulfatos, limpia en profundidad sin resecar. Ideal para uso diario.', 79.50, 50, 'prod3.png', 1),
('Gel Limpiador Purificante', 'Gel limpiador con ácido salicílico para piel grasa y propensa al acné.', 89.00, 35, 'limpiador2.png', 1),

-- Serums
('Sérum Hidratante Vital', 'Ácido hialurónico + niacinamida. Apto para todo tipo de piel. Hidratación profunda.', 149.90, 40, 'prod2.png', 2),
('Sérum Vitamina C Glow', 'Sérum iluminador con vitamina C pura al 15%. Reduce manchas y unifica el tono.', 169.00, 30, 'serum2.png', 2),
('Sérum Anti-Edad Retinol', 'Retinol encapsulado 0.5% para reducir arrugas y líneas de expresión.', 189.00, 25, 'serum3.png', 2),

-- Cremas Hidratantes
('Crema Nutritiva Night', 'Crema reparadora nocturna con ceramidas y vitaminas. Regenera mientras duermes.', 119.00, 45, 'prod4.png', 3),
('Crema Hidratante Ligera', 'Textura gel-crema para piel mixta y grasa. Hidratación sin grasa.', 99.00, 55, 'crema2.png', 3),
('Crema Rica Comfort', 'Crema ultra nutritiva para piel seca. Con manteca de karité y aceite de argán.', 129.00, 40, 'crema3.png', 3),

-- Protectores Solares
('Protector Solar Mineral 50', 'FPS 50, acabado ligero, ideal para uso diario. Protección de amplio espectro.', 99.00, 60, 'prod5.png', 4),
('Protector Solar Toque Seco', 'FPS 50+ con acabado mate. Perfecto para piel grasa.', 109.00, 50, 'solar2.png', 4),

-- Aceites Faciales
('Aceite Facial Calm', 'Mezcla de aceites botánicos para calmar la piel sensible y rojeces.', 89.90, 35, 'prod1.png', 5),
('Aceite Nutritivo Noche', 'Aceite facial con rosa mosqueta y vitamina E. Regeneración nocturna.', 95.00, 30, 'aceite2.png', 5),

-- Mascarillas
('Mascarilla Purificante Arcilla', 'Arcilla verde y carbón activado. Limpieza profunda de poros.', 69.00, 45, 'mascarilla1.png', 6),
('Mascarilla Hidratante Overnight', 'Mascarilla de noche con ácido hialurónico. Despierta con piel radiante.', 79.00, 40, 'mascarilla2.png', 6),

-- Exfoliantes
('Exfoliante Enzimático Suave', 'Exfoliante químico con enzimas de papaya. Sin micropartículas.', 75.00, 38, 'exfoliante1.png', 7),
('Peeling Químico AHA/BHA', 'Tratamiento exfoliante con ácidos. Renueva la piel.', 95.00, 28, 'exfoliante2.png', 7),

-- Contorno de Ojos
('Contorno de Ojos Anti-Fatiga', 'Reduce ojeras y bolsas. Con cafeína y vitamina K.', 85.00, 42, 'ojos1.png', 8),
('Contorno de Ojos Anti-Edad', 'Con retinol y péptidos. Reduce arrugas y líneas finas.', 99.00, 35, 'ojos2.png', 8);

-- =====================================
-- BITÁCORA DE EJEMPLO
-- =====================================

INSERT INTO bitacora (usuario_id, accion) VALUES
(1, 'Usuario registrado: maria@test.com'),
(1, 'Login exitoso'),
(2, 'Usuario registrado: ana@test.com'),
(3, 'Usuario registrado: admin@nuba.com'),
(3, 'Login exitoso'),
(1, 'Visualizó catálogo de productos'),
(2, 'Login exitoso');

-- =====================================
-- VERIFICACIÓN
-- =====================================

-- Contar registros insertados
SELECT 'Usuarios creados:' as Info, COUNT(*) as Total FROM usuarios
UNION ALL
SELECT 'Categorías creadas:', COUNT(*) FROM categorias
UNION ALL
SELECT 'Productos creados:', COUNT(*) FROM productos
UNION ALL
SELECT 'Registros en bitácora:', COUNT(*) FROM bitacora;

-- =====================================
-- INFORMACIÓN IMPORTANTE
-- =====================================
-- 
-- CREDENCIALES DE PRUEBA:
-- 
-- Cliente 1:
--   Email: maria@test.com
--   Contraseña: Test1234!
-- 
-- Cliente 2:
--   Email: ana@test.com
--   Contraseña: Test1234!
-- 
-- Administrador:
--   Email: admin@nuba.com
--   Contraseña: Test1234!
-- 
-- =====================================
