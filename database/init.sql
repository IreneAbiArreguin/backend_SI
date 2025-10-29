CREATE DATABASE IF NOT EXISTS monitoreo_inundaciones
  CHARACTER SET = 'utf8mb4'
  COLLATE = 'utf8mb4_unicode_ci';
USE monitoreo_inundaciones;

SET sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
SET time_zone = '+00:00';


CREATE TABLE roles (
  id_rol TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL UNIQUE,
  descripcion VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE estados_reporte (
  id_estado TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL UNIQUE,
  descripcion VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE estados_refugio (
  id_estado_refugio TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL UNIQUE,
  descripcion VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE niveles_riesgo (
  id_nivel TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL UNIQUE,
  descripcion VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE municipios (
  id_municipio SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL UNIQUE,
  codigo_inegi VARCHAR(20)
) ENGINE=InnoDB;

CREATE TABLE refugios_servicios (
  id_servicio INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE,
  descripcion VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE usuarios (
  id_usuario INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  apellido VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  telefono VARCHAR(20) NULL,
  ubicacion VARCHAR(100) NULL,
  latitud DECIMAL(10, 8) NULL,
  longitud DECIMAL(11, 8) NULL,
  email_verificado_at TIMESTAMP NULL,
  id_rol TINYINT UNSIGNED NOT NULL,
  remember_token VARCHAR(100) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX idx_usuarios_ubicacion (latitud, longitud)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE refugios (
  id_refugio INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  direccion TEXT NOT NULL,
  capacidad_total INT UNSIGNED NOT NULL,
  capacidad_actual INT UNSIGNED NOT NULL DEFAULT 0,
  id_municipio SMALLINT UNSIGNED,
  estado_refugio_id TINYINT UNSIGNED NOT NULL,
  telefono_contacto VARCHAR(30),
  responsable VARCHAR(120),
  latitud DECIMAL(10, 8) NOT NULL,
  longitud DECIMAL(11, 8) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (estado_refugio_id) REFERENCES estados_refugio(id_estado_refugio)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  INDEX idx_refugios_ubicacion (latitud, longitud),
  INDEX idx_refugios_municipio (id_municipio)
) ENGINE=InnoDB;


CREATE TABLE refugios_servicios_rel (
  id_rel INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_refugio INT UNSIGNED NOT NULL,
  id_servicio INT UNSIGNED NOT NULL,
  disponible BOOLEAN NOT NULL DEFAULT TRUE,
  FOREIGN KEY (id_refugio) REFERENCES refugios(id_refugio)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_servicio) REFERENCES refugios_servicios(id_servicio)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  UNIQUE KEY uq_refugio_servicio (id_refugio, id_servicio)
) ENGINE=InnoDB;

CREATE TABLE reportes_inundacion (
  id_reporte BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT UNSIGNED,
  id_municipio SMALLINT UNSIGNED,
  estado_reporte_id TINYINT UNSIGNED NOT NULL,
  nivel_afectacion VARCHAR(50),
  metodo_origen VARCHAR(30) NOT NULL,
  fecha_suceso TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  prioridad TINYINT UNSIGNED DEFAULT 2,
  calle_principal VARCHAR(150),
  cruzamiento1 VARCHAR(150),
  cruzamiento2 VARCHAR(150),
  colonia VARCHAR(100),
  cp VARCHAR(10),
  descripcion TEXT,
  latitud DECIMAL(10, 8) NOT NULL,
  longitud DECIMAL(11, 8) NOT NULL,
  verificado_por INT UNSIGNED DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (estado_reporte_id) REFERENCES estados_reporte(id_estado)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY (verificado_por) REFERENCES usuarios(id_usuario)
    ON DELETE SET NULL ON UPDATE CASCADE,
  INDEX idx_reportes_ubicacion (latitud, longitud),
  INDEX idx_reportes_fecha (fecha_suceso),
  INDEX idx_reportes_prioridad (prioridad)
) ENGINE=InnoDB;


CREATE TABLE historico_reportes (
  id_historico BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_reporte BIGINT UNSIGNED NOT NULL,
  id_usuario INT UNSIGNED,
  estado_anterior TINYINT UNSIGNED,
  estado_nuevo TINYINT UNSIGNED,
  comentario TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_reporte) REFERENCES reportes_inundacion(id_reporte)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;