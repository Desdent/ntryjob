document.addEventListener("DOMContentLoaded", function(){

    let contenedor = document.getElementById("datos-container");

    mostrarMenuIzq()
    mostrarDatos()




    async function mostrarDatos()
    {

        let datos;

        try{
            let response = await fetch("/api/alumno/datosController.php");
            let data = await response.json();

            datos = data.datos;
        }catch(error){
            console.error("Error en la solicitud: ", error);
            alert("Error al encontrar alumno");
        }
        
        

        let form = document.createElement("form");
        contenedor.append(form);

        let div1 = document.createElement("div");
        form.append(div1);
        let div2 = document.createElement("div");
        form.append(div2);
        let div3 = document.createElement("div");
        form.append(div3);
        let div4 = document.createElement("div");
        form.append(div4);
        let div5 = document.createElement("div");
        form.append(div5);
        let div6 = document.createElement("div");
        form.append(div6);
        let div7 = document.createElement("div");
        form.append(div7);

        // --- Campo Nombre y apellidos (div1) ---
        let divNombre = document.createElement("div");
        div1.append(divNombre);
        let labelNombre = document.createElement("label");
        labelNombre.textContent = "Nombre:";
        labelNombre.htmlFor = "inputNombre";
        divNombre.append(labelNombre);
        let inputNombre = document.createElement("input");
        inputNombre.type = "text";
        inputNombre.name = "nombre";
        inputNombre.id = "inputNombre";
        inputNombre.classList.add("inputsDatosAlumno");
        inputNombre.value= datos["nombre"];
        div1.append(inputNombre);

        let divApellidos = document.createElement("div");
        div1.append(divApellidos);
        let labelApellidos = document.createElement("label");
        labelApellidos.textContent = "Apellidos:";
        labelApellidos.htmlFor = "inputApellidos";
        divApellidos.append(labelApellidos);
        let inputApellidos = document.createElement("input");
        inputApellidos.type = "text";
        inputApellidos.name = "apellidos";
        inputApellidos.id = "inputApellidos";
        inputApellidos.classList.add("inputsDatosAlumno");
        inputApellidos.value=datos["apellidos"];
        div1.append(inputApellidos);

        // --- Campos Telefono y Fecha Nacimiento (van a div2) ---
        let divTelefono = document.createElement("div");
        div2.append(divTelefono);
        let labelTelefono = document.createElement("label");
        labelTelefono.textContent = "Teléfono:";
        labelTelefono.htmlFor = "inputTelefono";
        divTelefono.append(labelTelefono);
        let inputTelefono = document.createElement("input");
        inputTelefono.type = "text";
        inputTelefono.name = "telefono";
        inputTelefono.id = "inputTelefono";
        inputTelefono.classList.add("inputsDatosAlumno");
        inputTelefono.value= datos["telefono"];
        div2.append(inputTelefono);

        let divFechaNacimiento = document.createElement("div");
        div2.append(divFechaNacimiento);
        let labelFechaNacimiento = document.createElement("label");
        labelFechaNacimiento.textContent = "Fecha de Nacimiento:";
        labelFechaNacimiento.htmlFor = "inputFechaNacimiento";
        divFechaNacimiento.append(labelFechaNacimiento);
        let inputFechaNacimiento = document.createElement("input");
        inputFechaNacimiento.type = "date";
        inputFechaNacimiento.name = "fecha_nacimiento";
        inputFechaNacimiento.id = "inputFechaNacimiento";
        inputFechaNacimiento.classList.add("inputsDatosAlumno");
        inputFechaNacimiento.value= datos["fecha_nacimiento"];
        div2.append(inputFechaNacimiento);

        // --- Campos Pais y Provincia (van a div3) ---
        let divPais = document.createElement("div");
        div3.append(divPais);
        let labelPais = document.createElement("label");
        labelPais.textContent = "País:";
        labelPais.htmlFor = "inputPais";
        divPais.append(labelPais);
        let inputPais = document.createElement("input");
        inputPais.type = "text";
        inputPais.name = "pais";
        inputPais.id = "inputPais";
        inputPais.classList.add("inputsDatosAlumno");
        inputPais.value = datos["pais"];
        div3.append(inputPais);

        let divProvincia = document.createElement("div");
        div3.append(divProvincia);
        let labelProvincia = document.createElement("label");
        labelProvincia.textContent = "Provincia:";
        labelProvincia.htmlFor = "inputProvincia";
        divProvincia.append(labelProvincia);
        let inputProvincia = document.createElement("input");
        inputProvincia.type = "text";
        inputProvincia.name = "provincia";
        inputProvincia.id = "inputProvincia";
        inputProvincia.classList.add("inputsDatosAlumno");
        inputProvincia.value = datos["provincia"];
        div3.append(inputProvincia);

        // --- Campos Ciudad y Direccion (van a div4) ---
        let divCiudad = document.createElement("div");
        div4.append(divCiudad);
        let labelCiudad = document.createElement("label");
        labelCiudad.textContent = "Ciudad:";
        labelCiudad.htmlFor = "inputCiudad";
        divCiudad.append(labelCiudad);
        let inputCiudad = document.createElement("input");
        inputCiudad.type = "text";
        inputCiudad.name = "ciudad";
        inputCiudad.id = "inputCiudad";
        inputCiudad.classList.add("inputsDatosAlumno");
        inputCiudad.value = datos["ciudad"];
        div4.append(inputCiudad);

        let divDireccion = document.createElement("div");
        div4.append(divDireccion);
        let labelDireccion = document.createElement("label");
        labelDireccion.textContent = "Dirección:";
        labelDireccion.htmlFor = "inputDireccion";
        divDireccion.append(labelDireccion);
        let inputDireccion = document.createElement("input");
        inputDireccion.type = "text";
        inputDireccion.name = "direccion";
        inputDireccion.id = "inputDireccion";
        inputDireccion.classList.add("inputsDatosAlumno");
        inputDireccion.value = datos["direccion"];
        div4.append(inputDireccion);

        // --- Campos Codigo Postal y CV (van a div5) ---
        let divCodigoPostal = document.createElement("div");
        div5.append(divCodigoPostal);
        let labelCodigoPostal = document.createElement("label");
        labelCodigoPostal.textContent = "Código Postal:";
        labelCodigoPostal.htmlFor = "inputCodigoPostal";
        divCodigoPostal.append(labelCodigoPostal);
        let inputCodigoPostal = document.createElement("input");
        inputCodigoPostal.type = "number";
        inputCodigoPostal.name = "codigo_postal";
        inputCodigoPostal.id = "inputCodigoPostal";
        inputCodigoPostal.classList.add("inputsDatosAlumno");
        inputCodigoPostal.value = datos["codigo_postal"];
        div5.append(inputCodigoPostal);

        let divCv = document.createElement("div");
        div5.append(divCv);
        let labelCv = document.createElement("label");
        labelCv.textContent = "CV (Archivo):";
        labelCv.htmlFor = "inputCv";
        divCv.append(labelCv);
        let inputCv = document.createElement("input");
        inputCv.type = "file";
        inputCv.name = "cv";
        inputCv.id = "inputCv";
        inputCv.classList.add("inputsDatosAlumno");
        if(datos["tieneCV"])
        {
            let btnVerCV = document.createElement("button");
            btnVerCV.classList.add("botonesDatosAlumno");
            btnVerCV.innerHTML = "Ver CV";
            btnVerCV.name = "btnVerCV";
            divCv.append(btnVerCV);

            btnVerCV.onclick = function(e)
            {
                e.preventDefault();
                encenderTrasfondo();
                encenderModalCV();
                cargarPDFEnModal();

            }
        }
        div5.append(inputCv);

        

        // --- Campos Foto y Ciclo ID (van a div6) ---
        let divFoto = document.createElement("div");
        div6.append(divFoto);
        let labelFoto = document.createElement("label");
        labelFoto.textContent = "Foto (Archivo):";
        labelFoto.htmlFor = "inputFoto";
        divFoto.append(labelFoto);
        let inputFoto = document.createElement("input");
        inputFoto.type = "file";
        inputFoto.name = "foto";
        inputFoto.id = "inputFoto";
        inputFoto.classList.add("inputsDatosAlumno");
        if(datos["tieneFoto"])
        {
            let btnVerFoto = document.createElement("button");
            btnVerFoto.classList.add("botonesDatosAlumno");
            btnVerFoto.innerHTML = "Ver Foto";
            btnVerFoto.name = "btnVerFoto";
            divFoto.append(btnVerFoto);

            btnVerFoto.onclick = function(e)
            {
                e.preventDefault();
                encenderTrasfondo();
                encenderModalFoto();
                obtenerYMostrarFotoBlob();
                
            }
        }
        div6.append(inputFoto);

        let divVerCiclos = document.createElement("div");
        let btnVerCiclos = document.createElement("button");
        btnVerCiclos.innerHTML = "Ver Ciclos";
        btnVerCiclos.name="btnVerCiclos";
        btnVerCiclos.classList.add("botonesDatosAlumno");
        divVerCiclos.append(btnVerCiclos);
        form.append(divVerCiclos);

        btnVerCiclos.onclick = function(e)
        {

            e.preventDefault();
            encenderModalCiclos();
            
        }

        

        


        let btnGenerarPDF = document.createElement("button");
        btnGenerarPDF.classList.add("botonesDatosAlumno");
        btnGenerarPDF.name ="btnGenerarPDF";
        btnGenerarPDF.innerHTML = "Generar PDF";
        form.append(btnGenerarPDF)


        const apiURL = "http://localhost:8080/generar_pdf.php"

        btnGenerarPDF.onclick = function(e)
        {
            e.preventDefault();
            window.open(apiURL, '_blank');
        }



        let submitForm = document.createElement("input");
        submitForm.type = "submit";
        submitForm.name = "submitForm";
        submitForm.value = "Actualizar Datos";

        
        submitForm.classList.add("botonesDatosAlumno");
        form.append(submitForm);
        submitForm.onclick = function(e)
        {
            e.preventDefault();


            const formDataActualizar = new FormData();
            formDataActualizar.append("nombre", inputNombre.value);
            formDataActualizar.append("apellidos", inputApellidos.value);
            formDataActualizar.append("telefono", inputTelefono.value);
            formDataActualizar.append("fecha_nacimiento", inputFechaNacimiento.value);
            formDataActualizar.append("pais", inputPais.value);
            formDataActualizar.append("provincia", inputProvincia.value);
            formDataActualizar.append("ciudad", inputCiudad.value);
            formDataActualizar.append("direccion", inputDireccion.value);
            formDataActualizar.append("codigo_postal", inputCodigoPostal.value);

            if (inputCv.files && inputCv.files.length > 0) {
                formDataActualizar.append("cv", inputCv.files[0]);
            }

            if (inputFoto.files && inputFoto.files.length > 0) {
                formDataActualizar.append("foto", inputFoto.files[0]);
            }


            fetch("/api/alumno/datosController.php?updateAlumno", {
                method: "POST",
                body: formDataActualizar
            })
            .then(response => response.json())
            .then(data => {
                if(data.success)
                {
                    alert("Datos Actualizados.");
                }
                else
                {
                    alert(data.error || "Error al conectar con la base de datos")
                }
            })
        }

    }



// ---Modal ---
    // --- Trasfondo ---
    let body = document.body;

    let trasfondoModal = document.createElement("div");
    trasfondoModal.classList.add("trasfondoModal");
    trasfondoModal.classList.add("hideModal");
    body.append(trasfondoModal);

    trasfondoModal.addEventListener("click", function(e)
    {
        if(e.target === trasfondoModal)
        {
            apagarModales();
        }
    });


    // Modal Foto
    let modalFotoContainer = document.createElement("div");
    body.append(modalFotoContainer);
    modalFotoContainer.classList.add("modal");
    modalFotoContainer.classList.add("hideModal");

    let modalFoto = document.createElement("div");
    modalFoto.classList.add("modal-content");
    modalFotoContainer.append(modalFoto);

    let modalHeader = document.createElement("div");
    modalHeader.classList.add("modal-header");
    modalFoto.append(modalHeader);
    let tituloModalFoto = document.createElement("h3");
    tituloModalFoto.innerHTML= "Foto Actual";
    modalHeader.append(tituloModalFoto);

    let modalBody = document.createElement("div");
    modalBody.classList.add("modal-body");
    modalBody.classList.add("modal-body-centrado");
    modalFoto.append(modalBody);

    let containerFoto = document.createElement("div");
    containerFoto.style.textAlign = 'center';
    modalBody.append(containerFoto);
    let imgElement = document.createElement("img");
    containerFoto.append(imgElement);

    let modalFooter = document.createElement("div");
    modalFooter.classList.add("modal-footer");
    modalFoto.append(modalFooter);
    let btnCerrarModalFoto = document.createElement("button");
    btnCerrarModalFoto.innerHTML= "Cerrar";
    modalFooter.append(btnCerrarModalFoto);

    btnCerrarModalFoto.onclick = function(e)
    {
        e.preventDefault();
        apagarModales();
    }


    // Modal CV
    let modalCVContainer = document.createElement("div");
    body.append(modalCVContainer);
    modalCVContainer.classList.add("modal");
    modalCVContainer.classList.add("hideModal");

    let modalCV = document.createElement("div");
    modalCV.classList.add("modal-content");
    modalCVContainer.append(modalCV);

    let modalHeaderCV = document.createElement("div");
    modalHeaderCV.classList.add("modal-header");
    modalCV.append(modalHeaderCV);
    let tituloModalCV = document.createElement("h3");
    tituloModalCV.innerHTML= "CV";
    modalHeaderCV.append(tituloModalCV);

    let modalBodyCV = document.createElement("div");
    modalBodyCV.classList.add("modal-body");
    modalBodyCV.classList.add("modal-body-centrado");
    modalCV.append(modalBodyCV)

    let containerCV = document.createElement("div");
    containerCV.style.textAlign = 'center';
    modalBodyCV.append(containerCV);
    let iframeElement = document.createElement("iframe");
    iframeElement.id = "iframe";
    iframeElement.style.width = "100%";
    iframeElement.style.height = "500px";
    containerCV.append(iframeElement);

    let modalFooterCV = document.createElement("div");
    modalFooterCV.classList.add("modal-footer");
    modalCV.append(modalFooterCV);
    let btnCerrarModalCV = document.createElement("button");
    btnCerrarModalCV.innerHTML= "Cerrar";
    modalFooterCV.append(btnCerrarModalCV);

    btnCerrarModalCV.onclick = function(e)
    {
        e.preventDefault();
        apagarModales();
    }



    // Modal Ciclos
    let modalCiclosContainer = document.createElement("div");
    body.append(modalCiclosContainer);
    modalCiclosContainer.classList.add("modal");
    modalCiclosContainer.classList.add("hideModal");

    let modalCiclos = document.createElement("div");
    modalCiclos.classList.add("modal-content");
    modalCiclosContainer.append(modalCiclos);

    let modalHeaderCiclos = document.createElement("div");
    modalHeaderCiclos.classList.add("modal-header");
    modalCiclos.append(modalHeaderCiclos);
    let tituloModalCiclos = document.createElement("h3");
    tituloModalCiclos.innerHTML= "Ciclos";
    modalHeaderCiclos.append(tituloModalCiclos);

    let modalBodyCiclos = document.createElement("div");
    modalBodyCiclos.classList.add("modal-body");
    modalBodyCiclos.classList.add("modal-body-centrado");
    modalCiclos.append(modalBodyCiclos)

    let containerCiclos = document.createElement("div");
    containerCiclos.style.textAlign = 'center';
    modalBodyCiclos.append(containerCiclos);

    let modalFooterCiclos = document.createElement("div");
    modalFooterCiclos.classList.add("modal-footer");
    modalCiclos.append(modalFooterCiclos);
    let btnCerrarModalCiclos = document.createElement("button");
    btnCerrarModalCiclos.innerHTML= "Cerrar";
    modalFooterCiclos.append(btnCerrarModalCiclos);

    btnCerrarModalCiclos.onclick = function(e)
    {
        e.preventDefault();
        apagarModales();
    }


    let formCiclos = document.createElement("form");
    modalBodyCiclos.append(formCiclos);

    let ciclosModal_containerAddCiclos = document.createElement("div");
    formCiclos.append(ciclosModal_containerAddCiclos);
    let ciclosModal_containerh3 = document.createElement("div");
    ciclosModal_containerAddCiclos.append(ciclosModal_containerh3);
    let ciclosModal_h3 = document.createElement("h3");
    ciclosModal_h3.innerHTML = "Añadir Ciclo";
    ciclosModal_containerh3.append(ciclosModal_h3);


    let inputAddCiclos_select = document.createElement("select");
    inputAddCiclos_select.name ="selectCiclos";
    inputAddCiclos_select.classList.add("inputsDatosAlumno");
    let label_inputSelect = document.createElement("label");
    label_inputSelect.htmlFor = "selectCiclos";
    label_inputSelect.innerHTML = "Selecciona un ciclo: ";
    ciclosModal_containerAddCiclos.append(label_inputSelect);
    ciclosModal_containerAddCiclos.append(inputAddCiclos_select);
    let optDefault = document.createElement("option");
    optDefault.value = "" ;
    optDefault.innerHTML ="- Ciclos -";
    optDefault.disabled = true;
    optDefault.defaultSelected = true;
    inputAddCiclos_select.append(optDefault);
    opcionesCiclos()
    let divContainerFechas = document.createElement("div");
    ciclosModal_containerAddCiclos.append(divContainerFechas);

    let fechaInicio = document.createElement("input");
    fechaInicio.type="date";
    fechaInicio.classList.add("inputsDatosAlumno");
    fechaInicio.name = "fechaInicio";
    let labelFechaIni = document.createElement("label");
    labelFechaIni.htmlFor="fechaInicio";
    labelFechaIni.innerHTML=" Fecha de Inicio:";
    divContainerFechas.append(labelFechaIni);
    divContainerFechas.append(fechaInicio);
    
    let fechaFin = document.createElement("input");
    fechaFin.type = "date";
    fechaFin.classList.add("inputsDatosAlumno");
    fechaFin.name = "fechaFin";
    let labelFechaFin = document.createElement("label");
    labelFechaFin.htmlFor = "fechaFin";
    labelFechaFin.innerHTML = " Fecha de Fin:"; 
    divContainerFechas.append(labelFechaFin);
    divContainerFechas.append(fechaFin);

    let btnAddCiclo = document.createElement("button");
    btnAddCiclo.classList.add("botonesDatosAlumno");
    btnAddCiclo.innerHTML="Añadir Ciclo";
    divContainerFechas.append(btnAddCiclo);

    const selectElement = inputAddCiclos_select;
    const nombreCiclo = selectElement.options[selectElement.selectedIndex].text;
    console.log(nombreCiclo);


    btnAddCiclo.onclick = function(e)
{
    e.preventDefault();

    // Obtener el nombre del ciclo seleccionado
    const selectElement = inputAddCiclos_select;
    
    // Validar que se haya seleccionado un ciclo válido
    if(!selectElement.value || selectElement.value === "") {
        alert("Por favor, selecciona un ciclo válido");
        return;
    }
    
    const nombreCiclo = selectElement.options[selectElement.selectedIndex].text;

    const formData = new FormData(formCiclos);
    
    // Agregar el nombre del ciclo al FormData
    formData.append("nombreCiclo", nombreCiclo);

    fetch("/api/alumno/datosController.php",{
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data =>{
        if(data.success)
        {
            alert("Ciclo Añadido");
            formCiclos.reset(); // Limpiar el formulario
            mostrarCiclosAlumno(); // Recargar la lista de ciclos
        }
        else
        {
            alert(data.error || "Error conectando con el nuevo ciclo");
        }
    })
}


    let segundoh3= document.createElement("h3");
    segundoh3.innerHTML="Mis Ciclos"
    ciclosModal_containerAddCiclos.append(segundoh3)
    let containerCiclosAlumno = document.createElement("div");
    ciclosModal_containerAddCiclos.append(containerCiclosAlumno);
    mostrarCiclosAlumno()






    function encenderTrasfondo()
    {
        trasfondoModal.classList.remove("hideModal");
        trasfondoModal.classList.add("showModal");
    }

    function encenderModalFoto()
    {
        modalFotoContainer.classList.remove("hideModal");
        modalFotoContainer.classList.add("showModal");
    }

    function encenderModalCV()
    {
        modalCVContainer.classList.remove("hideModal");
        modalCVContainer.classList.add("showModal");
    }

    function encenderModalCiclos()
    {
        modalCiclosContainer.classList.remove("hideModal");
        modalCiclosContainer.classList.add("showModal");
    }

    function apagarModales()
    {
        trasfondoModal.classList.add("hideModal");
        trasfondoModal.classList.remove("showModal");

        modalFotoContainer.classList.remove("showModal");
        modalFotoContainer.classList.add("hideModal");

        modalCVContainer.classList.remove("showModal");
        modalCVContainer.classList.add("hideModal");

        modalCiclosContainer.classList.remove("showModal");
        modalCiclosContainer.classList.add("hideModal");
    }












    async function obtenerYMostrarFotoBlob() {
    const urlEndpointPHP = "/api/alumno/datosController.php?obtainImgBLOB";
    

    try {
        const response = await fetch(urlEndpointPHP);


        if (response.ok && response.status === 200 && response.headers.get('content-length') !== '0') {
            

            const imageBlob = await response.blob();
            

            if (imageBlob.size > 0) {
                const imageUrl = URL.createObjectURL(imageBlob);
                
                imgElement.src = imageUrl;

            }

        } else {

            containerFoto.innerHTML = "Sin foto";
        }
        

    } catch (error) {

        console.error("Error al cargar la foto:", error);
    }

}



    async function obtenerPDFBlob(urlPDF) {
            try {
                const response = await fetch(urlPDF);

                if (!response.ok) {

                    if (response.status === 404 || response.headers.get('content-length') === '0') {
                        return null; 
                    }
                    throw new Error(`Error al obtener el PDF: ${response.status}`);
                }

                return await response.blob(); 

            } catch (error) {
                console.error("Error al obtener el PDF:", error);
                return null;
            }
        }

    async function cargarPDFEnModal() {
        const pdfBLOB = await obtenerPDFBlob("/api/alumno/datosController.php?obtainCVBLOB");

        containerCV.innerHTML = '';
        iframeElement.style.display = 'none';
        iframeElement.src = '';
        containerCV.append(iframeElement);
        
        if (pdfBLOB && pdfBLOB.size > 0) {
            const pdfURL = URL.createObjectURL(pdfBLOB);

            iframeElement.src = pdfURL; 
            iframeElement.style.display = 'block'; // Hacer visible SOLO si hay CV
        } else {
            containerCV.innerHTML = "Sin CV";
        }
    }




    function opcionesCiclos()
    {
        fetch("/api/ciclos.php")
        .then(response => response.json())
        .then(data => {
            data.data.forEach(ciclo => {
                let selectOpt = document.createElement("option");
                selectOpt.value = ciclo["id"];
                selectOpt.innerHTML = ciclo["nombre"];
                console.log(ciclo["nombre"])
                inputAddCiclos_select.append(selectOpt);
            });
        })
    }


    function mostrarCiclosAlumno()
    {
        containerCiclosAlumno.innerHTML = "";

        fetch("/api/alumno/datosController.php?getCiclosAlumno")
        .then(response => response.json())
        .then(data => {
                if(data.success)
                {
                    data.ciclos.forEach(ciclo => {
                        console.log(ciclo);
                        let divCiclo = document.createElement("div")
                        containerCiclosAlumno.append(divCiclo);
                        let inputNombre = document.createElement("input");
                        inputNombre.classList.add("inputsDatosAlumno");
                        inputNombre.type = "text";
                        inputNombre.readOnly = true;
                        inputNombre.name = "nombreCiclo";
                        inputNombre.value = ciclo["nombre_ciclo"];
                        containerCiclosAlumno.append(inputNombre);

                        let inputFechaIni = document.createElement("input");
                        inputFechaIni.classList.add("inputsDatosAlumno");
                        inputFechaIni.type = "date";
                        inputFechaIni.readOnly = true;
                        inputFechaIni.name = "fechaIniCiclo";
                        inputFechaIni.value = ciclo["fecha_inicio"];
                        containerCiclosAlumno.append(inputFechaIni);

                        let inputFechaFin = document.createElement("input");
                        inputFechaFin.classList.add("inputsDatosAlumno");
                        inputFechaFin.type = "date";
                        inputFechaFin.readOnly = true;
                        inputFechaFin.name ="FechaFin";
                        inputFechaFin.value = ciclo["fecha_fin"];
                        containerCiclosAlumno.append(inputFechaFin);

                        let btnBorrarCiclo = document.createElement("button");
                        btnBorrarCiclo.innerHTML = "Borrar";
                        btnBorrarCiclo.classList.add("botonesDatosAlumno");
                        containerCiclosAlumno.append(btnBorrarCiclo);

                        btnBorrarCiclo.onclick = function(e) {
                            e.preventDefault();
                            console.log(ciclo);
                            borrarCiclo(ciclo)
                        }

                    });
                }
                else
                {
                    alert(data.error || "No se ha podido conectar con los ciclos del alumno");
                }
        })
    }


    // TO-DO: FUNCIONALIDAD AÑADIR CICLO, FUNCIONALIDAD BORRAR CICLO, FUNCIONALIDAD GENERAR PDF, FUNCIONALIDAD ACTUALIZAR DATOS


    function borrarCiclo(ciclo)
    {
        fetch("/api/alumno/datosController.php", {
            method: "DELETE",
            headers: {
                "Content-Type":"application/json"
            },
            body: JSON.stringify(ciclo["ciclo_id"])
        })
        .then(response => response.json())
        .then(data => {
            if(data.success)
            {
                alert("Ciclo Borrado");
            }
            else
            {
                alert(data.error || "Error accediendo al ciclo que borrar");
            }
        })
        
    }

    function mostrarMenuIzq()
    {
        let opts = document.querySelectorAll(".optLateral");

        opts[0].innerHTML = "Panel de Datos";
        opts[1].innerHTML = "Panel de Ofertas";

        opts[0].addEventListener("click", function(){
            window.location.href ='index.php?page=dashboard-alumno-datos'
        })
        opts[1].addEventListener("click", function(){
            window.location.href ='index.php?page=dashboard-alumno-ofertas'
        })
    }

})