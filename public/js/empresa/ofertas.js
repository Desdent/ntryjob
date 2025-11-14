document.addEventListener("DOMContentLoaded", function(){
    const contenedor = document.getElementById('tablaOfertas');
        
    let head = document.createElement("thead");
    contenedor.append(head);

    let cabecera = document.createElement("tr");
    head.append(cabecera);

    let headerTitulo = document.createElement("th");
    headerTitulo.innerHTML = "Título";
    cabecera.append(headerTitulo);
    let huecoSortTitulo = document.createElement("span");
    huecoSortTitulo.textContent = "  ◀"; 
    headerTitulo.append(huecoSortTitulo);

    let headerCiclo = document.createElement("th");
    headerCiclo.innerHTML = "Ciclo";
    cabecera.append(headerCiclo);
    let huecoSortCiclo = document.createElement("span");
    huecoSortCiclo.textContent = "  ◀"; 
    headerCiclo.append(huecoSortCiclo);

    let headerFechaInicio = document.createElement("th");
    headerFechaInicio.innerHTML = "Fecha de Inicio";
    cabecera.append(headerFechaInicio);
    let huecoSortFechaInicio = document.createElement("span");
    huecoSortFechaInicio.textContent = "  ◀";
    headerFechaInicio.append(huecoSortFechaInicio);

    let headerFechaFin = document.createElement("th");
    headerFechaFin.innerHTML = "Fecha de Fin";
    cabecera.append(headerFechaFin);
    let huecoSortFechaFin = document.createElement("span");
    huecoSortFechaFin.textContent = "  ◀";
    headerFechaFin.append(huecoSortFechaFin);

    let headerActions = document.createElement("th");
    headerActions.innerHTML = "Acciones";
    cabecera.append(headerActions);

    let cuerpo = document.createElement("tbody");
    contenedor.append(cuerpo)
    rellenarTabla();


    function vaciarContenidoCeldas() {
        cuerpo.innerHTML = "";
    }


    async function obtenerCiclo(idCiclo) {
        let idCicloURI = encodeURIComponent(idCiclo);

        try {
            const response = await fetch(`/api/empresario/ofertas.php?ciclo=${idCicloURI}`);
            const data = await response.json();
            console.log(data);
            
            if(data.success) {
                return data.ciclo;
            } else {
                alert(data.error || "No se ha podido conectar con los ciclos");
                return null;
            }
        } catch(error) {
            // CAMBIO 3: Manejo de errores de red
            console.error("Error al obtener ciclo:", error);
            return null;
        }
    }

    
    async function rellenarTabla() {
        vaciarContenidoCeldas();

        try {
            // Parece que la mejor forma de usar await con fetches es asi
            const response = await fetch("/api/empresario/ofertas.php");
            const data = await response.json();
            
            if(data.success) {
                // CAMBIO 6: for...of en lugar de forEach para poder usar await
                for(const oferta of data.data) {
                    let fila = document.createElement("tr");
                    cuerpo.append(fila);
                    
                    let celdaTitulo = document.createElement("td");
                    celdaTitulo.innerHTML = oferta.titulo;
                    fila.append(celdaTitulo);

                    let celdaCiclo = document.createElement("td");
                    // CAMBIO 7: Ahora await funciona correctamente dentro del bucle
                    let ciclo = await obtenerCiclo(oferta.ciclo_id);
                    celdaCiclo.innerHTML = ciclo || "N/A"; // Mostrar "N/A" si es null
                    fila.append(celdaCiclo);

                    let celdaFechaInicio = document.createElement("td");
                    celdaFechaInicio.innerHTML = oferta.fecha_inicio;
                    fila.append(celdaFechaInicio);

                    let celdaFechaFin = document.createElement("td");
                    celdaFechaFin.innerHTML = oferta.fecha_cierre;
                    fila.append(celdaFechaFin);

                    let celdaAcciones = document.createElement("td");
                    let btnEditar = document.createElement("button");
                    btnEditar.innerHTML = "Editar";
                    celdaAcciones.append(btnEditar);
                    let btnBorrar = document.createElement("button");
                    btnBorrar.innerHTML = "Borrar";
                    celdaAcciones.append(btnBorrar);
                    let btnVerOferta = document.createElement("button");
                    btnVerOferta.innerHTML = "Ver Oferta";
                    celdaAcciones.append(btnVerOferta);
                    let btnVerPostulantes = document.createElement("button");
                    btnVerPostulantes.innerHTML = "Ver Postulantes";
                    celdaAcciones.append(btnVerPostulantes);
                    fila.append(celdaAcciones);
                }
            } else {
                alert(data.error || "No ha sido posible establecer conexión");
            }
        } catch(error) {
            // CAMBIO 8: Manejo de errores de red
            console.error("Error al rellenar tabla:", error);
            alert("Error al cargar las ofertas. Por favor, inténtalo de nuevo.");
        }
    }

});