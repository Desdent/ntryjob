document.addEventListener("DOMContentLoaded", function(){


    let dashboardContainer = document.querySelector(".dashboard-container");

    let divContainerCentral = document.createElement("div");
    divContainerCentral.classList.add("divCentral");
    // Se añade al container general el container principal
    dashboardContainer.append(divContainerCentral);

    let divMenuIzq = document.createElement("div");
    divMenuIzq.id= "menu-izq";
    // Se añade al container principal el div del menu izq
    divContainerCentral.append(divMenuIzq);
    let h3MenuIzq = document.createElement("h3");
    h3MenuIzq.innerHTML = "Panel de Navegación";
    // Se añade al div del menu izq el titulo
    divMenuIzq.append(h3MenuIzq)
    let divOptLateral1 = document.createElement("div");
    divOptLateral1.classList.add("optLateral");
    let divOptLateral2 = document.createElement("div");
    divOptLateral2.classList.add("optLateral");
    let divOptLateral3 = document.createElement("div");
    divOptLateral3.classList.add("optLateral");
    // Se añaden al div del menu izq los divs de las opciones de navegación
    divMenuIzq.append(divOptLateral1);
    divMenuIzq.append(divOptLateral2);
    divMenuIzq.append(divOptLateral3);


    let divTableContainer = document.createElement("div");
    divTableContainer.classList.add("table-container");
    // Se añade al container principal el div que llevara la tabla
    divContainerCentral.append(divTableContainer);

    let divHeaderTable = document.createElement("div");
    divHeaderTable.classList.add("headerTableContainer");
    //se añade al div que llevara la tabla, el contenedor que llevara las opciones y titulo
    divTableContainer.append(divHeaderTable);
    let divH2 = document.createElement("div");
    divH2.id = "divh2";
    // Se añade al contenedor de las opciones y titulos el contenedor del h2
    divHeaderTable.append(divH2);
    h2Listado = document.createElement("h2");
    h2Listado.innerHTML = "Listado de Ofertas";
    divH2.append(h2Listado);


    let divContainerSearchOfertas = document.createElement("div");
    divContainerSearchOfertas.id = "containerSearchOfertas";
    // Se añade al tableContainer el div del search
    divTableContainer.append(divContainerSearchOfertas);
    divInputSearch = document.createElement("div");
    divInputSearch.id = "input-searchOfertas";
    //Se añade el contenedor del input al contenedor superior
    divContainerSearchOfertas.append(divInputSearch);
    let inputSearch = document.createElement("input");
    inputSearch.type = "text";
    inputSearch.id = "search-ofertas";
    divInputSearch.append(inputSearch);



    let tablaOfertas = document.createElement("table");
    tablaOfertas.id = "tablaOfertas";
    // Se añade al tableContainer la tabla
    divTableContainer.append(tablaOfertas);
    
    crearTabla(tablaOfertas);
    rellenarTabla(tablaOfertas);






    function crearTabla(tablaOfertas){
        
        let thead = document.createElement("thead");
        tablaOfertas.append(thead);

        let filaHead = document.createElement("tr");
        thead.append(filaHead);

        let th1 = document.createElement("th");
        th1.innerHTML = "Empresa ◀";
        filaHead.append(th1);
        let th2 = document.createElement("th");
        th2.innerHTML = "Título ◀";
        filaHead.append(th2);
        let th3 = document.createElement("th");
        th3.innerHTML = "Sector ◀";
        filaHead.append(th3);
        let th4 = document.createElement("th");
        th4.innerHTML = "Ciclo ◀";
        filaHead.append(th4);
        let th5 = document.createElement("th");
        th5.innerHTML = "Fecha Inicio ◀";
        filaHead.append(th5);
        let th6 = document.createElement("th");
        th6.innerHTML = "Fecha Fin ◀";
        filaHead.append(th6);
        let th7 = document.createElement("th");
        th7.innerHTML = "Acciones";
        filaHead.append(th7);

    }


    function rellenarTabla(tablaOfertas)
    {
        let tabla = document.querySelector("table")
        let thead = tabla.querySelector("thead");
        let celdasPorFila = thead.rows[0].cells.length;

        let cuerpo = document.createElement("tbody");
        tablaOfertas.append(cuerpo);

        fetch("/api/admin/OfertasController.php")
        .then(response => response.json())
        .then(data => {
            if(data.success)
            {
                data.data.forEach(oferta => {
                    let fila = document.createElement("tr");
                    cuerpo.append(fila);

                    
                    for(const clave in oferta)
                    {
                        if(oferta.hasOwnProperty(clave))
                        {
                            console.log(celdasPorFila);
                            for(let i = 0; i < celdasPorFila -1; i++)
                            {
                                let valorCabecera = tablaOfertas.rows[0].cells[i];
                                console.log(oferta[clave])
                                if(clave == valorCabecera)
                                {
                                    let celda = oferta[clave]("td");
                                    celda.innerHTML = campo.value;
                                    fila.append(celda);
                                }
                            }
                        }
                    }

                    let celda = document.createElement("td");
                    fila.append(celda);
                    let botonBorrarOferta = document.createElement("button");
                    botonBorrarOferta.innerHTML = "Borrar";
                    celda.append(botonBorrarOferta);
                    let botonVerOferta = document.createElement("button");
                    botonVerOferta.innerHTML = "Ver";
                    celda.append(botonVerOferta);
                });
            }
        })
    }



    function borrarOferta(id) {
        fetch("/api/admin/ofertas.php", {
            method: "DELETE",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success == true){
                alert("Oferta borrada.");
            }
            else
            {
                alert(data.error || "No ha sido posible borrar la oferta.")
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
        window.location.href ='index.php?page=dashboard-admin-empresas'
    })
    opts[2].addEventListener("click", function(){
        window.location.href ='index.php?page=dashboard-admin-ofertas'
    })

})

