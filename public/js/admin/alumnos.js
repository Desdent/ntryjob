document.addEventListener('DOMContentLoaded', function() {
    
    // cargarEstadisticas();
    listarAlumnos();
    cargarCiclos();
    
    // Botón logout
    const btnLogout = document.getElementById('btnLogout');
        if (btnLogout) {
            btnLogout.addEventListener('click', cerrarSesion);
        }

    // function cargarEstadisticas() {
    //     fetch('/api/admin/estadisticas.php')
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 document.getElementById('total-empresas').textContent = data.empresas || 0;
    //                 document.getElementById('total-ofertas').textContent = data.ofertas || 0;
    //             } else {
    //                 console.error('Error al cargar estadísticas:', data.error);
    //             }
    //         })
    //         .catch(error => console.error('Error:', error));
    // }



    let trasfondoModal = document.querySelector(".trasfondoModal");
    let modalContainer = document.querySelector(".modalContainer");
    let botonCancelar = document.getElementById("btnCancelarModal");
    let botonEquis = document.querySelector(".modal-close");


    /**
     * Mostrar tabla de alumnos y modal de editar
     */
    function mostrarTablaAlumnos(alumnos) {

        const contenedor = document.getElementById('tablaAlumnos');
        contenedor.innerHTML = "";

        let head = document.createElement("thead");
        contenedor.append(head);

        let cabecera = document.createElement("tr");
        head.append(cabecera);

        let headerName = document.createElement("th");
        headerName.innerHTML = "Nombre";
        cabecera.append(headerName);
        let huecoSortName = document.createElement("span");
        huecoSortName.textContent = " ▼";
        headerName.append(huecoSortName);
        

        let headerApellidos = document.createElement("th");
        headerApellidos.innerHTML = "Apellidos";
        cabecera.append(headerApellidos);
        let huecoSortApellidos = document.createElement("span");
        huecoSortApellidos.textContent = " ▼";
        headerApellidos.append(huecoSortApellidos);

        let headerEmail = document.createElement("th");
        headerEmail.innerHTML = "Email";
        cabecera.append(headerEmail);
        let huecoSortEmail = document.createElement("span");
        huecoSortEmail.textContent = " ▼";
        headerEmail.append(huecoSortEmail);

        let headerTelefono = document.createElement("th");
        headerTelefono.innerHTML = "Teléfono";
        cabecera.append(headerTelefono);
        let huecoSortTelefono = document.createElement("span");
        huecoSortTelefono.textContent = " ▼";
        headerTelefono.append(huecoSortTelefono);

        let headerCiudad = document.createElement("th");
        headerCiudad.innerHTML = "Ciudad";
        cabecera.append(headerCiudad);
        let huecoSortCiudad = document.createElement("span");
        huecoSortCiudad.textContent = " ▼";
        headerCiudad.append(huecoSortCiudad);

        let headerActions = document.createElement("th");
        headerActions.innerHTML = "Acciones";
        cabecera.append(headerActions);

        let cuerpo = document.createElement("tbody");
        
        alumnos.forEach(alumno => {

            let fila = document.createElement("tr");
            cuerpo.append(fila);
            

            let celda1 = document.createElement("td");
            celda1.innerHTML = alumno.nombre;
            fila.append(celda1);
            let celda2 = document.createElement("td");
            celda2.innerHTML = alumno.apellidos;
            fila.append(celda2);
            let celda3 = document.createElement("td");
            celda3.innerHTML = alumno.email;
            fila.append(celda3);
            let celda4 = document.createElement("td");
            celda4.innerHTML = alumno.telefono;
            fila.append(celda4);
            let celda5 = document.createElement("td");
            celda5.innerHTML = alumno.ciudad;
            fila.append(celda5);
            let celda6 = document.createElement("td");
            let botonEditar = document.createElement("button");
            botonEditar.style.marginRight = "0.7em";
            let botonBorrar = document.createElement("button");
            botonEditar.innerText="Editar";
            botonEditar.classList.add("botonesAccion");
            botonBorrar.innerText="Borrar";
            botonBorrar.classList.add("botonesAccion");
            celda6.append(botonEditar);
            celda6.append(botonBorrar);
            fila.append(celda6);





            botonEditar.addEventListener("click", function(){
            trasfondoModal.style.display = "block";
            modalContainer.style.display = "block";

            let nombreEdit = document.getElementById("nombre");
            nombreEdit.value = alumno.nombre;

            let apellidosEdit = document.getElementById("apellidos");
            apellidosEdit.value = alumno.apellidos;

            let emailEdit = document.getElementById("email");
            emailEdit.value = alumno.email;

            let fechaNacimientoEdit = document.getElementById("fechaNacimiento");
            fechaNacimientoEdit.value = alumno.fecha_nacimiento;

            let paisEdit = document.getElementById("pais");
            paisEdit.value = alumno.pais;

            let provinciaEdit = document.getElementById("provincia");
            provinciaEdit.value = alumno.provincia;

            let telefonoEdit = document.getElementById("telefono");
            telefonoEdit.value = alumno.telefono;

            let localidadEdit = document.getElementById("localidad");
            localidadEdit.value = alumno.ciudad;

            let codigoPostalEdit = document.getElementById("codigoPostal");
            codigoPostalEdit.value = alumno.codigo_postal;

            let direccionEdit = document.getElementById("direccion");
            direccionEdit.value = alumno.direccion;

            let cicloIdEdit = document.getElementById("ultimoCiclo");
            cicloIdEdit.value = alumno.ciclo_id;

            let fechaInicioEdit = document.getElementById("fechaInicio");
            fechaInicioEdit.value = alumno.fecha_inicio;

            let fetchaFinalizacionEdit = document.getElementById("fechaFinalizacion");
            fetchaFinalizacionEdit.value = alumno.fecha_fin;

            
            })

        
        })

    contenedor.append(cuerpo);
    }

    trasfondoModal.addEventListener("click", function(e){
        if(e.target === trasfondoModal){
        modalContainer.style.display = "none";
        trasfondoModal.style.display = "none";
    }
    })

    botonCancelar.addEventListener("click", function(){
        modalContainer.style.display = "none";
        trasfondoModal.style.display = "none";
    })

    botonEquis.addEventListener("click", function(){
        modalContainer.style.display = "none";
        trasfondoModal.style.display = "none";
    })

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



    






    /**
     * Crear alumno
     */
    function crearAlumno(datosAlumno) {
        fetch('/api/admin/alumnos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosAlumno)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno creado con ID: ' + data.id);
                listarAlumnos();
            } else {
                alert(data.error || 'Error al crear alumno');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }

    /**
     * Editar alumno
     */
    function editarAlumno(id) {
        const datosActualizados = {
            id: id,
            nombre: 'Juan Actualizado',
            apellidos: 'García',
            email: 'juan@mail.com',
            ciclo_id: 1
        };
        
        fetch('/api/admin/alumnos.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosActualizados)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno actualizado');
                listarAlumnos();
            } else {
                alert(data.error || 'Error al actualizar alumno');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }

    /**
     * Eliminar alumno
     */
    function eliminarAlumno(id) {
        if (!confirm('¿Seguro que quieres eliminar este alumno?')) {
            return;
        }
        
        fetch('/api/admin/alumnos.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno eliminado');
                listarAlumnos();
            } else {
                alert(data.error || 'Error al eliminar alumno');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }


    /**
     * Cerrar sesión
     */
    function cerrarSesion() {
        fetch('/api/auth/logout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href ='public/index.php?page=login';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Redirigir de todos modos
            window.location.href = 'public/index.php?page=login';
        });
    }

    /**
     * Listar alumnos
     */
    function listarAlumnos() {
        fetch('/api/admin/alumnos.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Alumnos:', data.alumnos);
                mostrarTablaAlumnos(data.alumnos);
            } else {
                alert(data.error || 'Error al cargar alumnos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }













    let opts = document.querySelectorAll(".optLateral");

    opts[0].innerHTML = "Panel de Alumnos";
    opts[1].innerHTML = "Panel de Empresas";
    opts[2].innerHTML = "Panel de Ofertas";


    opts[0].addEventListener("click", function(){
        window.location.href ='index.php?page=dashboard-admin-alumnos'
    })
    opts[1].addEventListener("click", function(){
        window.location.href ='index.php?page=dashboard-admin-ofertas'
    })
    opts[2].addEventListener("click", function(){
        window.location.href ='index.php?page=dashboard-admin-empresas'
    })

});
