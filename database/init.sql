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
    verificado TINYINT(1) NOT NULL DEFAULT 0,
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
    verificado TINYINT(1) NOT NULL DEFAULT 0,
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

-- ============================================
-- CICLOS FORMATIVOS
-- ============================================

-- FP BÁSICA - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º FP Básica en Informática y Comunicaciones', 'FPB-IFC-1'),
('2º FP Básica en Informática y Comunicaciones', 'FPB-IFC-2'),
('1º FP Básica en Informática de Oficina', 'FPB-IO-1'),
('2º FP Básica en Informática de Oficina', 'FPB-IO-2');

-- GRADO MEDIO - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Sistemas Microinformáticos y Redes', 'SMR-1'),
('2º Sistemas Microinformáticos y Redes', 'SMR-2');

-- GRADO SUPERIOR - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Desarrollo de Aplicaciones Web', 'DAW-1'),
('2º Desarrollo de Aplicaciones Web', 'DAW-2'),
('1º Desarrollo de Aplicaciones Multiplataforma', 'DAM-1'),
('2º Desarrollo de Aplicaciones Multiplataforma', 'DAM-2'),
('1º Administración de Sistemas Informáticos en Red', 'ASIR-1'),
('2º Administración de Sistemas Informáticos en Red', 'ASIR-2');

-- CURSOS DE ESPECIALIZACIÓN - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Ciberseguridad en Entornos de las Tecnologías de la Información', 'CE-CIBERTI'),
('Inteligencia Artificial y Big Data', 'CE-IABD'),
('Desarrollo de Videojuegos y Realidad Virtual', 'CE-DVRV'),
('Desarrollo Web en Entorno Servidor', 'CE-DWES');

-- FP BÁSICA - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º FP Básica en Servicios Administrativos', 'FPB-SA-1'),
('2º FP Básica en Servicios Administrativos', 'FPB-SA-2');

-- GRADO MEDIO - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Gestión Administrativa', 'GA-1'),
('2º Gestión Administrativa', 'GA-2');

-- GRADO SUPERIOR - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Administración y Finanzas', 'AF-1'),
('2º Administración y Finanzas', 'AF-2'),
('1º Asistencia a la Dirección', 'AD-1'),
('2º Asistencia a la Dirección', 'AD-2');

-- CURSOS DE ESPECIALIZACIÓN - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('Digitalización Aplicada a los Sectores Productivos', 'CE-DASP'),
('Gestión Avanzada de la Información Legal', 'CE-GAIL');

-- GRADO MEDIO - HIGIENE BUCODENTAL
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Cuidados Auxiliares de Enfermería', 'CAE-1'),
('2º Cuidados Auxiliares de Enfermería', 'CAE-2');

-- GRADO SUPERIOR - HIGIENE BUCODENTAL
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Higiene Bucodental', 'HB-1'),
('2º Higiene Bucodental', 'HB-2'),
('1º Prótesis Dentales', 'PD-1'),
('2º Prótesis Dentales', 'PD-2');

-- CURSOS DE ESPECIALIZACIÓN - HIGIENE BUCODENTAL
INSERT INTO ciclos (nombre, codigo) VALUES 
('Ortodoncia y Ortopedia Dentofacial', 'CE-OOD');

-- FP BÁSICA - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º FP Básica en Fabricación y Montaje', 'FPB-FM-1'),
('2º FP Básica en Fabricación y Montaje', 'FPB-FM-2'),
('1º FP Básica en Mantenimiento de Vehículos', 'FPB-MV-1'),
('2º FP Básica en Mantenimiento de Vehículos', 'FPB-MV-2');

-- GRADO MEDIO - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Electromecánica de Vehículos Automóviles', 'EVA-1'),
('2º Electromecánica de Vehículos Automóviles', 'EVA-2'),
('1º Carrocería', 'CAR-1'),
('2º Carrocería', 'CAR-2'),
('1º Mecanizado', 'MEC-1'),
('2º Mecanizado', 'MEC-2');

-- GRADO SUPERIOR - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Automoción', 'AUT-1'),
('2º Automoción', 'AUT-2'),
('1º Mantenimiento Aeromecánico de Aviones con Motor de Turbina', 'MAAMT-1'),
('2º Mantenimiento Aeromecánico de Aviones con Motor de Turbina', 'MAAMT-2'),
('1º Programación de la Producción en Fabricación Mecánica', 'PPFM-1'),
('2º Programación de la Producción en Fabricación Mecánica', 'PPFM-2');

-- CURSOS DE ESPECIALIZACIÓN - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Mantenimiento de Vehículos Híbridos y Eléctricos', 'CE-MVHE'),
('Fabricación Inteligente', 'CE-FI'),
('Modelado y Diseño para Fabricación Mecánica', 'CE-MDFM');

-- FP BÁSICA - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º FP Básica en Electricidad y Electrónica', 'FPB-EE-1'),
('2º FP Básica en Electricidad y Electrónica', 'FPB-EE-2');

-- GRADO MEDIO - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Instalaciones Eléctricas y Automáticas', 'IEA-1'),
('2º Instalaciones Eléctricas y Automáticas', 'IEA-2'),
('1º Instalaciones de Telecomunicaciones', 'IT-1'),
('2º Instalaciones de Telecomunicaciones', 'IT-2');

-- GRADO SUPERIOR - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('1º Automatización y Robótica Industrial', 'ARI-1'),
('2º Automatización y Robótica Industrial', 'ARI-2'),
('1º Sistemas Electrotécnicos y Automatizados', 'SEA-1'),
('2º Sistemas Electrotécnicos y Automatizados', 'SEA-2'),
('1º Sistemas de Telecomunicaciones e Informáticos', 'STI-1'),
('2º Sistemas de Telecomunicaciones e Informáticos', 'STI-2'),
('1º Mantenimiento Electrónico', 'ME-1'),
('2º Mantenimiento Electrónico', 'ME-2');

-- CURSOS DE ESPECIALIZACIÓN - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Sistemas de Energías Renovables', 'CE-SER'),
('Mantenimiento y Seguridad en Sistemas de Vehículos Híbridos y Eléctricos', 'CE-MSSVHE'),
('Ciberseguridad en Entornos de las Tecnologías de Operación', 'CE-CIBERTO');

-- ============================================
-- DATOS ORIGINALES
-- ============================================

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
INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, pais, provincia, ciudad, direccion, aprobada, verificado) VALUES 
(2, 'TechSolutions SL', 'B12345678', '912345678', 'Tecnología', 'Empresa líder en desarrollo de software empresarial', 'España', 'Madrid', 'Madrid', 'Calle Gran Vía 45', 1, 1),
(3, 'InnovaSoft', 'B87654321', '934567890', 'Desarrollo Web', 'Especialistas en aplicaciones web y mobile', 'España', 'Barcelona', 'Barcelona', 'Avenida Diagonal 123', 1, 1),
(4, 'DataSystems Corp', 'B11223344', '955123456', 'Big Data', 'Soluciones de análisis de datos y cloud computing', 'España', 'Sevilla', 'Sevilla', 'Calle Sierpes 78', 1, 1),
(5, 'WebStudio Creativo', 'B99887766', '963987654', 'Diseño y Desarrollo', 'Agencia digital full-stack', 'España', 'Valencia', 'Valencia', 'Plaza del Ayuntamiento 10', 0, 1);

-- Usuarios alumnos
INSERT INTO usuarios (email, password) VALUES 
('juan.perez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('maria.garcia@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('carlos.lopez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('ana.martinez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('pedro.sanchez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('laura.ruiz@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('david.torres@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('sofia.moreno@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('javier.navarro@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('elena.jimenez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('roberto.castro@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('patricia.vega@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('miguel.herrera@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('carmen.ramos@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('pablo.ortega@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('lucia.medina@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('antonio.silva@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('natalia.dominguez@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('raul.cruz@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('beatriz.romero@alumno.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

-- Alumnos (actualizados con ciclo_id correcto según los nuevos IDs)
INSERT INTO alumnos (usuario_id, nombre, apellidos, telefono, fecha_nacimiento, pais, provincia, ciudad, direccion, codigo_postal, ciclo_id, fecha_inicio, fecha_fin, verificado) VALUES 
-- Informática
(6, 'Juan', 'Pérez García', '611222333', '2002-03-15', 'España', 'Madrid', 'Madrid', 'Calle Alcalá 100', '28009', 8, '2024-09-01', '2026-06-30', 1),
(7, 'María', 'García López', '622333444', '2001-07-22', 'España', 'Barcelona', 'Barcelona', 'Paseo de Gracia 50', '08007', 8, '2024-09-01', '2026-06-30', 1),
(8, 'Carlos', 'López Martínez', '633444555', '2003-01-10', 'España', 'Madrid', 'Alcalá de Henares', 'Calle Mayor 25', '28801', 10, '2024-09-01', '2026-06-30', 1),
(9, 'Ana', 'Martínez Rodríguez', '644555666', '2002-11-05', 'España', 'Valencia', 'Valencia', 'Calle Colón 8', '46004', 12, '2023-09-01', '2025-06-30', 1),
(10, 'Pedro', 'Sánchez Fernández', '655666777', '2001-09-18', 'España', 'Sevilla', 'Sevilla', 'Avenida de la Constitución 15', '41001', 10, '2023-09-01', '2025-06-30', 1),
(11, 'Laura', 'Ruiz Molina', '666777888', '2003-05-12', 'España', 'Madrid', 'Madrid', 'Calle Serrano 88', '28006', 6, '2024-09-01', '2026-06-30', 1),
(12, 'David', 'Torres Gil', '677888999', '2002-08-20', 'España', 'Málaga', 'Málaga', 'Calle Larios 15', '29015', 13, '2025-02-01', '2025-06-30', 1),
-- Administración
(13, 'Sofía', 'Moreno Blanco', '688999000', '2001-12-03', 'España', 'Zaragoza', 'Zaragoza', 'Paseo Independencia 22', '50004', 20, '2024-09-01', '2026-06-30', 1),
(14, 'Javier', 'Navarro Peña', '699000111', '2003-02-28', 'España', 'Murcia', 'Murcia', 'Gran Vía 45', '30005', 22, '2023-09-01', '2025-06-30', 1),
(15, 'Elena', 'Jiménez Vargas', '600111222', '2002-06-15', 'España', 'Bilbao', 'Bilbao', 'Calle Ercilla 30', '48011', 24, '2024-09-01', '2026-06-30', 1),
(16, 'Roberto', 'Castro Prieto', '611222444', '2001-09-09', 'España', 'Valencia', 'Valencia', 'Avenida Blasco Ibáñez 50', '46010', 19, '2024-09-01', '2026-06-30', 1),
-- Higiene Bucodental
(17, 'Patricia', 'Vega Delgado', '622333555', '2003-04-18', 'España', 'Granada', 'Granada', 'Calle Recogidas 12', '18002', 30, '2024-09-01', '2026-06-30', 1),
(18, 'Miguel', 'Herrera Cortés', '633444666', '2002-11-25', 'España', 'Alicante', 'Alicante', 'Rambla Méndez Núñez 8', '03002', 32, '2023-09-01', '2025-06-30', 1),
(19, 'Carmen', 'Ramos Iglesias', '644555777', '2001-07-07', 'España', 'Córdoba', 'Córdoba', 'Avenida Gran Capitán 18', '14008', 28, '2024-09-01', '2026-06-30', 1),
-- Mecánica
(20, 'Pablo', 'Ortega Suárez', '655666888', '2003-03-22', 'España', 'Valladolid', 'Valladolid', 'Calle Santiago 25', '47001', 42, '2024-09-01', '2026-06-30', 1),
(21, 'Lucía', 'Medina Ferrer', '666777999', '2002-10-14', 'España', 'Gijón', 'Gijón', 'Calle Corrida 40', '33201', 46, '2023-09-01', '2025-06-30', 1),
(22, 'Antonio', 'Silva Cano', '677888111', '2001-05-30', 'España', 'Santander', 'Santander', 'Paseo Pereda 10', '39004', 50, '2024-09-01', '2026-06-30', 1),
(23, 'Natalia', 'Domínguez Pascual', '688999222', '2003-01-08', 'España', 'León', 'León', 'Calle Ancha 15', '24003', 38, '2024-09-01', '2026-06-30', 1),
-- Electrónica
(24, 'Raúl', 'Cruz Núñez', '699000333', '2002-09-11', 'España', 'Pamplona', 'Pamplona', 'Avenida Carlos III 22', '31002', 60, '2024-09-01', '2026-06-30', 1),
(25, 'Beatriz', 'Romero Soto', '600111444', '2001-12-19', 'España', 'Cádiz', 'Cádiz', 'Plaza San Juan de Dios 5', '11005', 68, '2023-09-01', '2025-06-30', 1);

-- Ciclos adicionales (actualizados con IDs correctos)
INSERT INTO alumno_ciclos (alumno_id, ciclo_id) VALUES 
(1, 10),
(2, 12),
(3, 8),
(3, 12),
(6, 7),
(7, 10),
(11, 5),
(11, 6),
(13, 18),
(15, 23),
(17, 29),
(20, 40),
(20, 41),
(24, 58),
(24, 59);

-- Ofertas (actualizadas con ciclo_id correcto)
INSERT INTO ofertas (empresa_id, titulo, descripcion, requisitos, ciclo_id, fecha_inicio, fecha_cierre, modalidad, salario) VALUES 
(1, 'Desarrollador Full Stack Junior', 'Buscamos desarrollador para integrar en nuestro equipo de desarrollo web. Trabajarás con React, Node.js y MongoDB.', 'Conocimientos en JavaScript, HTML, CSS. Valorable experiencia con frameworks modernos', 8, '2025-02-01', '2025-12-31', 'hibrido', 18000.00),
(1, 'Administrador de Sistemas en Prácticas', 'Prácticas en departamento de sistemas. Aprenderás sobre redes, servidores Linux y Windows Server.', 'Conocimientos básicos de redes y sistemas operativos', 12, '2025-03-01', '2025-09-30', 'presencial', 12000.00),
(2, 'Desarrollador Frontend React', 'Desarrollo de interfaces de usuario modernas con React y TypeScript.', 'React, TypeScript, CSS3, Git. Valorable conocimiento de Next.js', 8, '2025-02-15', '2025-11-30', 'remoto', 20000.00),
(2, 'Desarrollador Mobile Flutter', 'Desarrollo de aplicaciones móviles multiplataforma con Flutter.', 'Dart, Flutter, conocimientos de Android/iOS', 10, '2025-03-01', '2025-10-31', 'hibrido', 19000.00),
(3, 'Analista de Datos Junior', 'Análisis de datos y creación de dashboards con Power BI y Python.', 'Python, SQL, conocimientos de estadística', 10, '2025-02-01', '2025-08-31', 'presencial', 21000.00),
(3, 'DevOps en Prácticas', 'Aprendizaje de CI/CD, Docker, Kubernetes y AWS.', 'Linux, scripting básico, interés en DevOps', 12, '2025-04-01', '2025-12-31', 'hibrido', 15000.00),
(4, 'Diseñador Web y Desarrollador Frontend', 'Diseño y desarrollo de sitios web corporativos.', 'HTML, CSS, JavaScript, Figma o Adobe XD', 8, '2025-02-20', '2025-09-30', 'presencial', 17000.00);

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
(5, 5, 'pendiente'),
(6, 1, 'aceptada'),
(6, 3, 'pendiente'),
(7, 2, 'rechazada'),
(8, 4, 'pendiente'),
(8, 5, 'pendiente'),
(9, 1, 'aceptada'),
(10, 6, 'pendiente'),
(11, 7, 'pendiente');