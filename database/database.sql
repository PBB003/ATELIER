-- =====================================================================
--  ATELIER - Base de datos relacional (Fase 3: Backend)
--  Dominio: moda / e-commerce
--  Motor: MySQL / MariaDB (compatible con XAMPP, WampServer, AppServ)
-- =====================================================================
--  Cómo usar este archivo:
--  1. Abre phpMyAdmin (http://localhost/phpmyadmin)
--  2. Ve a la pestaña "SQL"
--  3. Pega TODO este archivo y presiona "Continuar" / "Go"
--     (esto crea la base de datos, las tablas y los datos de prueba)
-- =====================================================================

-- 1. Crear la base de datos
CREATE DATABASE IF NOT EXISTS atelier_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE atelier_db;

-- =====================================================================
-- 2. Tabla: usuarios
--    Guarda las cuentas que pueden iniciar sesión (clientes y admins)
-- =====================================================================
CREATE TABLE usuarios (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  nombre          VARCHAR(100)  NOT NULL,
  email           VARCHAR(150)  NOT NULL UNIQUE,
  password        VARCHAR(255)  NOT NULL,        -- SIEMPRE hash (password_hash de PHP), nunca texto plano
  rol             ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
  fecha_registro  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 3. Tabla: categorias
--    Clasifica los productos (ej. Camisas, Vestidos, Accesorios)
-- =====================================================================
CREATE TABLE categorias (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  nombre       VARCHAR(100) NOT NULL,
  descripcion  VARCHAR(255)
) ENGINE=InnoDB;

-- =====================================================================
-- 4. Tabla: productos  (ENTIDAD PRINCIPAL para el CRUD)
--    Cada producto pertenece a una categoría (FOREIGN KEY)
-- =====================================================================
CREATE TABLE productos (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  nombre           VARCHAR(150)   NOT NULL,
  descripcion      TEXT,
  precio           DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
  stock            INT            NOT NULL DEFAULT 0,
  talla            VARCHAR(20),          -- S, M, L, XL, talla numérica, etc.
  color            VARCHAR(50),
  imagen           VARCHAR(255),         -- ruta o nombre del archivo de imagen
  categoria_id     INT NOT NULL,
  fecha_creacion   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_producto_categoria
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================================
-- 5. Tabla: mensajes_contacto
--    Mensajes enviados desde el formulario de contacto
-- =====================================================================
CREATE TABLE mensajes_contacto (
  id_mensaje   INT AUTO_INCREMENT PRIMARY KEY,
  nombre       VARCHAR(100) NOT NULL,
  email        VARCHAR(150) NOT NULL,
  telefono     VARCHAR(20)  NULL,
  asunto       VARCHAR(50)  NOT NULL,
  canal        VARCHAR(20)  NULL,
  mensaje      TEXT         NOT NULL,
  boletin      TINYINT(1)   NOT NULL DEFAULT 0,
  leido        TINYINT(1)   NOT NULL DEFAULT 0,
  creado_en    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================================
-- 7. DATOS SEMILLA (seeds) - para poder probar login y CRUD de inmediato
-- =====================================================================

-- Usuarios de prueba
-- OJO: estas contraseñas YA están encriptadas con password_hash() de PHP
--   admin@atelier.com    -> contraseña real: admin123
--   cliente@atelier.com  -> contraseña real: cliente123
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Admin ATELIER', 'admin@atelier.com',
 '$2b$10$acjbhF/FA.4tRkHFIXSeA.7FfOAvIF9seVqbbkFtLSyTDKPsj/qSe', 'admin'),
('Cliente Demo', 'cliente@atelier.com',
 '$2b$10$zTQubJlRorV3dqeeY8Rkb.QvBidWTTvMroqa5CffvHCR5OygoPscu', 'cliente');

-- Categorías
INSERT INTO categorias (nombre, descripcion) VALUES
('Camisas', 'Camisas y blusas para toda ocasión'),
('Pantalones', 'Pantalones, jeans y shorts'),
('Vestidos', 'Vestidos casuales y de fiesta'),
('Accesorios', 'Bolsos, cinturones y bisutería');

-- Productos
INSERT INTO productos (nombre, descripcion, precio, stock, talla, color, imagen, categoria_id) VALUES
('Camisa Oxford Clásica', 'Camisa de algodón manga larga', 850.00, 20, 'M', 'Blanco', 'camisa-oxford.jpg', 1),
('Blusa Floral', 'Blusa ligera estampada', 650.00, 15, 'S', 'Multicolor', 'blusa-floral.jpg', 1),
('Jean Slim Fit', 'Jean corte entallado', 1200.00, 30, '32', 'Azul', 'jean-slim.jpg', 2),
('Vestido de Noche', 'Vestido elegante para eventos', 2500.00, 8, 'M', 'Negro', 'vestido-noche.jpg', 3),
('Bolso de Cuero', 'Bolso de mano tipo tote', 1800.00, 10, 'Único', 'Café', 'bolso-cuero.jpg', 4);

-- Mensajes de contacto de prueba
INSERT INTO mensajes_contacto
  (nombre, email, telefono, asunto, canal, mensaje, boletin, leido)
VALUES
  ('Ana Torres', 'ana.torres@example.com', '8091234567', 'tallas', 'email',
   'Necesito ayuda para elegir la talla correcta.', 1, 0),
  ('Carlos Méndez', 'carlos.mendez@example.com', NULL, 'pedido', 'whatsapp',
   'Quisiera consultar el estado de mi pedido.', 0, 0);

-- =====================================================================
-- Fin del script. Verifica en phpMyAdmin que aparezcan las 5 tablas
-- dentro de la base de datos "atelier_db" con sus filas de ejemplo.
-- =====================================================================
