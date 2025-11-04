document.addEventListener("DOMContentLoaded", function(){


    cargarOfertas();

    /**
     * Listar ofertas de 1 ciclo (CAMBIAR LUEGO PARA QUE FUNCIONE CON TODOS LOS CICLOS DEL USUARIO)
     */
    async function cargarOfertas() {
        try {
        
            let res1 = await fetch("/api/alumno/ofertas.php?action=findCiclos", {
                method: "GET",
            });
            let data = await res1.json(); // array de id's de los ciclos que tiene el alumno

            if (!data.success) {
                alert(data.error || "Error al cargar las ofertas");
                return;
            }

            let idsString = data.ciclos.join(',');

            let res2 = await fetch(`/api/alumno/ofertas.php?action=byCiclos&ids=${idsString}`);
            let data2 = await res2.json();


            if (!data2.success) {
                alert(data2.error || "Error al cargar ofertas");
                return;
            }

            console.log("Ofertas:", data2.ofertas);
            mostrarOfertas(data2.ofertas);
            
        } catch(error) {
            console.error("Error: ", error);
            alert("Error de conexión");
        }
    }


    function mostrarOfertas(ofertas)


})