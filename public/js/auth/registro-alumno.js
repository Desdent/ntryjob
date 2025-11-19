document.addEventListener('DOMContentLoaded', function() {

    cargarCiclos();
    
    const modal = document.getElementById('modalRegistroAlumno');
    const btnAbrir = document.getElementById('btnAbrirModalAlumno');
    const btnCerrar = document.querySelector('.modal-close');
    const btnCancelar = document.getElementById('btnCancelarModal');
    const form = document.getElementById('formRegistroAlumno');
    
    // ========== ABRIR/CERRAR MODAL ==========
    
    if(btnAbrir) {
        btnAbrir.addEventListener('click', function() {
            modal.style.display = 'block';
        });
    }
    
    if(btnCerrar) {
        btnCerrar.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    if(btnCancelar) {
        btnCancelar.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // ========== VALIDACIONES EN TIEMPO REAL ==========
    
    const campos = form.querySelectorAll('input[required], select[required], input[type="date"], input[type="file"]');
    
    campos.forEach(campo => {
        // Usar 'change' para archivos y fechas, 'blur' para texto
        const evento = (campo.type === 'file' || campo.type === 'date' || campo.tagName === 'SELECT') ? 'change' : 'blur';
        
        campo.addEventListener(evento, function() {
            validarCampo(this);
        });
        
        campo.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                this.classList.remove('invalid');
                this.nextElementSibling.textContent = '';
            }
        });
    });
    
    // ========== FUNCIÓN DE VALIDACIÓN CON VALIDATORS.JS ==========
    
    function validarCampo(campo) {
        const valor = campo.value.trim();
        const nombre = campo.name;
        const errorSpan = campo.nextElementSibling;
        
        // Limpiar estados previos
        campo.classList.remove('valid', 'invalid');
        errorSpan.textContent = '';
        
        // 1. Validación de Requerido
        if (nombre !== 'fechaFinalizacion' && (!valor && campo.type !== 'file')) {
             if (campo.required) {
                campo.classList.add('invalid');
                errorSpan.textContent = 'Este campo es obligatorio';
                return false;
             }
        }
        if (campo.type === 'file' && campo.required && campo.files.length === 0) {
             campo.classList.add('invalid');
             errorSpan.textContent = 'Debes subir un archivo';
             return false;
        }

        let valido = true;

        // 2. Validaciones Específicas usando Validators
        switch(nombre) {
            case 'nombre':
            case 'apellidos':
            case 'pais':
            case 'provincia':
                if (!Validators.esTexto(valor)) {
                    errorSpan.textContent = 'Solo letras y espacios (min 2 caracteres)';
                    valido = false;
                }
                break;

            case 'localidad': 
            case 'ciudad':
                if (!Validators.esAlfanumerico(valor)) {
                    errorSpan.textContent = 'Carácteres no válidos';
                    valido = false;
                }
                break;

            case 'direccion':
                if (!Validators.esDireccion(valor)) {
                    errorSpan.textContent = 'Dirección inválida (min 5 caracteres)';
                    valido = false;
                }
                break;

            case 'email':
                if (!Validators.esEmail(valor)) {
                    errorSpan.textContent = 'Email inválido';
                    valido = false;
                } else {
                    verificarEmailExistente(campo, errorSpan);
                }
                break;
                
            case 'telefono':
                if (!Validators.esTelefono(valor)) {
                    errorSpan.textContent = 'Debe contener 9 dígitos numéricos';
                    valido = false;
                }
                break;
                
            case 'codigoPostal':
                if (!Validators.esCodigoPostal(valor)) {
                    errorSpan.textContent = 'Código postal de 5 dígitos';
                    valido = false;
                }
                break;
                
            case 'password':
                if (!Validators.esPassword(valor)) {
                    errorSpan.textContent = 'Mínimo 6 caracteres';
                    valido = false;
                }
                break;
                
            case 'fechaNacimiento':
                if (!Validators.esEdadValida(valor)) {
                    errorSpan.textContent = 'Debes tener entre 16 y 100 años';
                    valido = false;
                }
                break;
            
            case 'fechaInicio':
                if (!Validators.esFechaValida(valor)) {
                    errorSpan.textContent = 'Fecha inválida';
                    valido = false;
                } else {
                    const inputFin = document.getElementById('fechaFinalizacion');
                    if (inputFin && inputFin.value) {
                        if (!Validators.esRangoFechasValido(valor, inputFin.value)) {
                            errorSpan.textContent = 'La fecha de inicio debe ser anterior a la finalización';
                            valido = false;
                        } else {
                            inputFin.classList.remove('invalid');
                            inputFin.classList.add('valid');
                            inputFin.nextElementSibling.textContent = '';
                        }
                    }
                }
                break;

            case 'fechaFinalizacion':
                if (valor) {
                    const inputInicio = document.getElementById('fechaInicio');
                    if (!Validators.esRangoFechasValido(inputInicio.value, valor)) {
                        errorSpan.textContent = 'La fecha de finalización debe ser posterior al inicio';
                        valido = false;
                    }
                }
                break;

            case 'subirCV':
                if (campo.files.length > 0) {
                    if (!Validators.esArchivoValido(campo, 5, ['pdf', 'doc', 'docx'])) {
                         errorSpan.textContent = 'Archivo inválido. Solo PDF/DOCX máx 5MB';
                         valido = false;
                    }
                }
                break;
        }
        
        if (!valido) {
            campo.classList.add('invalid');
            return false;
        }
        
        if (nombre !== 'email') {
            campo.classList.add('valid');
        }
        return true;
    }
    
    // ========== VERIFICAR EMAIL EXISTENTE ==========
    
    function verificarEmailExistente(campo, errorSpan) {
        const email = campo.value.trim();
        
        fetch('/api/auth/email_exists.php?email=' + encodeURIComponent(email))
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Este email ya está registrado';
                } else {
                    campo.classList.add('valid');
                }
            })
            .catch(error => {
                console.error('Error al verificar email:', error);
            });
    }
    
    // ========== ENVÍO DEL FORMULARIO ==========
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let todosValidos = true;
        const camposRequeridos = form.querySelectorAll('input[required], select[required]');
        
        camposRequeridos.forEach(campo => {
            if (!validarCampo(campo)) {
                todosValidos = false;
            }
        });

        // Validar fechas opcionales si están rellenas
        const fechaFin = document.getElementById('fechaFinalizacion');
        if (fechaFin.value && !validarCampo(fechaFin)) {
            todosValidos = false;
        }

        if (!todosValidos) {
            alert('Por favor, corrige los errores en el formulario antes de enviar.');
            // Scroll al primer error
            const primerError = form.querySelector('.invalid');
            if(primerError) primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        
        const formData = new FormData();
        
        formData.append('nombre', document.getElementById('nombre').value);
        formData.append('apellidos', document.getElementById('apellidos').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('password_confirm', document.getElementById('password').value);
        formData.append('telefono', document.getElementById('telefono').value);
        formData.append('pais', document.getElementById('pais').value);
        formData.append('provincia', document.getElementById('provincia').value);
        formData.append('ciudad', document.getElementById('localidad').value);
        formData.append('codigo_postal', document.getElementById('codigoPostal').value);
        formData.append('direccion', document.getElementById('direccion').value);
        formData.append('fecha_nacimiento', document.getElementById('fechaNacimiento').value);
        formData.append('ciclo_id', document.getElementById('ultimoCiclo').value);
        formData.append('fecha_inicio', document.getElementById('fechaInicio').value);
        
        if (fechaFin.value) {
            formData.append('fecha_fin', fechaFin.value);
        }
        
        const archivoCV = document.getElementById('subirCV').files[0];
        if (archivoCV) {
            formData.append('cv', archivoCV);
        }
        
        const fotoBase64 = document.getElementById('fotoAlumnoBase64').value;
        if (fotoBase64) {
            formData.append('foto_base64', fotoBase64);
        }
        
        const btnSubmit = form.querySelector('button[type="submit"]');
        const btnOriginalText = btnSubmit.textContent;
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Registrando...';
        
        fetch('/api/auth/registro-alumno.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Registro exitoso. Ya puedes iniciar sesión.');
                window.location.href = '/public/index.php?page=login';
            } else {
                alert(data.error || 'Error al registrarse');
                btnSubmit.disabled = false;
                btnSubmit.textContent = btnOriginalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión. Intenta de nuevo.');
            btnSubmit.disabled = false;
            btnSubmit.textContent = btnOriginalText;
        });
    });

    // [El resto del código de la cámara y cargarCiclos se mantiene igual que el original]
    // ... (incluir aquí el código de la cámara del archivo original si es necesario, 
    // pero como pediste "tal cual copiar y pegar", asumo que quieres que lo incluya)
    
    let stream = null;
    let arrastrar = false;
    let inicioMovimiento = {x:0, y:0};
    let recorte = {x:50, y:50, w:200, h:200};

    let modalCamara = document.getElementById("modalCamaraAlumno");
    let btnAbrirCamara = document.getElementById("btnAbrirCamaraAlumno");
    let btnCancelarFoto = document.getElementById("btnCancelarFoto");
    let btnCapturarFoto = document.getElementById("btnCapturarFoto");
    let btnGuardarFoto = document.getElementById("btnGuardarFoto");
    let modalClose = document.querySelector(".modal-camara-close");
    let video = document.getElementById("camaraVideo");
    let canvas = document.getElementById("fotoCanvas");
    let inputFotoBase64 = document.getElementById("fotoAlumnoBase64");
    let imgPreview = document.getElementById("fotoPreview");

    if(btnAbrirCamara) {
        btnAbrirCamara.addEventListener('click', function() {
          modalCamara.style.display = 'block';
          canvas.style.display = 'none';
          btnCapturarFoto.style.display = 'inline-block';
          btnGuardarFoto.style.display = 'none';
          video.style.display = 'inline-block';
          navigator.mediaDevices.getUserMedia({ video: true }).then(function(s) {
            stream = s;
            video.srcObject = stream;
          }).catch(function(err) {
            alert('No se pudo acceder a la cámara.');
            modalCamara.style.display = 'none';
          });
        });
    }

    function cerrarCamaraModal() {
      modalCamara.style.display = 'none';
      if (stream) {
        let tracks = stream.getTracks();
        for (let i=0; i<tracks.length; i++) tracks[i].stop();
        stream = null;
      }
      video.style.display = 'inline-block';
      canvas.style.display = 'none';
      arrastrar = false;
    }
    
    if(btnCancelarFoto) btnCancelarFoto.onclick = cerrarCamaraModal;
    if(modalClose) modalClose.onclick = cerrarCamaraModal;
    
    if(btnCapturarFoto) {
        btnCapturarFoto.onclick = function() {
            let ctx = canvas.getContext("2d");
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            renderRecorte();
            canvas.style.display = "block";
            video.style.display = "none";
            btnCapturarFoto.style.display = "none";
            btnGuardarFoto.style.display = "inline-block";
        };
    }

    function renderRecorte() {
        let ctx = canvas.getContext("2d");
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        ctx.save();
        ctx.strokeStyle = "#2563eb";
        ctx.lineWidth = 3;
        ctx.setLineDash([8, 6]);
        ctx.strokeRect(recorte.x, recorte.y, recorte.w, recorte.h);
        ctx.restore();
    }

    if(canvas) {
        canvas.addEventListener("wheel", function(e) {
            if(!e.ctrlKey) return;
            let factor = e.deltaY < 0 ? 1.05 : 0.95;
            let newW = recorte.w * factor;
            let newH = recorte.h * factor;
            newW = Math.max(50, Math.min(newW, canvas.width));
            newH = Math.max(50, Math.min(newH, canvas.height));
            if(recorte.x + newW > canvas.width) newW = canvas.width-recorte.x;
            if(recorte.y + newH > canvas.height) newH = canvas.height-recorte.y;
            recorte.w = newW;
            recorte.h = newH;
            renderRecorte();
        });

        canvas.addEventListener("mousedown", function(ev) {
            if(!ev.ctrlKey) return;
            let mx = ev.offsetX, my = ev.offsetY;
            if(mx >= recorte.x && mx <= recorte.x+recorte.w && my >= recorte.y && my <= recorte.y+recorte.h){
                arrastrar = true;
                inicioMovimiento.x = mx - recorte.x;
                inicioMovimiento.y = my - recorte.y;
            }
        });

        canvas.addEventListener("mousemove", function(ev) {
            if(arrastrar) {
                let nx = ev.offsetX-inicioMovimiento.x;
                let ny = ev.offsetY-inicioMovimiento.y;
                nx = Math.max(0, Math.min(nx, canvas.width-recorte.w));
                ny = Math.max(0, Math.min(ny, canvas.height-recorte.h));
                recorte.x = nx;
                recorte.y = ny;
                renderRecorte();
            }
        });

        canvas.addEventListener("mouseup", function(ev) { arrastrar = false; });
        canvas.addEventListener("mouseleave", function(ev) { arrastrar = false; });
    }

    if(btnGuardarFoto) {
        btnGuardarFoto.onclick = function() {
            let subCanvas = document.createElement("canvas");
            subCanvas.width = recorte.w;
            subCanvas.height = recorte.h;
            subCanvas.getContext("2d").drawImage(
                canvas,
                recorte.x, recorte.y, recorte.w, recorte.h, 0, 0, recorte.w, recorte.h
            );
            let fotoFinalBase64 = subCanvas.toDataURL('image/jpeg');
            inputFotoBase64.value = fotoFinalBase64;
            imgPreview.src = fotoFinalBase64;
            imgPreview.style.display = 'inline-block';
            cerrarCamaraModal();
        }
    }

    function cargarCiclos() {
        fetch('/api/ciclos.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('ultimoCiclo');
                    if(select) {
                        select.innerHTML = '<option value="">Selecciona un ciclo</option>';
                        data.data.forEach(ciclo => {
                            const option = document.createElement('option');
                            option.value = ciclo.id;
                            option.textContent = `${ciclo.nombre} (${ciclo.codigo})`;
                            select.appendChild(option);
                        });
                    }
                } else {
                    console.error('Error al cargar ciclos:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});