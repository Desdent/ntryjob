document.addEventListener('DOMContentLoaded', function() {
    
    // cargarEstadisticas();
    listarAlumnos();
    
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


    /**
     * Mostrar tabla de alumnos
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

        let headerApellidos = document.createElement("th");
        headerApellidos.innerHTML = "Apellidos";
        cabecera.append(headerApellidos);

        let headerEmail = document.createElement("th");
        headerEmail.innerHTML = "Email";
        cabecera.append(headerEmail);

        let headerTelefono = document.createElement("th");
        headerTelefono.innerHTML = "Teléfono";
        cabecera.append(headerTelefono);

        let headerCiudad = document.createElement("th");
        headerCiudad.innerHTML = "Ciudad";
        cabecera.append(headerCiudad);

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
            botonBorrar.innerText="Borrar";
            celda6.append(botonEditar);
            celda6.append(botonBorrar);
            fila.append(celda6);





            botonEditar.addEventListener("click", function(){
            trasfondoModal.style.display = "block";
            modalContainer.style.display = "block";
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

});
