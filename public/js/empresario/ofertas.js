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
            console.log(data.postulantes);
            if(data.success)
            {
                let containerPostulante

                data.postulantes.forEach(postulante => {
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
                    h4Nombre.innerHTML = postulante.nombre;
                    containerNombre.append(h4Nombre);

                    let divContainerBotones = document.createElement("div");
                    cardPostulante.append(divContainerBotones);
                    let btnAceptar = document.createElement("button");
                    btnAceptar.innerHTML="Aceptar";
                    divContainerBotones.append(btnAceptar);
                    let btnRechazar = document.createElement("button");
                    btnRechazar.innerHTML="Rechazar";
                    divContainerBotones.append(btnRechazar);


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



})