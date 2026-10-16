CREATE DATABASE IF NOT EXISTS ecommerce_modelo_vacio
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE ecommerce_modelo_vacio;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categories (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  description VARCHAR(180) NOT NULL DEFAULT '',
  sort_order SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE KEY categories_name_unique (name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS products (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  category_id INT UNSIGNED NOT NULL,
  name VARCHAR(160) NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(12,2) NOT NULL DEFAULT 0,
  image_url VARCHAR(2048) NOT NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY products_category_active (category_id, is_active),
  CONSTRAINT products_category_fk FOREIGN KEY (category_id) REFERENCES categories (id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO users (name, email, password_hash, role)
VALUES ('Administracion', 'admin@tienda.local', '$2y$10$kUsDWEYmYVlnmFDbhxRtR.hwL101d8.CHBtGx/.v8dV7a1M9MgGOy', 'admin')
ON DUPLICATE KEY UPDATE email = VALUES(email);

INSERT IGNORE INTO categories (name, description, sort_order) VALUES
('General', 'Productos principales de la tienda', 1),
('Novedades', 'Articulos nuevos y recientes', 2),
('Destacados', 'Productos seleccionados por el negocio', 3);
