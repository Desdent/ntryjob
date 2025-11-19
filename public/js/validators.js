const Validators = {
    // --- Básicos ---
    esNoVacio: (texto) => {
        return texto && texto.trim().length > 0;
    },

    esEmail: (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    },

    esTelefono: (telefono) => {
        const re = /^[0-9]{9}$/;
        return re.test(telefono);
    },

    esCodigoPostal: (cp) => {
        const re = /^[0-9]{5}$/;
        return re.test(cp);
    },

    // --- Texto y Direcciones ---
    esTexto: (texto, min = 2) => {
        // Solo letras y espacios
        const re = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        return texto.trim().length >= min && re.test(texto);
    },

    esDireccion: (texto, min = 5) => {
        // Permite letras, números, espacios y caracteres típicos de dirección
        const re = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s,.\-\/ºª]+$/;
        return texto.trim().length >= min && re.test(texto);
    },

    esAlfanumerico: (texto, min = 2) => {
        const re = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s]+$/;
        return texto.trim().length >= min && re.test(texto);
    },

    // --- Seguridad ---
    esPassword: (pass) => {
        return pass.length >= 6;
    },

    // --- Fechas ---
    esEdadValida: (fecha, minEdad = 16, maxEdad = 100) => {
        if (!fecha) return false;
        const hoy = new Date();
        const fechaNac = new Date(fecha);
        let edad = hoy.getFullYear() - fechaNac.getFullYear();
        const m = hoy.getMonth() - fechaNac.getMonth();
        if (m < 0 || (m === 0 && hoy.getDate() < fechaNac.getDate())) {
            edad--;
        }
        return edad >= minEdad && edad <= maxEdad;
    },

    esFechaValida: (fecha) => {
        return fecha && !isNaN(new Date(fecha).getTime());
    },

    esRangoFechasValido: (fechaInicio, fechaFin) => {
        if (!fechaFin) return true;
        return new Date(fechaInicio) <= new Date(fechaFin);
    },

    // --- Archivos ---
    esArchivoValido: (input, maxMb = 5, extensiones = ['pdf', 'docx', 'doc']) => {
        if (!input.files || input.files.length === 0) return false;
        
        const archivo = input.files[0];
        const pesoValido = archivo.size <= (maxMb * 1024 * 1024);
        
        const nombreSplit = archivo.name.split('.');
        const extension = nombreSplit[nombreSplit.length - 1].toLowerCase();
        const tipoValido = extensiones.includes(extension);

        return pesoValido && tipoValido;
    }
};