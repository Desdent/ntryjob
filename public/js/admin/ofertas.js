document.addEventListener("DOMContentLoaded", function(){


//     cargarOfertas();

//     /**
//      * Listar ofertas
//      * YA FUNCA PERO HAY QUE CAMBIARLO PORQUE ASI SOLO MUESTRA UNA OFERTA
//      */
//     async function cargarOfertas() {
//     try {
//         debugger;
//         let res1 = await fetch("/api/admin/ofertas.php", {
//             method: "GET",
//         });
//         let data = await res1.json();

//         if (!data.success) {
//             alert(data.error || "Error al cargar las ofertas");
//             return;
//         }

//         let res2 = await fetch("/api/admin/ofertas.php", {
//             method: "POST",
//             headers: {
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify({ 
//                 id: data.data[0].empresa_id,
//             })
//         });

//         let data2 = await res2.json();

//         if (!data2.success) {
//             alert(data2.error || "Error al obtener la empresa por ID");
//             return;
//         }

        

//         mostrarTablaOfertas(data.data, data2.nombre);  
        
//     } catch(error) {
//         console.error("Error: ", error);
//         alert("Error de conexión");
//     }
// }



//     /**
//      * Mostrar tabla de ofertas
//      */
//     function mostrarTablaOfertas(ofertas, nombre) {
//         const contenedor = document.getElementById('tablaOfertas');
//         if (!contenedor) return;
        
//         let html = '<table><thead><tr>';
//         html += '<th>Empresa</th><th>Titulo</th><th>Fecha de creación</th><th>Fecha de fin</th><th>Acciones</th>';
//         html += '</tr></thead><tbody>';
        
//         ofertas.forEach(oferta => {
//             html += `<tr>
//                 <td>${nombre.nombre}</td>
//                 <td>${oferta.titulo}</td>
//                 <td>${oferta.fecha_inicio}</td>
//                 <td>${oferta.fecha_cierre}</td>
//                 <td>
//                     <button onclick="borrarOferta(${oferta.id})">Borrar</button>
//                     <button onclick="abrirModal(${oferta.id})">Editar</button>
//                 </td>
//             </tr>`;
//         });
        
//         html += '</tbody></table>';
//         contenedor.innerHTML = html;
//     }

//     const modal = document.getElementById("modalEditarOferta");
//     const btnCancelar = document.getElementById("btnCancelarModal");
//     const btnCerrar = document.querySelector("modal-close")
//     const form = document.getElementById("formEditarOferta");


//     // Event listeners del modal (solo UNA VEZ al cargar la página)
//     // ESTO TE LO HA DADO LA IA PREGUNTAR A SILVERIO

//     window.addEventListener('click', function(event) {
//         if (event.target === modal) {
//             cerrarModal();
//         }
//     });

//     // PREGUNTAR A SILVERIO POR QUE SIN WINDOW Y COMO FUNCIONES NORMALES DICEN QUE NO ESTAN DEFINED
//     function cerrarModal(){
//         modal.style.display="none";
//     }

//     function abrirModal (id)
//     {
        
//         fetch("/api/admin/ofertas.php", {
//             method: "GET",
//         })
//         .then(response => response.json())
//         .then(data => {
//             if(!data.success){
//                 alert(data.error);
//                 return;
//             }

//             const oferta = data.data.find(o => o.id === id);
//             console.log(oferta);

//             if (oferta) {

//                 document.getElementById('tituloModal').value = oferta.titulo;
//                 document.getElementById('descModal').value = oferta.descripcion;
//                 document.getElementById('requisitosModal').value = oferta.requisitos;
//                 document.getElementById('cicloIDModal').value = oferta.ciclo_id;
//                 document.getElementById('fechaIniModal').value = oferta.fecha_inicio;
//                 document.getElementById('fechaFinModal').value = oferta.fecha_cierre;
//                 document.getElementById('modalidadModal').value = oferta.modalidad;
//                 document.getElementById('salarioModal').value = oferta.salario;
//             }

//             modal.style.display = 'block';

//             //TODO: POR ACABAR

//         })
//         .catch(error => {
//             console.error("Error:", error);
//             alert("Error al cargar la oferta del modal");
//         });

//     }

//     btnCerrar.addEventListener('click', cerrarModal);
//     btnCancelar.addEventListener('click', cerrarModal);

        

    


    /**
     * Editar oferta
     */
    function editarOferta(id)
    {
        fetch("/api/admin/empresa.php", {
            method: "PUT",
        })
    }



    /**
     * Borrar oferta
     */
    function borrarOferta(id)
    {
        fetch("/api/admin/ofertas.php", {
            method: "DELETE",
        })
        .then(response => response.json())
        .then(data => {
            if(data.success == true){
                alert("Oferta borrada.");
            }
            else
            {
                alert(data.error, "No ha sido posible borrar la oferta.")
            }
        })
        .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
        });
    }


})