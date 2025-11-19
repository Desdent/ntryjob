document.addEventListener('DOMContentLoaded', function() {
    
    const PAGE_SIZE = 10; 
    let currentPage = 1;
    let alumnosData = []; 

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

    const contenedor = document.getElementById('tablaAlumnos');
        
    let head = document.createElement("thead");
    contenedor.append(head);

    let cabecera = document.createElement("tr");
    head.append(cabecera);

    let headerName = document.createElement("th");
    headerName.innerHTML = "Nombre";
    cabecera.append(headerName);
    let huecoSortName = document.createElement("span");
    huecoSortName.textContent = "  ◀"; 
    headerName.append(huecoSortName);

    let headerApellidos = document.createElement("th");
    headerApellidos.innerHTML = "Apellidos";
    cabecera.append(headerApellidos);
    let huecoSortApellidos = document.createElement("span");
    huecoSortApellidos.textContent = "  ◀";
    headerApellidos.append(huecoSortApellidos);

    let headerEmail = document.createElement("th");
    headerEmail.innerHTML = "Email";
    cabecera.append(headerEmail);
    let huecoSortEmail = document.createElement("span");
    huecoSortEmail.textContent = "  ◀";
    headerEmail.append(huecoSortEmail);

    let headerTelefono = document.createElement("th");
    headerTelefono.innerHTML = "Teléfono";
    cabecera.append(headerTelefono);
    let huecoSortTelefono = document.createElement("span");
    huecoSortTelefono.textContent = "  ◀";
    headerTelefono.append(huecoSortTelefono);

    let headerCiudad = document.createElement("th");
    headerCiudad.innerHTML = "Ciudad";
    cabecera.append(headerCiudad);
    let huecoSortCiudad = document.createElement("span");
    huecoSortCiudad.textContent = "  ◀";
    headerCiudad.append(huecoSortCiudad);

    let headerActions = document.createElement("th");
    headerActions.innerHTML = "Acciones";
    cabecera.append(headerActions);

    let cuerpo = document.createElement("tbody");

    function vaciarContenidoCeldas() {
        const tbody = document.querySelector('#tablaAlumnos tbody');
        if (!tbody) {
            cuerpo = document.createElement("tbody");
            contenedor.append(cuerpo);
        } else {
            tbody.innerHTML = "";
            cuerpo = tbody;
        }
    }

    function restaurarOpciones(botonPulsado) {
        const headers = [
            { el: headerName, arrow: huecoSortName, field: "nombre" },
            { el: headerApellidos, arrow: huecoSortApellidos, field: "apellidos" },
            { el: headerEmail, arrow: huecoSortEmail, field: "email" },
            { el: headerTelefono, arrow: huecoSortTelefono, field: "telefono" },
            { el: headerCiudad, arrow: huecoSortCiudad, field: "ciudad" },
        ];

        headers.forEach(h => {
            if (h.field !== botonPulsado) {
                h.el.classList.remove("ascendente", "descendente");
                h.arrow.textContent = "  ◀";
            }
        });
    }

    function mostrarTablaAlumnos(alumnos) {
        if (alumnos) {
            alumnosData = alumnos;
            currentPage = 1; 
        }
        
        vaciarContenidoCeldas();
        
        const startIndex = (currentPage - 1) * PAGE_SIZE;
        const endIndex = startIndex + PAGE_SIZE;
        const alumnosPagina = alumnosData.slice(startIndex, endIndex);

        headerName.onclick = function(){
            currentPage = 1;
            if(headerName.classList.contains("ascendente")){
                headerName.classList.remove("ascendente");
                headerName.classList.add("descendente");
                alumnosData.sort((a,b) => b.nombre.localeCompare(a.nombre));
                huecoSortName.textContent = " ▲";
            } else {
                headerName.classList.remove("descendente");
                headerName.classList.add("ascendente");
                alumnosData.sort((a,b) => a.nombre.localeCompare(b.nombre));
                huecoSortName.textContent = " ▼"
            }
            restaurarOpciones("nombre");
            mostrarTablaAlumnos();
        }

        headerApellidos.onclick = function(){
            currentPage = 1;
            if(headerApellidos.classList.contains("ascendente")){
                headerApellidos.classList.remove("ascendente");
                headerApellidos.classList.add("descendente");
                alumnosData.sort((a,b) => b.apellidos.localeCompare(a.apellidos));
                huecoSortApellidos.textContent = " ▲";
            } else {
                headerApellidos.classList.remove("descendente");
                headerApellidos.classList.add("ascendente");
                alumnosData.sort((a,b) => a.apellidos.localeCompare(b.apellidos));
                huecoSortApellidos.textContent = " ▼";
            }
            restaurarOpciones("apellidos");
            mostrarTablaAlumnos();
        }
        
        headerEmail.onclick = function(){
            currentPage = 1;
            if(headerEmail.classList.contains("ascendente")){
                headerEmail.classList.remove("ascendente");
                headerEmail.classList.add("descendente");
                alumnosData.sort((a,b) => b.email.localeCompare(a.email));
                huecoSortEmail.textContent = " ▲";
            } else {
                headerEmail.classList.remove("descendente");
                headerEmail.classList.add("ascendente");
                alumnosData.sort((a,b) => a.email.localeCompare(b.email));
                huecoSortEmail.textContent = " ▼";
            }
            restaurarOpciones("email");
            mostrarTablaAlumnos();
        }

        headerTelefono.onclick = function(){
            currentPage = 1;
            if(headerTelefono.classList.contains("ascendente")){
                headerTelefono.classList.remove("ascendente");
                headerTelefono.classList.add("descendente");
                alumnosData.sort((a,b) => b.telefono.localeCompare(a.telefono)); 
                huecoSortTelefono.textContent = " ▲";
            } else {
                headerTelefono.classList.remove("descendente");
                headerTelefono.classList.add("ascendente");
                alumnosData.sort((a,b) => a.telefono.localeCompare(b.telefono));
                huecoSortTelefono.textContent = " ▼";
            }
            restaurarOpciones("telefono");
            mostrarTablaAlumnos();
        }

        headerCiudad.onclick = function(){
            currentPage = 1;
            if(headerCiudad.classList.contains("ascendente")){
                headerCiudad.classList.remove("ascendente");
                headerCiudad.classList.add("descendente");
                alumnosData.sort((a,b) => b.ciudad.localeCompare(a.ciudad));
                huecoSortCiudad.textContent = " ▲";
            } else {
                headerCiudad.classList.remove("descendente");
                headerCiudad.classList.add("ascendente");
                alumnosData.sort((a,b) => a.ciudad.localeCompare(b.ciudad));
                huecoSortCiudad.textContent = " ▼";
            }
            restaurarOpciones("ciudad");
            mostrarTablaAlumnos();
        }
        
        alumnosPagina.forEach(alumno => {
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
        renderizarPaginacionAlumnos();
    }

    function renderizarPaginacionAlumnos() {
        const contenedorPaginacion = document.querySelector('#tablaAlumnos + p');
        contenedorPaginacion.innerHTML = '';
        contenedorPaginacion.classList.add('pagination-area'); 

        const totalPages = Math.ceil(alumnosData.length / PAGE_SIZE);

        if (totalPages > 1) {
            const divPaginacion = document.createElement('div');
            divPaginacion.classList.add('pagination-controls');

            const btnPrev = document.createElement('button');
            btnPrev.textContent = 'Anterior';
            btnPrev.classList.add('botonesAccion'); 
            btnPrev.disabled = currentPage === 1;
            btnPrev.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    mostrarTablaAlumnos(); 
                }
            };
            divPaginacion.appendChild(btnPrev);

            const spanPage = document.createElement('span');
            spanPage.textContent = ` Página ${currentPage} de ${totalPages} `;
            divPaginacion.appendChild(spanPage);

            const btnNext = document.createElement('button');
            btnNext.textContent = 'Siguiente';
            btnNext.classList.add('botonesAccion'); 
            btnNext.disabled = currentPage === totalPages;
            btnNext.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    mostrarTablaAlumnos();
                }
            };
            divPaginacion.appendChild(btnNext);
            contenedorPaginacion.appendChild(divPaginacion);
        }
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
                    
                    select.innerHTML = '<option value="">Selecciona un ciclo</option>';
                    if (selectMassive) {
                        selectMassive.innerHTML = '<option value="">Selecciona un ciclo</option>';
                    }
                    
                    data.data.forEach(ciclo => {
                        const option = document.createElement('option');
                        option.value = ciclo.id;
                        option.textContent = `${ciclo.nombre} (${ciclo.codigo})`;
                        select.appendChild(option); 

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
        if (!datosAlumno.nombre || !datosAlumno.apellidos || !datosAlumno.email || !datosAlumno.telefono) {
            alert('Por favor completa todos los campos requeridos');
            return;
        }

        fetch('/api/admin/AlumnosController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datosAlumno)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Alumno creado con ID: ' + data.id);
                modalAdd.style.display = "none";
                trasfondoModal.style.display = "none";
                listarAlumnos();
                
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
        fetch('/api/admin/AlumnosController.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
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
            headers: { 'Content-Type': 'application/json' }
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
        currentPage = 1; 
        fetch('/api/admin/AlumnosController.php?email', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
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

    function listarBusquedaAlumnos(searchValue) {
        currentPage = 1; 
        fetch('/api/admin/AlumnosController.php?searchValue=' +encodeURIComponent(searchValue), {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                vaciarContenidoCeldas();
                mostrarTablaAlumnos(data.data);
                restaurarOpciones("default");
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
    if (modalContainerMassive) modalContainerMassive.append(modalHeaderMassive);

    let h2HeaderMassive = document.createElement("h2");
    h2HeaderMassive.innerText = "Carga Masiva de Alumnos";
    modalHeaderMassive.append(h2HeaderMassive);

    let modalCloseMassive = document.createElement("span");
    modalCloseMassive.classList.add("modal-closeMassive");
    modalCloseMassive.innerHTML = "&times;";
    modalHeaderMassive.append(modalCloseMassive);

    let modalBodyMassive = document.createElement("div");
    modalBodyMassive.classList.add("modalBodyMassive");
    if (modalContainerMassive) modalContainerMassive.append(modalBodyMassive);

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
    divTextoEjemplo.innerHTML = "Juan,García,juan@alumno.com,654123789,Jaén" +
                            "<br>" +"Maria,Soleras Viñas,maria@alumno.com,654197789,Jaén" +
                            "<br>" +"Carlos,Solera Viñas,Carlos@alumno.com,664197789,Torredelcampo";
    divTextoEjemplo.classList.add("hide");
    containerEjemplo.append(divTextoEjemplo);

    divBotonEjemplo.append(botonEjemplo);
    botonEjemplo.onclick = function(){
        if(divTextoEjemplo.classList.contains("hide")) {
            divTextoEjemplo.classList.remove("hide");
            divTextoEjemplo.classList.add("show");
            botonEjemplo.innerHTML = "Ocultar";
        } else {
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
        tableContainerAdd.innerHTML = '';
        const reader = new FileReader();
        reader.onload = async function(e){
            const fileContenido = e.target.result;
            await parsearCSV(fileContenido, tableContainerAdd);
            btnEnviar.classList.remove("hide");
            btnEnviar.classList.add("show");
        };
        reader.readAsText(file, "UTF-8");
    }

    async function parsearCSV(fileContent, tableContainerAdd) {
        const DELIMITADOR = ','; 
        let rows = fileContent.trim().split("\n");
        
        let headers = ['nombre', 'apellidos', 'email', 'telefono', 'ciudad'];
        let startRow = 1;
        
        let tableMassiveHeaderContainer = document.createElement("thead");
        tableContainerAdd.append(tableMassiveHeaderContainer);
        let cabecera = document.createElement("tr");
        tableMassiveHeaderContainer.append(cabecera);

        let celdaInicio = document.createElement("th");
        celdaInicio.innerHTML = "Selección";
        cabecera.append(celdaInicio);

        headers.forEach(header => {
            let celda = document.createElement("th");
            celda.innerHTML = header.trim();
            cabecera.append(celda);
        });

        let celdaFinal = document.createElement("th");
        celdaFinal.innerHTML = "Válido";
        cabecera.append(celdaFinal);

        let tableMassiveBodyContainer = document.createElement("tbody");
        tableContainerAdd.append(tableMassiveBodyContainer);

        for(let i = startRow; i < rows.length; i++) {
            let values = rows[i].split(DELIMITADOR);
            if(values.length < 2) continue; // Saltar líneas vacías

            let fila = document.createElement("tr");
            tableMassiveBodyContainer.append(fila);

            let inputs = [];
            
            let celdaCheckbox = document.createElement("td");
            let checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.disabled = true;
            celdaCheckbox.append(checkbox);
            fila.append(celdaCheckbox);
            
            for(let j = 0; j < headers.length; j++) {
                let celda = document.createElement("td");
                let clave = headers[j].trim();
                let valor = values[j] ? values[j].trim() : '';
                
                let input = document.createElement("input");
                input.type = "text";
                input.value = valor;
                input.classList.add("inputsMassiveAdd");
                input.dataset.field = clave;
                
                celda.append(input);
                inputs.push(input);

                input.addEventListener("blur", async function() {
                    await validarFilaCompleta(fila, inputs, headers);
                });
                
                fila.append(celda);
            }
            
            let celdaValidacion = document.createElement("td");
            celdaValidacion.classList.add('validation-cell');
            fila.append(celdaValidacion);
            
            setTimeout(async () => {
                await validarFilaCompleta(fila, inputs, headers);
            }, 100);
        }

        btnEnviar.onclick = function() {
            const selectCiclo = document.querySelector(".selectMassive") || document.getElementById("inputFamilia");
            if(!selectCiclo) { alert("Error selector ciclo"); return; }
            const cicloId = selectCiclo.value;
            if(!cicloId) { alert("Selecciona un ciclo"); return; }
            
            let alumnosSeleccionados = [];
            const checkboxes = tableContainerAdd.querySelectorAll('input[type="checkbox"]:checked:not(:disabled)');
            
            checkboxes.forEach(checkbox => {
                const fila = checkbox.closest('tr'); 
                const inputs = fila.querySelectorAll('.inputsMassiveAdd');
                let alumno = {};
                inputs.forEach(input => { 
                    const campo = input.dataset.field.trim();
                    alumno[campo] = input.value.trim();
                });
                alumno["ciclo_id"] = parseInt(cicloId);
                alumnosSeleccionados.push(alumno);
            });
            
            if(alumnosSeleccionados.length === 0) {
                alert("Selecciona al menos un alumno válido");
                return;
            }
            
            fetch("/api/admin/AlumnosController.php?accion=massive", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(alumnosSeleccionados),
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    alert(`Alumnos añadidos correctamente: ${data.creados}`);
                    modalContainerMassive.style.display = "none";
                    trasfondoModal.style.display = "none";
                    listarAlumnos();
                    tableContainerAdd.innerHTML = "";
                    inputCSV.value = '';
                    btnEnviar.classList.remove("show");
                    btnEnviar.classList.add("hide");
                } else {
                    alert(data.error || "Error masivo");
                }
            });
        };
    }

    async function validarFilaCompleta(fila, inputs, headers) {
        let esValida = true;
        
        for (const input of inputs) {
            const valor = input.value.trim();
            const campo = input.dataset.field.toLowerCase();
            
            let inputValido = true;

            if (valor === '') {
                inputValido = false;
            }
            else if (campo === 'telefono') {
                if (!Validators.esTelefono(valor)) inputValido = false;
            }
            else if (campo === 'email' || campo === 'correo') {
                if (!Validators.esEmail(valor)) {
                    inputValido = false;
                } else {
                    const existe = await verificarEmailExistente(valor);
                    if (existe) inputValido = false;
                }
            }
            else if (campo === 'nombre' || campo === 'apellidos') {
                if (!Validators.esTexto(valor)) inputValido = false;
            }

            input.style.backgroundColor = inputValido ? "#ffffff" : "#fc8989ff";
            if (!inputValido) esValida = false;
        }
        
        actualizarEstadoFila(fila, esValida);
        return esValida;
    }

    function actualizarEstadoFila(fila, esValida) {
        const celdaValidez = fila.querySelector('td:last-child');
        const celdaCheck = fila.querySelector('td:first-child');
        const checkbox = celdaCheck.querySelector('input[type="checkbox"]');
        
        if (esValida) {
            fetch("/public/assets/imagenes/check-circle.svg")
                .then(response => response.text())
                .then(data => { celdaValidez.innerHTML = data; });
            checkbox.disabled = false;
        } else {
            fetch("/public/assets/imagenes/cross-mark.svg")
                .then(response => response.text())
                .then(data => { celdaValidez.innerHTML = data; });
            checkbox.disabled = true;
            checkbox.checked = false;
        }
    }

    function verificarEmailExistente(email) {
        if (!email || email.trim() === '') return Promise.resolve(false);
        return fetch('/api/auth/email_exists.php?email=' + encodeURIComponent(email))
            .then(r => r.json())
            .then(data => data.existe || false)
            .catch(() => false);
    }

    let inputSearch = document.getElementById("search-admin");
    inputSearch.addEventListener("keypress", function(e){
        if(e.key ==="Enter") {
            if(this.value == "") listarAlumnos();
            else listarBusquedaAlumnos(this.value);
        }
    })

    let opts = document.querySelectorAll(".optLateral");
    opts[0].innerHTML = "Panel de Alumnos";
    opts[1].innerHTML = "Panel de Empresas";
    opts[2].innerHTML = "Estadísticas";
    opts[0].addEventListener("click", function(){ window.location.href ='index.php?page=dashboard-admin-alumnos' })
    opts[1].addEventListener("click", function(){ window.location.href ='index.php?page=dashboard-admin-empresas' })
    opts[2].addEventListener("click", function(){ window.location.href ='index.php?page=dashboard-admin-estadisticas'});
    
});