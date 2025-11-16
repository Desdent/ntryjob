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

---

## ⚙️ Creación de Tablas (Modificada)

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

-- ESTRUCTURA ORIGINAL DE ALUMNOS (Mantenida)
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

-- ALUMNO_CICLOS (MODIFICACIÓN: Añadido campo 'nombre')
CREATE TABLE IF NOT EXISTS alumno_ciclos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    ciclo_id INT NOT NULL,
    nombre_ciclo VARCHAR(100) NOT NULL,    -- NUEVO CAMPO AÑADIDO
    fecha_inicio DATE NOT NULL, 
    fecha_fin DATE,             
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (ciclo_id) REFERENCES ciclos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_alumno_ciclo_fechas (alumno_id, ciclo_id, fecha_inicio)
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
-- 1. USUARIOS & ADMIN (Sin cambios)
-- ============================================

INSERT INTO usuarios (email, password) VALUES 
('admin@ntryjob.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');
INSERT INTO admin (usuario_id, nombre) VALUES (1, 'Administrador');

INSERT INTO usuarios (email, password) VALUES 
('contacto@techsolutions.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('rrhh@innovasoft.es', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('info@datasystems.com', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi'),
('empleo@webstudio.es', '$2a$12$AyNg2a/ABhbjYLGC7Veive4gKDfcPHhvu1qq7HSNK.1qmEM4sfYWi');

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
-- 2. CICLOS FORMATIVOS (Sin cambios)
-- ============================================

INSERT INTO ciclos (nombre, codigo) VALUES 
('FP Básica en Informática y Comunicaciones', 'FPB-IFC'), 
('FP Básica en Informática de Oficina', 'FPB-IO'),         
('Sistemas Microinformáticos y Redes', 'SMR'),             
('Desarrollo de Aplicaciones Web', 'DAW'),                 
('Desarrollo de Aplicaciones Multiplataforma', 'DAM'),     
('Administración de Sistemas Informáticos en Red', 'ASIR'), 
('Ciberseguridad en Entornos de las Tecnologías de la Información', 'CE-CIBERTI'), 
('Inteligencia Artificial y Big Data', 'CE-IABD'),         
('Desarrollo de Videojuegos y Realidad Virtual', 'CE-DVRV'), 
('Desarrollo Web en Entorno Servidor', 'CE-DWES'),         
('FP Básica en Servicios Administrativos', 'FPB-SA'),      
('Gestión Administrativa', 'GA'),                          
('Administración y Finanzas', 'AF'),                       
('Asistencia a la Dirección', 'AD'),                       
('Digitalización Aplicada a los Sectores Productivos', 'CE-DASP'), 
('Gestión Avanzada de la Información Legal', 'CE-GAIL'),   
('Cuidados Auxiliares de Enfermería', 'CAE'),              
('Higiene Bucodental', 'HB'),                              
('Prótesis Dentales', 'PD'),                               
('Ortodoncia y Ortopedia Dentofacial', 'CE-OOD'),          
('FP Básica en Fabricación y Montaje', 'FPB-FM'),          
('FP Básica en Mantenimiento de Vehículos', 'FPB-MV'),     
('Electromecánica de Vehículos Automóviles', 'EVA'),      
('Carrocería', 'CAR'),                                     
('Mecanizado', 'MEC'),                                     
('Automoción', 'AUT'),                                     
('Mantenimiento Aeromecánico de Aviones con Motor de Turbina', 'MAAMT'), 
('Programación de la Producción en Fabricación Mecánica', 'PPFM'), 
('Mantenimiento de Vehículos Híbridos y Eléctricos', 'CE-MVHE'), 
('Fabricación Inteligente', 'CE-FI'),                      
('Modelado y Diseño para Fabricación Mecánica', 'CE-MDFM'), 
('FP Básica en Electricidad y Electrónica', 'FPB-EE'),     
('Instalaciones Eléctricas y Automáticas', 'IEA'),         
('Instalaciones de Telecomunicaciones', 'IT'),             
('Automatización y Robótica Industrial', 'ARI'),           
('Sistemas Electrotécnicos y Automatizados', 'SEA'),       
('Sistemas de Telecomunicaciones e Informáticos', 'STI'),  
('Mantenimiento Electrónico', 'ME'),                       
('Sistemas de Energías Renovables', 'CE-SER'),             
('Mantenimiento y Seguridad en Sistemas de Vehículos Híbridos y Eléctricos', 'CE-MSSVHE'), 
('Ciberseguridad en Entornos de las Tecnologías de Operación', 'CE-CIBERTO');

---

-- ============================================
-- 3. EMPRESAS (Sin cambios)
-- ============================================

INSERT INTO empresas (usuario_id, nombre, cif, telefono, sector, descripcion, pais, provincia, ciudad, direccion, aprobada, verificado) VALUES 
(2, 'TechSolutions SL', 'B12345678', '912345678', 'Tecnología', 'Empresa líder en desarrollo de software empresarial', 'España', 'Madrid', 'Madrid', 'Calle Gran Vía 45', 1, 1),
(3, 'InnovaSoft', 'B87654321', '934567890', 'Desarrollo Web', 'Especialistas en aplicaciones web y mobile', 'España', 'Barcelona', 'Barcelona', 'Avenida Diagonal 123', 1, 1),
(4, 'DataSystems Corp', 'B11223344', '955123456', 'Big Data', 'Soluciones de análisis de datos y cloud computing', 'España', 'Sevilla', 'Sevilla', 'Calle Sierpes 78', 1, 1),
(5, 'WebStudio Creativo', 'B99887766', '963987654', 'Diseño y Desarrollo', 'Agencia digital full-stack', 'España', 'Valencia', 'Valencia', 'Plaza del Ayuntamiento 10', 0, 1);

---

-- ============================================
-- 4. ALUMNOS (Mantenida la estructura original)
-- ============================================

INSERT INTO alumnos (usuario_id, nombre, apellidos, telefono, fecha_nacimiento, pais, provincia, ciudad, direccion, codigo_postal, cv, foto, ciclo_id, fecha_inicio, fecha_fin, verificado) VALUES 
(6, 'Juan', 'Pérez García', '611222333', '2002-03-15', 'España', 'Madrid', 'Madrid', 'Calle Alcalá 100', '28009', NULL, NULL, 4, '2024-09-01', '2026-06-30', 1),
(7, 'María', 'García López', '622333444', '2001-07-22', 'España', 'Barcelona', 'Barcelona', 'Paseo de Gracia 50', '08007', NULL, NULL, 4, '2024-09-01', '2026-06-30', 1),
(8, 'Carlos', 'López Martínez', '633444555', '2003-01-10', 'España', 'Madrid', 'Alcalá de Henares', 'Calle Mayor 25', '28801', NULL, NULL, 5, '2024-09-01', '2026-06-30', 1),
(9, 'Ana', 'Martínez Rodríguez', '644555666', '2002-11-05', 'España', 'Valencia', 'Valencia', 'Calle Colón 8', '46004', NULL, NULL, 6, '2023-09-01', '2025-06-30', 1),
(10, 'Pedro', 'Sánchez Fernández', '655666777', '2001-09-18', 'España', 'Sevilla', 'Sevilla', 'Avenida de la Constitución 15', '41001', NULL, NULL, 5, '2023-09-01', '2025-06-30', 1),
(11, 'Laura', 'Ruiz Molina', '666777888', '2003-05-12', 'España', 'Madrid', 'Madrid', 'Calle Serrano 88', '28006', NULL, NULL, 3, '2024-09-01', '2026-06-30', 1),
(12, 'David', 'Torres Gil', '677888999', '2002-08-20', 'España', 'Málaga', 'Málaga', 'Calle Larios 15', '29015', NULL, NULL, 7, '2025-02-01', '2025-06-30', 1),
(13, 'Sofía', 'Moreno Blanco', '688999000', '2001-12-03', 'España', 'Zaragoza', 'Zaragoza', 'Paseo Independencia 22', '50004', NULL, NULL, 13, '2024-09-01', '2026-06-30', 1),
(14, 'Javier', 'Navarro Peña', '699000111', '2003-02-28', 'España', 'Murcia', 'Murcia', 'Gran Vía 45', '30005', NULL, NULL, 12, '2023-09-01', '2025-06-30', 1),
(15, 'Elena', 'Jiménez Vargas', '600111222', '2002-06-15', 'España', 'Bilbao', 'Bilbao', 'Calle Ercilla 30', '48011', NULL, NULL, 13, '2024-09-01', '2026-06-30', 1),
(16, 'Roberto', 'Castro Prieto', '611222444', '2001-09-09', 'España', 'Valencia', 'Valencia', 'Avenida Blasco Ibáñez 50', '46010', NULL, NULL, 11, '2024-09-01', '2026-06-30', 1),
(17, 'Patricia', 'Vega Delgado', '622333555', '2003-04-18', 'España', 'Granada', 'Granada', 'Calle Recogidas 12', '18002', NULL, NULL, 19, '2024-09-01', '2026-06-30', 1),
(18, 'Miguel', 'Herrera Cortés', '633444666', '2002-11-25', 'España', 'Alicante', 'Alicante', 'Rambla Méndez Núñez 8', '03002', NULL, NULL, 18, '2023-09-01', '2025-06-30', 1),
(19, 'Carmen', 'Ramos Iglesias', '644555777', '2001-07-07', 'España', 'Córdoba', 'Córdoba', 'Avenida Gran Capitán 18', '14008', NULL, NULL, 17, '2024-09-01', '2026-06-30', 1),
(20, 'Pablo', 'Ortega Suárez', '655666888', '2003-03-22', 'España', 'Valladolid', 'Valladolid', 'Calle Santiago 25', '47001', NULL, NULL, 23, '2024-09-01', '2026-06-30', 1),
(21, 'Lucía', 'Medina Ferrer', '666777999', '2002-10-14', 'España', 'Gijón', 'Gijón', 'Calle Corrida 40', '33201', NULL, NULL, 26, '2023-09-01', '2025-06-30', 1),
(22, 'Antonio', 'Silva Cano', '677888111', '2001-05-30', 'España', 'Santander', 'Santander', 'Paseo Pereda 10', '39004', NULL, NULL, 28, '2024-09-01', '2026-06-30', 1),
(23, 'Natalia', 'Domínguez Pascual', '688999222', '2003-01-08', 'España', 'León', 'León', 'Calle Ancha 15', '24003', NULL, NULL, 22, '2024-09-01', '2026-06-30', 1),
(24, 'Raúl', 'Cruz Núñez', '699000333', '2002-09-11', 'España', 'Pamplona', 'Pamplona', 'Avenida Carlos III 22', '31002', NULL, NULL, 35, '2024-09-01', '2026-06-30', 1),
(25, 'Beatriz', 'Romero Soto', '600111444', '2001-12-19', 'España', 'Cádiz', 'Cádiz', 'Plaza San Juan de Dios 5', '11005', NULL, NULL, 37, '2023-09-01', '2025-06-30', 1);

---

-- ============================================
-- 5. ALUMNO_CICLOS (Ajustado con NOMBRE y Fechas)
-- ============================================

INSERT INTO alumno_ciclos (alumno_id, ciclo_id, nombre_ciclo, fecha_inicio, fecha_fin) VALUES 
(1, 5, 'Desarrollo de Aplicaciones Multiplataforma', '2026-09-01', NULL), 
(1, 4, 'Desarrollo de Aplicaciones Web', '2024-09-01', '2026-06-30'), 

(2, 6, 'Administración de Sistemas Informáticos en Red', '2026-09-01', NULL), 
(2, 4, 'Desarrollo de Aplicaciones Web', '2024-09-01', '2026-06-30'), 

(3, 4, 'Desarrollo de Aplicaciones Web', '2023-09-01', '2025-06-30'), 
(3, 6, 'Administración de Sistemas Informáticos en Red', '2025-09-01', '2027-06-30'), 

(6, 3, 'Sistemas Microinformáticos y Redes', '2024-09-01', '2026-06-30'), 
(7, 5, 'Desarrollo de Aplicaciones Multiplataforma', '2025-02-01', '2025-06-30'), 

(11, 11, 'FP Básica en Servicios Administrativos', '2024-09-01', '2026-06-30'), 
(8, 13, 'Administración y Finanzas', '2024-09-01', '2026-06-30'), 

(10, 14, 'Asistencia a la Dirección', '2026-09-01', NULL), 
(10, 13, 'Administración y Finanzas', '2024-09-01', '2026-06-30'), 

(12, 18, 'Higiene Bucodental', '2024-09-01', '2026-06-30'), 

(15, 23, 'Electromecánica de Vehículos Automóviles', '2024-09-01', '2026-06-30'), 
(15, 24, 'Carrocería', '2026-09-01', NULL), 

(19, 33, 'Instalaciones Eléctricas y Automáticas', '2026-09-01', NULL), 
(19, 34, 'Instalaciones de Telecomunicaciones', '2024-09-01', '2026-06-30'); 

---

-- ============================================
-- 6. OFERTAS (Sin cambios)
-- ============================================

INSERT INTO ofertas (empresa_id, titulo, descripcion, requisitos, ciclo_id, fecha_inicio, fecha_cierre, modalidad, salario) VALUES 
(1, 'Desarrollador Full Stack Junior', 'Buscamos desarrollador para integrar en nuestro equipo de desarrollo web. Trabajarás con React, Node.js y MongoDB.', 'Conocimientos en JavaScript, HTML, CSS. Valorable experiencia con frameworks modernos', 4, '2025-02-01', '2025-12-31', 'hibrido', 18000.00),
(1, 'Administrador de Sistemas en Prácticas', 'Prácticas en departamento de sistemas. Aprenderás sobre redes, servidores Linux y Windows Server.', 'Conocimientos básicos de redes y sistemas operativos', 6, '2025-03-01', '2025-09-30', 'presencial', 12000.00),
(2, 'Desarrollador Frontend React', 'Desarrollo de interfaces de usuario modernas con React y TypeScript.', 'React, TypeScript, CSS3, Git. Valorable conocimiento de Next.js', 4, '2025-02-15', '2025-11-30', 'remoto', 20000.00),
(2, 'Desarrollador Mobile Flutter', 'Desarrollo de aplicaciones móviles multiplataforma con Flutter.', 'Dart, Flutter, conocimientos de Android/iOS', 5, '2025-03-01', '2025-10-31', 'hibrido', 19000.00),
(3, 'Analista de Datos Junior', 'Análisis de datos y creación de dashboards con Power BI y Python.', 'Python, SQL, conocimientos de estadística', 5, '2025-02-01', '2025-08-31', 'presencial', 21000.00),
(3, 'DevOps en Prácticas', 'Aprendizaje de CI/CD, Docker, Kubernetes y AWS.', 'Linux, scripting básico, interés en DevOps', 6, '2025-04-01', '2025-12-31', 'hibrido', 15000.00),
(4, 'Diseñador Web y Desarrollador Frontend', 'Diseño y desarrollo de sitios web corporativos.', 'HTML, CSS, JavaScript, Figma o Adobe XD', 4, '2025-02-20', '2025-09-30', 'presencial', 17000.00);

---

-- ============================================
-- 7. POSTULACIONES (Sin cambios)
-- ============================================

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


INSERT INTO alumno_ciclos (alumno_id, ciclo_id, nombre_ciclo, fecha_inicio, fecha_fin) VALUES 
(21, 29, 'Mantenimiento de Vehículos Híbridos y Eléctricos', '2025-09-01', '2026-03-31'), 
(21, 25, 'Mecanizado', '2022-09-01', '2024-06-30'), 
(21, 30, 'Fabricación Inteligente', '2026-04-01', '2026-09-30');