document.addEventListener("DOMContentLoaded", function(){

    let containerPostulantes = document.getElementById("containerPostulantes");

    let input_id_oferta = document.getElementById("input_id_oferta");
    let input_id_user = document.getElementById("input_id_user");
    let oferta_id = input_id_oferta.value;
    console.log(oferta_id);
    let user_id = input_id_user.value;
    let datosEnvio = {
        "ofertaId": oferta_id,
        "userId": user_id
    };

    let divContainerPostulantes = document.createElement("div")
    divContainerPostulantes.id="ofertas-container";
    containerPostulantes.append(divContainerPostulantes);
    let contador = 0;

    mostrarPostulantes(datosEnvio);







    function mostrarPostulantes(datosEnvio)
    {
        fetch("/api/empresa/postulaciones.php",{
            method: "POST",
            headers: {
                "Content-Type":"application/json"
            },
            body: JSON.stringify(datosEnvio)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success)
            {
                let containerPostulante
                console.log(data.postulaciones);
                data.postulaciones.forEach(postulante => {
                    console.log(postulante);
                    if(contador == 0)
                    {
                        containerPostulante = document.createElement("div");
                        containerPostulante.classList.add("containerOfertas");
                        divContainerPostulantes.append(containerPostulante);
                    }
                    console.log(postulante);
                    let cardPostulante = document.createElement("div");
                    containerPostulante.append(cardPostulante);
                    cardPostulante.classList.add("oferta-card");
                    let containerNombre = document.createElement("div");
                    containerNombre.classList.add("containerNombreEmpresaOferta");
                    cardPostulante.append(containerNombre);
                    let h4Nombre = document.createElement("h4");
                    h4Nombre.classList.add("nombreEmpresaOferta");
                    h4Nombre.innerHTML = postulante.alumno_nombre + " " + postulante.alumno_apellidos;
                    containerNombre.append(h4Nombre);

                    let containerCiudad = document.createElement("div");
                    containerCiudad.classList.add("containerCiudadOferta"); 
                    cardPostulante.append(containerCiudad);

                    let h4Ciudad = document.createElement("p");
                    h4Ciudad.style.color = "white";
                    h4Ciudad.classList.add("ciudadPostulante"); 
                    h4Ciudad.innerHTML = postulante.alumno_ciudad; 
                    containerCiudad.append(h4Ciudad);


                    let containerFecha = document.createElement("div");
                    containerFecha.classList.add("containerFechaPostulacion"); 
                    cardPostulante.append(containerFecha);

                    let h4Fecha = document.createElement("p");
                    h4Fecha.style.color="white";
                    h4Fecha.classList.add("fechaPostulacion");
                    h4Fecha.innerHTML = postulante.fecha_postulacion; 
                    containerFecha.append(h4Fecha);

                    let divContainerBotones = document.createElement("div");
                    cardPostulante.append(divContainerBotones);
                    let btnAceptar = document.createElement("button");
                    btnAceptar.innerHTML="Aceptar";
                    divContainerBotones.append(btnAceptar);

                    btnAceptar.addEventListener("click", function(){
                        accionesPostulante(postulante);
                        this.style.backgroundColor = "#075588";
                        this.style.color = "white";
                        this.innerHTML = "Aceptada";
                        this.style.boxShadow  ="none";

                        btnRechazar.style.display ="none";
                        btnVerFicha.style.display ="none";
                    })


                    let btnRechazar = document.createElement("button");
                    btnRechazar.innerHTML="Rechazar";
                    divContainerBotones.append(btnRechazar);

                    btnRechazar.addEventListener("click", function(){
                        accionesPostulante(postulante);
                        this.style.backgroundColor = "#075588";
                        this.style.color = "white";
                        this.innerHTML = "Rechazada";
                        this.style.boxShadow  ="none";

                        btnAceptar.style.display ="none";
                        btnVerFicha.style.display ="none";
                    })
                    let btnVerFicha = document.createElement("button");
                    btnVerFicha.innerHTML="Ver Ficha";
                    divContainerBotones.append(btnVerFicha);


                    contador++;
                    if(contador == 2)
                    {
                        contador = 0;
                    }
                });
            }
            else
            {
                alert(data.error || "Error al conectar con las postulaciones de esta oferta");
            }
        })
    }


    function accionesPostulante(postulante)
    {
        const postulacionId = postulante.id;

        fetch(`/api/empresa/postulaciones.php?id=${postulacionId}`, {
            method: "DELETE",
            headers: {
                "Content-Type":"application/json"
            },
            body: JSON.stringify(postulante.oferta_id)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                alert("Acción realizada")
            }
            else
            {
                alert(error || "Error al conectar con las postulaciones");
            }
        })

        
    }


})