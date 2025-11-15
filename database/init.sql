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

-- Crear las tablas (Estructura original)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    token VARCHAR(255) NOT NULL UNIQUE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ciclos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    codigo VARCHAR(50)
);

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

CREATE TABLE IF NOT EXISTS alumno_ciclos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    ciclo_id INT NOT NULL,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (ciclo_id) REFERENCES ciclos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_alumno_ciclo (alumno_id, ciclo_id)
);

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

---

## 🏗️ INSERTS DE DATOS

-- ============================================
-- 1. USUARIOS & ADMIN
-- ============================================

-- Usuario admin: admin@ntryjob.com / admin123
INSERT INTO usuarios (email, password) VALUES 
('admin@ntryjob.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

INSERT INTO admin (usuario_id, nombre) VALUES (1, 'Administrador');

-- Usuarios empresas (ID 2 a 5)
INSERT INTO usuarios (email, password) VALUES 
('contacto@techsolutions.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('rrhh@innovasoft.es', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('info@datasystems.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('empleo@webstudio.es', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

-- Usuarios alumnos (ID 6 a 25)
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

---

-- ============================================
-- 2. CICLOS FORMATIVOS (MODIFICADOS)
-- ============================================

-- IDs de Ciclos: 1 al 38 (Importante para las FKs)

-- FP BÁSICA - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('FP Básica en Informática y Comunicaciones', 'FPB-IFC'), -- ID 1
('FP Básica en Informática de Oficina', 'FPB-IO');         -- ID 2

-- GRADO MEDIO - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Sistemas Microinformáticos y Redes', 'SMR');            -- ID 3

-- GRADO SUPERIOR - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Desarrollo de Aplicaciones Web', 'DAW'),                  -- ID 4
('Desarrollo de Aplicaciones Multiplataforma', 'DAM'),      -- ID 5
('Administración de Sistemas Informáticos en Red', 'ASIR'); -- ID 6

-- CURSOS DE ESPECIALIZACIÓN - INFORMÁTICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Ciberseguridad en Entornos de las Tecnologías de la Información', 'CE-CIBERTI'), -- ID 7
('Inteligencia Artificial y Big Data', 'CE-IABD'),                                 -- ID 8
('Desarrollo de Videojuegos y Realidad Virtual', 'CE-DVRV'),                       -- ID 9
('Desarrollo Web en Entorno Servidor', 'CE-DWES');                                 -- ID 10

-- FP BÁSICA - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('FP Básica en Servicios Administrativos', 'FPB-SA');    -- ID 11

-- GRADO MEDIO - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('Gestión Administrativa', 'GA');                       -- ID 12

-- GRADO SUPERIOR - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('Administración y Finanzas', 'AF'),                     -- ID 13
('Asistencia a la Dirección', 'AD');                     -- ID 14

-- CURSOS DE ESPECIALIZACIÓN - ADMINISTRACIÓN
INSERT INTO ciclos (nombre, codigo) VALUES 
('Digitalización Aplicada a los Sectores Productivos', 'CE-DASP'),   -- ID 15
('Gestión Avanzada de la Información Legal', 'CE-GAIL');             -- ID 16

-- GRADO MEDIO - SANIDAD
INSERT INTO ciclos (nombre, codigo) VALUES 
('Cuidados Auxiliares de Enfermería', 'CAE');           -- ID 17

-- GRADO SUPERIOR - SANIDAD
INSERT INTO ciclos (nombre, codigo) VALUES 
('Higiene Bucodental', 'HB'),                           -- ID 18
('Prótesis Dentales', 'PD');                            -- ID 19

-- CURSOS DE ESPECIALIZACIÓN - SANIDAD
INSERT INTO ciclos (nombre, codigo) VALUES 
('Ortodoncia y Ortopedia Dentofacial', 'CE-OOD');       -- ID 20

-- FP BÁSICA - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('FP Básica en Fabricación y Montaje', 'FPB-FM'),       -- ID 21
('FP Básica en Mantenimiento de Vehículos', 'FPB-MV');   -- ID 22

-- GRADO MEDIO - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Electromecánica de Vehículos Automóviles', 'EVA'),     -- ID 23
('Carrocería', 'CAR'),                                  -- ID 24
('Mecanizado', 'MEC');                                  -- ID 25

-- GRADO SUPERIOR - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Automoción', 'AUT'),                                  -- ID 26
('Mantenimiento Aeromecánico de Aviones con Motor de Turbina', 'MAAMT'), -- ID 27
('Programación de la Producción en Fabricación Mecánica', 'PPFM');        -- ID 28

-- CURSOS DE ESPECIALIZACIÓN - MECÁNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Mantenimiento de Vehículos Híbridos y Eléctricos', 'CE-MVHE'),          -- ID 29
('Fabricación Inteligente', 'CE-FI'),                                    -- ID 30
('Modelado y Diseño para Fabricación Mecánica', 'CE-MDFM');               -- ID 31

-- FP BÁSICA - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('FP Básica en Electricidad y Electrónica', 'FPB-EE');   -- ID 32

-- GRADO MEDIO - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Instalaciones Eléctricas y Automáticas', 'IEA'),       -- ID 33
('Instalaciones de Telecomunicaciones', 'IT');           -- ID 34

-- GRADO SUPERIOR - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Automatización y Robótica Industrial', 'ARI'),          -- ID 35
('Sistemas Electrotécnicos y Automatizados', 'SEA'),      -- ID 36
('Sistemas de Telecomunicaciones e Informáticos', 'STI'), -- ID 37
('Mantenimiento Electrónico', 'ME');                      -- ID 38

-- CURSOS DE ESPECIALIZACIÓN - ELECTRÓNICA
INSERT INTO ciclos (nombre, codigo) VALUES 
('Sistemas de Energías Renovables', 'CE-SER'),                         -- ID 39
('Mantenimiento y Seguridad en Sistemas de Vehículos Híbridos y Eléctricos', 'CE-MSSVHE'), -- ID 40
('Ciberseguridad en Entornos de las Tecnologías de Operación', 'CE-CIBERTO');               -- ID 41

---

-- ============================================
-- 3. EMPRESAS
-- ============================================

-- Empresas (ID 1 a 4)
INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, pais, provincia, ciudad, direccion, aprobada, verificado) VALUES 
(2, 'TechSolutions SL', 'B12345678', '912345678', 'Tecnología', 'Empresa líder en desarrollo de software empresarial', 'España', 'Madrid', 'Madrid', 'Calle Gran Vía 45', 1, 1),
(3, 'InnovaSoft', 'B87654321', '934567890', 'Desarrollo Web', 'Especialistas en aplicaciones web y mobile', 'España', 'Barcelona', 'Barcelona', 'Avenida Diagonal 123', 1, 1),
(4, 'DataSystems Corp', 'B11223344', '955123456', 'Big Data', 'Soluciones de análisis de datos y cloud computing', 'España', 'Sevilla', 'Sevilla', 'Calle Sierpes 78', 1, 1),
(5, 'WebStudio Creativo', 'B99887766', '963987654', 'Diseño y Desarrollo', 'Agencia digital full-stack', 'España', 'Valencia', 'Valencia', 'Plaza del Ayuntamiento 10', 0, 1);

---

-- ============================================
-- 4. ALUMNOS
-- ============================================

-- Alumnos (ID 1 a 20)
INSERT INTO alumnos (usuario_id, nombre, apellidos, telefono, fecha_nacimiento, pais, provincia, ciudad, direccion, codigo_postal, ciclo_id, fecha_inicio, fecha_fin, verificado) VALUES 
-- Informática
(6, 'Juan', 'Pérez García', '611222333', '2002-03-15', 'España', 'Madrid', 'Madrid', 'Calle Alcalá 100', '28009', 4, '2024-09-01', '2026-06-30', 1), -- ID 1 (DAW)
(7, 'María', 'García López', '622333444', '2001-07-22', 'España', 'Barcelona', 'Barcelona', 'Paseo de Gracia 50', '08007', 4, '2024-09-01', '2026-06-30', 1), -- ID 2 (DAW)
(8, 'Carlos', 'López Martínez', '633444555', '2003-01-10', 'España', 'Madrid', 'Alcalá de Henares', 'Calle Mayor 25', '28801', 5, '2024-09-01', '2026-06-30', 1), -- ID 3 (DAM)
(9, 'Ana', 'Martínez Rodríguez', '644555666', '2002-11-05', 'España', 'Valencia', 'Valencia', 'Calle Colón 8', '46004', 6, '2023-09-01', '2025-06-30', 1), -- ID 4 (ASIR)
(10, 'Pedro', 'Sánchez Fernández', '655666777', '2001-09-18', 'España', 'Sevilla', 'Sevilla', 'Avenida de la Constitución 15', '41001', 5, '2023-09-01', '2025-06-30', 1), -- ID 5 (DAM)
(11, 'Laura', 'Ruiz Molina', '666777888', '2003-05-12', 'España', 'Madrid', 'Madrid', 'Calle Serrano 88', '28006', 3, '2024-09-01', '2026-06-30', 1), -- ID 6 (SMR)
(12, 'David', 'Torres Gil', '677888999', '2002-08-20', 'España', 'Málaga', 'Málaga', 'Calle Larios 15', '29015', 7, '2025-02-01', '2025-06-30', 1), -- ID 7 (CE-CIBERTI)
-- Administración
(13, 'Sofía', 'Moreno Blanco', '688999000', '2001-12-03', 'España', 'Zaragoza', 'Zaragoza', 'Paseo Independencia 22', '50004', 13, '2024-09-01', '2026-06-30', 1), -- ID 8 (AF)
(14, 'Javier', 'Navarro Peña', '699000111', '2003-02-28', 'España', 'Murcia', 'Murcia', 'Gran Vía 45', '30005', 12, '2023-09-01', '2025-06-30', 1), -- ID 9 (GA)
(15, 'Elena', 'Jiménez Vargas', '600111222', '2002-06-15', 'España', 'Bilbao', 'Bilbao', 'Calle Ercilla 30', '48011', 13, '2024-09-01', '2026-06-30', 1), -- ID 10 (AF)
(16, 'Roberto', 'Castro Prieto', '611222444', '2001-09-09', 'España', 'Valencia', 'Valencia', 'Avenida Blasco Ibáñez 50', '46010', 11, '2024-09-01', '2026-06-30', 1), -- ID 11 (FPB-SA)
-- Sanidad (Higiene Bucodental)
(17, 'Patricia', 'Vega Delgado', '622333555', '2003-04-18', 'España', 'Granada', 'Granada', 'Calle Recogidas 12', '18002', 19, '2024-09-01', '2026-06-30', 1), -- ID 12 (PD)
(18, 'Miguel', 'Herrera Cortés', '633444666', '2002-11-25', 'España', 'Alicante', 'Alicante', 'Rambla Méndez Núñez 8', '03002', 18, '2023-09-01', '2025-06-30', 1), -- ID 13 (HB)
(19, 'Carmen', 'Ramos Iglesias', '644555777', '2001-07-07', 'España', 'Córdoba', 'Córdoba', 'Avenida Gran Capitán 18', '14008', 17, '2024-09-01', '2026-06-30', 1), -- ID 14 (CAE)
-- Mecánica
(20, 'Pablo', 'Ortega Suárez', '655666888', '2003-03-22', 'España', 'Valladolid', 'Valladolid', 'Calle Santiago 25', '47001', 23, '2024-09-01', '2026-06-30', 1), -- ID 15 (EVA)
(21, 'Lucía', 'Medina Ferrer', '666777999', '2002-10-14', 'España', 'Gijón', 'Gijón', 'Calle Corrida 40', '33201', 26, '2023-09-01', '2025-06-30', 1), -- ID 16 (AUT)
(22, 'Antonio', 'Silva Cano', '677888111', '2001-05-30', 'España', 'Santander', 'Santander', 'Paseo Pereda 10', '39004', 28, '2024-09-01', '2026-06-30', 1), -- ID 17 (PPFM)
(23, 'Natalia', 'Domínguez Pascual', '688999222', '2003-01-08', 'España', 'León', 'León', 'Calle Ancha 15', '24003', 22, '2024-09-01', '2026-06-30', 1), -- ID 18 (FPB-MV)
-- Electrónica
(24, 'Raúl', 'Cruz Núñez', '699000333', '2002-09-11', 'España', 'Pamplona', 'Pamplona', 'Avenida Carlos III 22', '31002', 35, '2024-09-01', '2026-06-30', 1), -- ID 19 (ARI)
(25, 'Beatriz', 'Romero Soto', '600111444', '2001-12-19', 'España', 'Cádiz', 'Cádiz', 'Plaza San Juan de Dios 5', '11005', 37, '2023-09-01', '2025-06-30', 1); -- ID 20 (STI)

---

-- ============================================
-- 5. ALUMNO_CICLOS (Corregido)
-- ============================================

-- IDs de alumnos: 1 a 20. IDs de ciclos: ver sección 2.
INSERT INTO alumno_ciclos (alumno_id, ciclo_id) VALUES 
(1, 5),    -- Juan (ID 1) está en DAM (ID 5)
(2, 6),    -- María (ID 2) está en ASIR (ID 6)
(3, 4),    -- Carlos (ID 3) está en DAW (ID 4)
(3, 6),    -- Carlos (ID 3) también en ASIR (ID 6)
(6, 3),    -- Laura (ID 6) está en SMR (ID 3)
(7, 5),    -- David (ID 7) está en DAM (ID 5)
(11, 11),  -- Roberto (ID 11) está en FPB-SA (ID 11)
(8, 13),   -- Sofía (ID 8) está en AF (ID 13)
(10, 14),  -- Elena (ID 10) está en AD (ID 14)
(12, 18),  -- Patricia (ID 12) está en HB (ID 18)
(15, 23),  -- Pablo (ID 15) está en EVA (ID 23)
(15, 24),  -- Pablo (ID 15) también en CAR (ID 24)
(19, 33),  -- Raúl (ID 19) está en IEA (ID 33)
(19, 34);  -- Raúl (ID 19) también en IT (ID 34)

---

-- ============================================
-- 6. OFERTAS (Corregido)
-- ============================================

-- IDs de Ciclos ajustados: DAW=4, ASIR=6, DAM=5
INSERT INTO ofertas (empresa_id, titulo, descripcion, requisitos, ciclo_id, fecha_inicio, fecha_cierre, modalidad, salario) VALUES 
(1, 'Desarrollador Full Stack Junior', 'Buscamos desarrollador para integrar en nuestro equipo de desarrollo web. Trabajarás con React, Node.js y MongoDB.', 'Conocimientos en JavaScript, HTML, CSS. Valorable experiencia con frameworks modernos', 4, '2025-02-01', '2025-12-31', 'hibrido', 18000.00), -- DAW (ID 4)
(1, 'Administrador de Sistemas en Prácticas', 'Prácticas en departamento de sistemas. Aprenderás sobre redes, servidores Linux y Windows Server.', 'Conocimientos básicos de redes y sistemas operativos', 6, '2025-03-01', '2025-09-30', 'presencial', 12000.00), -- ASIR (ID 6)
(2, 'Desarrollador Frontend React', 'Desarrollo de interfaces de usuario modernas con React y TypeScript.', 'React, TypeScript, CSS3, Git. Valorable conocimiento de Next.js', 4, '2025-02-15', '2025-11-30', 'remoto', 20000.00), -- DAW (ID 4)
(2, 'Desarrollador Mobile Flutter', 'Desarrollo de aplicaciones móviles multiplataforma con Flutter.', 'Dart, Flutter, conocimientos de Android/iOS', 5, '2025-03-01', '2025-10-31', 'hibrido', 19000.00), -- DAM (ID 5)
(3, 'Analista de Datos Junior', 'Análisis de datos y creación de dashboards con Power BI y Python.', 'Python, SQL, conocimientos de estadística', 5, '2025-02-01', '2025-08-31', 'presencial', 21000.00), -- DAM (ID 5)
(3, 'DevOps en Prácticas', 'Aprendizaje de CI/CD, Docker, Kubernetes y AWS.', 'Linux, scripting básico, interés en DevOps', 6, '2025-04-01', '2025-12-31', 'hibrido', 15000.00), -- ASIR (ID 6)
(4, 'Diseñador Web y Desarrollador Frontend', 'Diseño y desarrollo de sitios web corporativos.', 'HTML, CSS, JavaScript, Figma o Adobe XD', 4, '2025-02-20', '2025-09-30', 'presencial', 17000.00); -- DAW (ID 4)

---

-- ============================================
-- 7. POSTULACIONES (Corregido)
-- ============================================

-- IDs de alumnos: 1 a 20. IDs de ofertas: 1 a 7
INSERT INTO postulaciones (alumno_id, oferta_id, estado) VALUES 
(1, 1, 'pendiente'), -- Juan (ID 1)
(1, 3, 'aceptada'),
(2, 1, 'pendiente'), -- María (ID 2)
(2, 7, 'rechazada'),
(3, 4, 'pendiente'), -- Carlos (ID 3)
(3, 5, 'aceptada'),
(4, 2, 'pendiente'), -- Ana (ID 4)
(4, 6, 'pendiente'),
(5, 4, 'rechazada'), -- Pedro (ID 5)
(5, 5, 'pendiente'),
(6, 1, 'aceptada'), -- Laura (ID 6)
(6, 3, 'pendiente'),
(7, 2, 'rechazada'), -- David (ID 7)
(8, 4, 'pendiente'), -- Sofía (ID 8)
(8, 5, 'pendiente'),
(9, 1, 'aceptada'), -- Javier (ID 9)
(10, 6, 'pendiente'), -- Elena (ID 10)
(11, 7, 'pendiente'); -- Roberto (ID 11)