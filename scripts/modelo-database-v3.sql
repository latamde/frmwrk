CREATE DATABASE IF NOT EXISTS `inscripcion`;

CREATE TABLE eventos (
    id_evento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_evento VARCHAR(100),
    fecha DATE,
    ubicacion VARCHAR(100),
    descripcion TEXT
);

CREATE TABLE forms (
    id_form INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    nombre VARCHAR(100),
    correo_electronico VARCHAR(100),
    region VARCHAR(50),
    comuna VARCHAR(50),
    estado VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (correo_electronico),
    FOREIGN KEY (id_evento) REFERENCES Eventos(id_evento)
);

CREATE TABLE pagos (
    id_pago INT AUTO_INCREMENT PRIMARY KEY,
    id_form INT,
    monto DECIMAL(10, 2),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    metodo_pago VARCHAR(50),
    estado VARCHAR(20),
    FOREIGN KEY (id_form) REFERENCES Forms(id_form)
);

CREATE TABLE asistentes (
    id_asistente INT AUTO_INCREMENT PRIMARY KEY,
    id_evento INT,
    id_form INT,
    fecha_asistencia TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    comentarios TEXT,
    FOREIGN KEY (id_evento) REFERENCES Eventos(id_evento),
    FOREIGN KEY (id_form) REFERENCES Forms(id_form)
);
