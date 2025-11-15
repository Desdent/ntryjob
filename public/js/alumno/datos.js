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
            console.log(data.datos);
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
            
        }

        // let divCicloId = document.createElement("div");
        // div6.append(divCicloId);
        // let labelCicloId = document.createElement("label");
        // labelCicloId.textContent = "ID del Ciclo:";
        // labelCicloId.htmlFor = "inputCicloId";
        // divCicloId.append(labelCicloId);
        // let inputCicloId = document.createElement("input");
        // inputCicloId.type = "number";
        // inputCicloId.name = "ciclo_id";
        // inputCicloId.id = "inputCicloId";
        // inputCicloId.classList.add("inputsDatosAlumno");
        // inputCicloId.value= datos["ciclo_id"];
        // div6.append(inputCicloId);

        // // --- Campos Fecha Inicio y Fecha Fin (van a div7) ---
        // let divFechaInicio = document.createElement("div");
        // div7.append(divFechaInicio);
        // let labelFechaInicio = document.createElement("label");
        // labelFechaInicio.textContent = "Fecha de Inicio:";
        // labelFechaInicio.htmlFor = "inputFechaInicio";
        // divFechaInicio.append(labelFechaInicio);
        // let inputFechaInicio = document.createElement("input");
        // inputFechaInicio.type = "date";
        // inputFechaInicio.name = "fecha_inicio";
        // inputFechaInicio.id = "inputFechaInicio";
        // inputFechaInicio.classList.add("inputsDatosAlumno");
        
        // div7.append(inputFechaInicio);

        // let divFechaFin = document.createElement("div");
        // div7.append(divFechaFin);
        // let labelFechaFin = document.createElement("label");
        // labelFechaFin.textContent = "Fecha de Fin:";
        // labelFechaFin.htmlFor = "inputFechaFin";
        // divFechaFin.append(labelFechaFin);
        // let inputFechaFin = document.createElement("input");
        // inputFechaFin.type = "date";
        // inputFechaFin.name = "fecha_fin";
        // inputFechaFin.id = "inputFechaFin";
        // inputFechaFin.classList.add("inputsDatosAlumno");
        // div7.append(inputFechaFin);

        

        



        let submitForm = document.createElement("input");
        submitForm.type = "submit";
        submitForm.name = "submitForm";
        submitForm.value = "Actualizar Datos";
        submitForm.classList.add("botonesDatosAlumno");
        form.append(submitForm);

        submitForm.onclick = function(e)
        {
            e.preventDefault();
        }

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