-- Borrar todas las tablas
DROP TABLE IF EXISTS tokens;
DROP TABLE IF EXISTS postulaciones;
DROP TABLE IF EXISTS alumno_ciclos;
DROP TABLE IF EXISTS ofertas;
DROP TABLE IF EXISTS alumnos;
DROP TABLE IF EXISTS empresas;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS ciclos;
DROP TABLE IF EXISTS usuarios;

-- Crear las tablas

-- Tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla tokens (relación 0,1 con usuarios)
CREATE TABLE IF NOT EXISTS tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    token VARCHAR(255) NOT NULL UNIQUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla ciclos
CREATE TABLE IF NOT EXISTS ciclos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo VARCHAR(50)
);

-- Tabla empresas
CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    cif VARCHAR(20),
    telefono VARCHAR(20),
    sector VARCHAR(100),
    descripcion TEXT,
    pais VARCHAR(50),
    provincia VARCHAR(50),
    ciudad VARCHAR(50),
    direccion VARCHAR(200),
    logo LONGBLOB,
    aprobada TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla alumnos (versión actualizada con campo verificado)
CREATE TABLE IF NOT EXISTS alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE,
    pais VARCHAR(50),
    provincia VARCHAR(50),
    ciudad VARCHAR(50),
    direccion VARCHAR(200),
    codigo_postal VARCHAR(10),
    cv LONGBLOB,
    foto LONGBLOB,
    ciclo_id INT,
    fecha_inicio DATE,
    fecha_fin DATE,
    verificado TINYINT(1) NOT NULL DEFAULT 0
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (ciclo_id) REFERENCES ciclos(id) ON DELETE SET NULL
);

-- Tabla alumno_ciclos (ciclos adicionales)
CREATE TABLE IF NOT EXISTS alumno_ciclos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    ciclo_id INT NOT NULL,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (ciclo_id) REFERENCES ciclos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_alumno_ciclo (alumno_id, ciclo_id)
);

-- Tabla ofertas
CREATE TABLE IF NOT EXISTS ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    requisitos TEXT,
    ciclo_id INT,
    fecha_inicio DATE,
    fecha_cierre DATE,
    modalidad ENUM('presencial', 'remoto', 'hibrido') DEFAULT 'presencial',
    salario DECIMAL(10,2),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE,
    FOREIGN KEY (ciclo_id) REFERENCES ciclos(id) ON DELETE SET NULL
);

-- Tabla postulaciones
CREATE TABLE IF NOT EXISTS postulaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    oferta_id INT NOT NULL,
    estado ENUM('pendiente', 'aceptada', 'rechazada') DEFAULT 'pendiente',
    fecha_postulacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (oferta_id) REFERENCES ofertas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_postulacion (alumno_id, oferta_id)
);

-- ============================================
-- INSERTS DE DATOS
-- ============================================

-- Contraseñas: admin123

-- Ciclos
INSERT INTO ciclos (nombre, codigo) VALUES 
('Desarrollo de Aplicaciones Web', 'DAW'),
('Desarrollo de Aplicaciones Multiplataforma', 'DAM'),
('Administración de Sistemas Informáticos en Red', 'ASIR');

-- Usuario admin: admin@ntryjob.com / admin123
INSERT INTO usuarios (email, password) VALUES 
('admin@ntryjob.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

INSERT INTO admin (usuario_id, nombre) VALUES (1, 'Administrador');

-- Usuarios empresas
INSERT INTO usuarios (email, password) VALUES 
('contacto@techsolutions.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('rrhh@innovasoft.es', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('info@datasystems.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('empleo@webstudio.es', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

-- Empresas
INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, pais, provincia, ciudad, direccion, aprobada) VALUES 
(2, 'TechSolutions SL', 'B12345678', '912345678', 'Tecnología', 'Empresa líder en desarrollo de software empresarial', 'España', 'Madrid', 'Madrid', 'Calle Gran Vía 45', 1),
(3, 'InnovaSoft', 'B87654321', '934567890', 'Desarrollo Web', 'Especialistas en aplicaciones web y mobile', 'España', 'Barcelona', 'Barcelona', 'Avenida Diagonal 123', 1),
(4, 'DataSystems Corp', 'B11223344', '955123456', 'Big Data', 'Soluciones de análisis de datos y cloud computing', 'España', 'Sevilla', 'Sevilla', 'Calle Sierpes 78', 1),
(5, 'WebStudio Creativo', 'B99887766', '963987654', 'Diseño y Desarrollo', 'Agencia digital full-stack', 'España', 'Valencia', 'Valencia', 'Plaza del Ayuntamiento 10', 0);

-- Usuarios alumnos
INSERT INTO usuarios (email, password) VALUES 
('juan.perez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('maria.garcia@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('carlos.lopez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('ana.martinez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('pedro.sanchez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

-- Alumnos
INSERT INTO alumnos (usuario_id, nombre, apellidos, telefono, fecha_nacimiento, pais, provincia, ciudad, direccion, codigo_postal, ciclo_id, fecha_inicio, fecha_fin) VALUES 
(6, 'Juan', 'Pérez García', '611222333', '2002-03-15', 'España', 'Madrid', 'Madrid', 'Calle Alcalá 100', '28009', 1, '2024-09-01', '2026-06-30'),
(7, 'María', 'García López', '622333444', '2001-07-22', 'España', 'Barcelona', 'Barcelona', 'Paseo de Gracia 50', '08007', 1, '2024-09-01', '2026-06-30'),
(8, 'Carlos', 'López Martínez', '633444555', '2003-01-10', 'España', 'Madrid', 'Alcalá de Henares', 'Calle Mayor 25', '28801', 2, '2024-09-01', '2026-06-30'),
(9, 'Ana', 'Martínez Rodríguez', '644555666', '2002-11-05', 'España', 'Valencia', 'Valencia', 'Calle Colón 8', '46004', 3, '2023-09-01', '2025-06-30'),
(10, 'Pedro', 'Sánchez Fernández', '655666777', '2001-09-18', 'España', 'Sevilla', 'Sevilla', 'Avenida de la Constitución 15', '41001', 2, '2023-09-01', '2025-06-30');

-- Ciclos adicionales
INSERT INTO alumno_ciclos (alumno_id, ciclo_id) VALUES 
(1, 2),
(2, 3),
(3, 1),
(3, 3);

-- Ofertas
INSERT INTO ofertas (empresa_id, titulo, descripcion, requisitos, ciclo_id, fecha_inicio, fecha_cierre, modalidad, salario) VALUES 
(1, 'Desarrollador Full Stack Junior', 'Buscamos desarrollador para integrar en nuestro equipo de desarrollo web. Trabajarás con React, Node.js y MongoDB.', 'Conocimientos en JavaScript, HTML, CSS. Valorable experiencia con frameworks modernos', 1, '2025-02-01', '2025-12-31', 'hibrido', 18000.00),
(1, 'Administrador de Sistemas en Prácticas', 'Prácticas en departamento de sistemas. Aprenderás sobre redes, servidores Linux y Windows Server.', 'Conocimientos básicos de redes y sistemas operativos', 3, '2025-03-01', '2025-09-30', 'presencial', 12000.00),
(2, 'Desarrollador Frontend React', 'Desarrollo de interfaces de usuario modernas con React y TypeScript.', 'React, TypeScript, CSS3, Git. Valorable conocimiento de Next.js', 1, '2025-02-15', '2025-11-30', 'remoto', 20000.00),
(2, 'Desarrollador Mobile Flutter', 'Desarrollo de aplicaciones móviles multiplataforma con Flutter.', 'Dart, Flutter, conocimientos de Android/iOS', 2, '2025-03-01', '2025-10-31', 'hibrido', 19000.00),
(3, 'Analista de Datos Junior', 'Análisis de datos y creación de dashboards con Power BI y Python.', 'Python, SQL, conocimientos de estadística', 2, '2025-02-01', '2025-08-31', 'presencial', 21000.00),
(3, 'DevOps en Prácticas', 'Aprendizaje de CI/CD, Docker, Kubernetes y AWS.', 'Linux, scripting básico, interés en DevOps', 3, '2025-04-01', '2025-12-31', 'hibrido', 15000.00),
(4, 'Diseñador Web y Desarrollador Frontend', 'Diseño y desarrollo de sitios web corporativos.', 'HTML, CSS, JavaScript, Figma o Adobe XD', 1, '2025-02-20', '2025-09-30', 'presencial', 17000.00);

-- Postulaciones
INSERT INTO postulaciones (alumno_id, oferta_id, estado) VALUES 
(1, 1, 'pendiente'),
(1, 3, 'aceptada'),
(2, 1, 'pendiente'),
(2, 7, 'rechazada'),
(3, 4, 'pendiente'),
(3, 5, 'aceptada'),
(4, 2, 'pendiente'),
(4, 6, 'pendiente'),
(5, 4, 'rechazada'),
(5, 5, 'pendiente');
