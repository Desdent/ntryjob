document.addEventListener('DOMContentLoaded', function() {


    cargarCiclos();
    
    const modal = document.getElementById('modalRegistroAlumno');
    const btnAbrir = document.getElementById('btnAbrirModalAlumno');
    const btnCerrar = document.querySelector('.modal-close');
    const btnCancelar = document.getElementById('btnCancelarModal');
    const form = document.getElementById('formRegistroAlumno');
    
    // ========== ABRIR/CERRAR MODAL ==========
    
    btnAbrir.addEventListener('click', function() {
        modal.style.display = 'block';
    });
    
    btnCerrar.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    btnCancelar.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Cerrar al hacer clic fuera del modal
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // ========== VALIDACIONES EN TIEMPO REAL ==========
    
    const campos = form.querySelectorAll('input[required]');
    
    campos.forEach(campo => {
        campo.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        // Limpiar validación al empezar a escribir
        campo.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                this.classList.remove('invalid');
                this.nextElementSibling.textContent = '';
            }
        });
    });
    
    // ========== FUNCIÓN DE VALIDACIÓN ==========
    
    function validarCampo(campo) {
        const valor = campo.value.trim();
        const nombre = campo.name;
        const errorSpan = campo.nextElementSibling;
        
        // Limpiar estados previos
        campo.classList.remove('valid', 'invalid');
        errorSpan.textContent = '';
        
        // Validar si está vacío
        if (valor === '') {
            if (campo.required) {
                campo.classList.add('invalid');
                errorSpan.textContent = 'Este campo es obligatorio';
                return false;
            }
            return true;
        }
        
        // Validaciones específicas por tipo de campo
        switch(nombre) {
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(valor)) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Email inválido';
                    return false;
                }
                // Verificar si el email ya existe (AJAX)
                verificarEmailExistente(campo, errorSpan);
                break;
                
            case 'telefono':
                const telRegex = /^[0-9]{9,15}$/;
                if (!telRegex.test(valor)) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Teléfono inválido (9-15 dígitos)';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'codigoPostal':
                const cpRegex = /^[0-9]{5}$/;
                if (!cpRegex.test(valor)) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Código postal inválido (5 dígitos)';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'password':
                if (valor.length < 6) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Mínimo 6 caracteres';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'fechaNacimiento':
                const hoy = new Date();
                const fechaNac = new Date(valor);
                const edad = hoy.getFullYear() - fechaNac.getFullYear();
                if (edad < 16 || edad > 100) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Edad debe estar entre 16 y 100 años';
                    return false;
                }
                campo.classList.add('valid');
                break;
                
            case 'subirCV':
                const archivo = campo.files[0];
                if (archivo) {
                    const extensiones = ['pdf', 'docx'];
                    const ext = archivo.name.split('.').pop().toLowerCase();
                    if (!extensiones.includes(ext)) {
                        campo.classList.add('invalid');
                        errorSpan.textContent = 'Solo PDF o DOCX';
                        return false;
                    }
                    if (archivo.size > 5 * 1024 * 1024) { // 5MB
                        campo.classList.add('invalid');
                        errorSpan.textContent = 'Máximo 5MB';
                        return false;
                    }
                    campo.classList.add('valid');
                }
                break;
                
            default:
                // Validación genérica (no vacío y mínimo 2 caracteres)
                if (valor.length < 2) {
                    campo.classList.add('invalid');
                    errorSpan.textContent = 'Mínimo 2 caracteres';
                    return false;
                }
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
        
        // Validar todos los campos
        let todosValidos = true;
        campos.forEach(campo => {
            if (!validarCampo(campo)) {
                todosValidos = false;
            }
        });
        
        if (!todosValidos) {
            alert('Por favor, corrige los errores en el formulario');
            return;
        }
        
        const formData = new FormData();
        
        // Añadir campos
        formData.append('nombre', document.getElementById('nombre').value);
        formData.append('apellidos', document.getElementById('apellidos').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('telefono', document.getElementById('telefono').value);
        formData.append('pais', document.getElementById('pais').value);
        formData.append('provincia', document.getElementById('provincia').value);
        formData.append('ciudad', document.getElementById('localidad').value);
        formData.append('codigo_postal', document.getElementById('codigoPostal').value);
        formData.append('direccion', document.getElementById('direccion').value);
        formData.append('fecha_nacimiento', document.getElementById('fechaNacimiento').value);
        formData.append('ciclo_id', document.getElementById('ultimoCiclo').value);
        formData.append('fecha_inicio', document.getElementById('fechaInicio').value);
        
        const fechaFin = document.getElementById('fechaFinalizacion').value;
        if (fechaFin) {
            formData.append('fecha_fin', fechaFin);
        }
        
        // Añadir  CV
        const archivoCV = document.getElementById('subirCV').files[0];
        if (archivoCV) {
            formData.append('cv', archivoCV);
        }
        
        // Añadir foto Base64
        const fotoBase64 = document.getElementById('fotoAlumnoBase64').value;
        if (fotoBase64) {
            formData.append('foto_base64', fotoBase64);
        }
        
        // Deshabilitar botón de envío
        const btnSubmit = form.querySelector('button[type="submit"]');
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Registrando...';
        
        // Enviar Formdata
        fetch('/api/auth/registro-alumno.php', {
            method: 'POST',
            body: formData  // FormData maneja archivos el solo
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Registro exitoso. Ya puedes iniciar sesión.');
                window.location.href = '/public/index.php?page=login';
            } else {
                alert(data.error || 'Error al registrarse');
                btnSubmit.disabled = false;
                btnSubmit.textContent = 'Registrarse';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión. Intenta de nuevo.');
            btnSubmit.disabled = false;
            btnSubmit.textContent = 'Registrarse';
        });
    });





let stream = null;
let arrastrar = false;
let seMueve = false;
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

btnAbrirCamara.addEventListener('click', function() {
  modalCamara.style.display = 'block'; // Muestra el modal cámara
  canvas.style.display = 'none';
  btnCapturarFoto.style.display = 'inline-block';
  btnGuardarFoto.style.display = 'none';
  video.style.display = 'inline-block';
  // Activa la cam
  navigator.mediaDevices.getUserMedia({ video: true }).then(function(s) {
    stream = s;
    video.srcObject = stream;
  }).catch(function(err) {
    alert('No se pudo acceder a la cámara.');
    modalCamara.style.display = 'none';
  });
});

function cerrarCamaraModal() {
  modalCamara.style.display = 'none'; // Oculta el modal cámara
  // Detiene la cam
  if (stream) {
    let tracks = stream.getTracks();
    for (let i=0; i<tracks.length; i++) tracks[i].stop();
    stream = null;
  }
  video.style.display = 'inline-block';
  canvas.style.display = 'none';
  arrastrar = false;
}
btnCancelarFoto.onclick = cerrarCamaraModal;
modalClose.onclick = cerrarCamaraModal;
window.addEventListener('click', function(e) {
  if (e.target === modalCamara) cerrarCamaraModal();
});


btnCapturarFoto.onclick = function() {
    let ctx = canvas.getContext("2d");
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    renderRecorte();
    canvas.style.display = "block";
    video.style.display = "none";
    btnCapturarFoto.style.display = "none";
    btnGuardarFoto.style.display = "inline-block";
};


//el cuadro
function renderRecorte() {
    let ctx = canvas.getContext("2d");
    //pintar la imagen
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    ctx.save();
    ctx.strokeStyle = "#2563eb";
    ctx.lineWidth = 3;
    ctx.setLineDash([8, 6]);
    ctx.strokeRect(recorte.x, recorte.y, recorte.w, recorte.h);
    ctx.restore();
}

canvas.addEventListener("wheel", function(e) {
    if(!e.ctrlKey){
        return;
    }

    //cambiar el tamaño
    let factor = e.deltaY < 0 ? 1.05 : 0.95;
    let newW = recorte.w * factor;
    let newH = recorte.h * factor;

    //para el tamaño min
    newW = Math.max(50, Math.min(newW, canvas.width));
    newH = Math.max(50, Math.min(newH, canvas.height));
    if(recorte.x + newW > canvas.width)
    {
        newW = canvas.width-recorte.x;
    }

    if(recorte.y + newH > canvas.height)
    {
        newH = canvas.height-recorte.y;
    }

    recorte.w = newW;
    recorte.h = newH;
    renderRecorte();
});


canvas.addEventListener("mousedown", function(ev) {

    if(!ev.ctrlKey){
        return;
    }
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
})

canvas.addEventListener("mouseup", function(ev) {
    arrastrar = false;
})
canvas.addEventListener("mouseleave", function(ev) {
    arrastrar = false;
})


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



function cargarCiclos() {
    fetch('/api/ciclos.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('ultimoCiclo');
                select.innerHTML = '<option value="">Selecciona un ciclo</option>';
                
                data.data.forEach(ciclo => {
                    const option = document.createElement('option');
                    option.value = ciclo.id;
                    option.textContent = `${ciclo.nombre} (${ciclo.codigo})`;
                    select.appendChild(option);
                });
            } else {
                console.error('Error al cargar ciclos:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

});