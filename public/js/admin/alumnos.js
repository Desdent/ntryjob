document.addEventListener('DOMContentLoaded', function() {
    
    listarAlumnos();
    cargarCiclos();
    
    const btnLogout = document.getElementById('btnLogout');
    if (btnLogout) {
        btnLogout.addEventListener('click', cerrarSesion);
    }

    let trasfondoModal = document.querySelector(".trasfondoModal");
    let modalContainer = document.querySelector(".modalContainer");
    let botonCancelar = document.getElementById("btnCancelarModal");
    let botonEquis = document.querySelector(".modal-close");
    let botonActualizar = document.querySelector(".btn-actualizar");

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
            let id = alumno.id;

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
            botonBorrar.classList.add("btnBorrar");
            celda6.append(botonEditar);
            celda6.append(botonBorrar);
            fila.append(celda6);

            botonBorrar.onclick = function(e){
                eliminarAlumno(id);
            }

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

                let alumnoId = alumno.id;

                console.log(alumno.nombre);

                botonActualizar.onclick = function(e) {
                    e.preventDefault();

                    let campos = {
                        id: alumnoId,
                        nombre: nombreEdit.value,
                        apellidos: apellidosEdit.value,
                        email: emailEdit.value,
                        fecha_nacimiento: fechaNacimientoEdit.value,
                        pais: paisEdit.value,
                        provincia: provinciaEdit.value,
                        telefono: telefonoEdit.value,
                        ciudad: localidadEdit.value,
                        codigo_postal: codigoPostalEdit.value,
                        direccion: direccionEdit.value,
                        ciclo_id: cicloIdEdit.value,
                        fecha_inicio: fechaInicioEdit.value,
                        fecha_fin: fetchaFinalizacionEdit.value
                    }

                    editarAlumno(campos);
                }
            })
        })

        contenedor.append(cuerpo);
    }

    trasfondoModal.addEventListener("click", function(e){
        if(e.target === trasfondoModal){
            modalContainer.style.display = "none";
            trasfondoModal.style.display = "none";
            modalAdd.style.display = "none";
            modalContainerMassive.style.display = "none";
        }
    })

    botonCancelar.addEventListener("click", function(e){
        e.preventDefault();
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
                    const selectMassive = document.querySelector(".selectMassive"); 
                    
                    // Limpiar antes de rellenar
                    select.innerHTML = '<option value="">Selecciona un ciclo</option>';

                    // Solo limpiar de nuevo ssi el selectMassive existe
                    if (selectMassive) {
                        selectMassive.innerHTML = '<option value="">Selecciona un ciclo</option>';
                    }
                    
                    data.data.forEach(ciclo => {

                        // Crea el option base
                        const option = document.createElement('option');
                        option.value = ciclo.id;
                        option.textContent = `${ciclo.nombre} (${ciclo.codigo})`;

                        // agrega al select
                        select.appendChild(option); 

                        // 3. Crear una copia para el otro select
                        if (selectMassive) {
                            const optionMassive = option.cloneNode(true);
                            selectMassive.appendChild(optionMassive);
                        }
                    });
                } else {
                    console.error('Error al cargar ciclos:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }


    let btnAddAlumno = document.getElementById("createUser");
    let modalAdd = document.querySelector(".modalContainerAdd");
    let botonCancelarAdd = document.getElementById("btnCancelarModalAdd");
    let botonEquisAdd = document.querySelector(".modal-closeAdd");
    let botonAdd = document.getElementById("btnAdd");

    botonCancelarAdd.onclick = function(){
        trasfondoModal.style.display = "none";
        modalAdd.style.display = "none";
    }

    botonEquisAdd.onclick = function(){
        trasfondoModal.style.display = "none";
        modalAdd.style.display = "none";
    }

    btnAddAlumno.onclick = function(e){
        e.preventDefault()

        if (modalContainerMassive) {
            modalContainerMassive.style.display = "none"; 
        }

        let campoNombreAdd = document.getElementById("nombreAdd");
        let campoApellidosAdd = document.getElementById("apellidosAdd");
        let campoEmailAdd = document.getElementById("emailAdd");
        let campoTelefonoAdd = document.getElementById("telefonoAdd");

        e.preventDefault();
        trasfondoModal.style.display = "block";
        modalAdd.style.display = "block";

        botonAdd.onclick = function(ev){
            ev.preventDefault()

            let camposAdd = {
                nombre: campoNombreAdd.value,
                apellidos: campoApellidosAdd.value,
                email: campoEmailAdd.value,
                telefono: campoTelefonoAdd.value
            }

            crearAlumno(camposAdd);
        }
    }

    function crearAlumno(datosAlumno) {
        // Validar campos requeridos
        if (!datosAlumno.nombre || !datosAlumno.apellidos || !datosAlumno.email || !datosAlumno.telefono) {
            alert('Por favor completa todos los campos requeridos');
            return;
        }

        fetch('/api/admin/AlumnosController.php', {
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
                modalAdd.style.display = "none";
                trasfondoModal.style.display = "none";
                listarAlumnos();
                
                // Limpiar formulario
                document.getElementById("nombreAdd").value = '';
                document.getElementById("apellidosAdd").value = '';
                document.getElementById("emailAdd").value = '';
                document.getElementById("telefonoAdd").value = '';
            } else {
                alert(data.error || 'Error al crear alumno');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }


    function editarAlumno(datos) {
        const datosActualizados = {
            id: datos.id,
            nombre: datos.nombre,
            apellidos: datos.apellidos,
            email: datos.email,
            telefono: datos.telefono,
            fecha_nacimiento: datos.fecha_nacimiento,
            pais: datos.pais,
            provincia: datos.provincia,
            ciudad: datos.ciudad,
            direccion: datos.direccion,
            codigo_postal: datos.codigo_postal,
            ciclo_id: datos.ciclo_id,
            fecha_inicio: datos.fecha_inicio,
            fecha_fin: datos.fecha_fin
        };

        fetch('/api/admin/AlumnosController.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosActualizados)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno actualizado correctamente');
                listarAlumnos();
                modalContainer.style.display = "none";
                trasfondoModal.style.display = "none";
            } else {
                alert(data.error || 'Error al actualizar alumno');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }

    function eliminarAlumno(id) {
        if (!confirm('¿Seguro que quieres eliminar este alumno?')) {
            return;
        }
        
        fetch('/api/admin/AlumnosController.php?id=' + id, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno eliminado correctamente');
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
            window.location.href = 'public/index.php?page=login';
        });
    }

    function listarAlumnos() {
        
        fetch('/api/admin/AlumnosController.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Datos parseados:', data);
            
            if (data.success) {
                console.log('Alumnos cargados:', data.data);
                mostrarTablaAlumnos(data.data);
            } else {
                alert(data.error || 'Error al cargar alumnos');
            }
        })
        .catch(error => {
            console.error('Error completo:', error);
            alert('Error: ' + error.message);
        });
    }

    let modalContainerMassive = document.querySelector(".modalContainerMassive");

    let modalHeaderMassive = document.createElement("div");
    modalHeaderMassive.classList.add("modal-headerMassive");
    if (modalContainerMassive) {
        modalContainerMassive.append(modalHeaderMassive);
    }

    let h2HeaderMassive = document.createElement("h2");
    h2HeaderMassive.innerText = "Carga Masiva de Alumnos";
    modalHeaderMassive.append(h2HeaderMassive);

    let modalCloseMassive = document.createElement("span");
    modalCloseMassive.classList.add("modal-closeMassive");
    modalCloseMassive.innerHTML = "&times;";
    modalHeaderMassive.append(modalCloseMassive);

    let modalBodyMassive = document.createElement("div");
    modalBodyMassive.classList.add("modalBodyMassive");
    if (modalContainerMassive) {
        modalContainerMassive.append(modalBodyMassive);
    }

    let containerCargarCSV = document.createElement("div");
    modalBodyMassive.append(containerCargarCSV); 

    let h3CSV = document.createElement("h3");
    h3CSV.innerHTML = "Cargar CSV";
    containerCargarCSV.append(h3CSV);

    let inputCSV = document.createElement("input");
    inputCSV.type = "file";
    inputCSV.id = "inputFile";
    inputCSV.classList.add("camposCSV");
    containerCargarCSV.append(inputCSV);

    let containerCargarFamilia = document.createElement("div");
    modalBodyMassive.append(containerCargarFamilia);

    let h3Familia = document.createElement("h3");
    h3Familia.innerHTML = "Ciclo Profesional";
    containerCargarFamilia.append(h3Familia);
    containerCargarFamilia.classList.add("containerCargarFamilia");

    let inputFamilia = document.createElement("select");
    inputFamilia.classList.add("selectMassive");
    inputFamilia.classList.add("camposCSV");
    inputFamilia.id = "inputFamilia";
    containerCargarFamilia.append(inputFamilia);

    modalCloseMassive.onclick = function(){
        trasfondoModal.style.display = "none";
        modalContainerMassive.style.display = "none";
        btnEnviar.classList.remove("show");
        btnEnviar.classList.add("hide");
        tableContainerAdd.innerHTML = "";
        inputCSV.value = '';
    }

    let btnMassiveAdd = document.getElementById("massiveAdd");

    btnMassiveAdd.onclick = function(e){
        e.preventDefault();

        trasfondoModal.style.display = "block";
        modalContainerMassive.style.display = "block";
    }

    let containerEjemplo = document.createElement("div");
    modalBodyMassive.append(containerEjemplo);

    let h3Ejemplo = document.createElement("h3");
    h3Ejemplo.innerHTML = "Ejemplo de formato CSV";
    containerEjemplo.append(h3Ejemplo);

    let divBotonEjemplo = document.createElement("div");
    containerEjemplo.append(divBotonEjemplo);
    botonEjemplo = document.createElement("button");
    botonEjemplo.innerHTML = "Mostrar";
    botonEjemplo.classList.add("camposCSV");
    botonEjemplo.id = "botonEjemplo";

    let divTextoEjemplo = document.createElement("div");
    divTextoEjemplo.innerHTML = "Juan;García;juan@alumno.com;654123789;Jaén" +
                            "<br>" +"Maria;Soleras Viñas;maria@alumno.com;654197789;Jaén" +
                            "<br>" +"Carlos;Solera Viñas;Carlos@alumno.com;664197789;Torredelcampo";
    divTextoEjemplo.classList.add("hide");
    containerEjemplo.append(divTextoEjemplo);

    divBotonEjemplo.append(botonEjemplo);
    botonEjemplo.onclick = function(){
        if(divTextoEjemplo.classList.contains("hide"))
        {
            divTextoEjemplo.classList.remove("hide");
            divTextoEjemplo.classList.add("show");
            botonEjemplo.innerHTML = "Ocultar";
        }
        else{
            divTextoEjemplo.classList.remove("show");
            divTextoEjemplo.classList.add("hide");
            botonEjemplo.innerHTML = "Mostrar";
        }
    }

    let btnEnviarContainer = document.createElement("div");
    modalBodyMassive.append(btnEnviarContainer);

    let btnEnviar = document.createElement("button");
    btnEnviar.innerHTML = "Cargar Alumnos";
    btnEnviar.id = "btnEnviarMasivo";
    btnEnviar.classList.add("hide");
    btnEnviarContainer.append(btnEnviar);

    let divParaLaTabla = document.createElement("div");
    modalContainerMassive.append(divParaLaTabla);

    let divContainerListadoAdd = document.createElement("div");
    divParaLaTabla.append(divContainerListadoAdd);

    let tableContainerAdd =  document.createElement("table");
    divContainerListadoAdd.append(tableContainerAdd);
    tableContainerAdd.id = "tableContainerAdd";
    divContainerListadoAdd.id ="divContainerListadoAdd";

    inputCSV.addEventListener("change", function(e){
        const file = e.target.files[0]

        if(file) {
            leerArchivoCSV(file);
        }
    })

    function leerArchivoCSV(file) {
        tableContainerAdd.innerHTML = ''

        const reader = new FileReader()

        reader.onload = function(e){
            const fileContenido = e.target.result;
            const alumnosArray = parsearCSV(fileContenido, tableContainerAdd);

            btnEnviar.classList.remove("hide");
            btnEnviar.classList.add("show");

            console.log("Datos del CSV cogidos:", alumnosArray);

            alumnosArray.forEach(alumno => {

            })
        };

        reader.readAsText(file, "UTF-8");
    }

    function parsearCSV(fileContent, tableContainerAdd) {
        
        let data = [];
        const DELIMITADOR = ','; 
        
        let rows = fileContent.trim().split("\n"); 

        if(rows.length === 0 || rows[0].trim() === "")
        {
            return data; 
        }
        
        let headers = rows[0].split(DELIMITADOR).map(h => h.trim()); 
        
        let tableMassiveHeaderContainer = document.createElement("thead");
        tableContainerAdd.append(tableMassiveHeaderContainer);
        let cabecera = document.createElement("tr");
        tableMassiveHeaderContainer.append(cabecera);

        let celdaInicio = document.createElement("th");
        celdaInicio.innerHTML = "Selección";
        cabecera.append(celdaInicio);

        headers.forEach(header => {
            let celda = document.createElement("th");
            celda.innerHTML = header;
            cabecera.append(celda);
        });

        let celdaFinal = document.createElement("th");
        celdaFinal.innerHTML = "Válido";
        cabecera.append(celdaFinal);

        let tableMassiveBodyContainer = document.createElement("tbody");
        tableContainerAdd.append(tableMassiveBodyContainer);

        for(let i = 1; i < rows.length; i++){
            let values = rows[i].split(DELIMITADOR);

            let alumno = {};
            let fila = document.createElement("tr");
            tableMassiveBodyContainer.append(fila);

            for(let j = 0; j < headers.length + 2; j++){

                let celda = document.createElement("td");
                
                if(j == 0 || j == headers.length + 1)
                {
                    let checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    
                    if (j == headers.length + 1) {
                        checkbox.checked = true; 
                    }

                    celda.append(checkbox);
                }
                else 
                {
                    let clave = headers[j-1].trim();
                    let valor = values[j-1].trim();

                    alumno[clave] = valor;
                    celda.innerHTML = alumno[clave];
                }
                
                fila.append(celda);
            }
            data.push(alumno); 
        }

        return data;
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

