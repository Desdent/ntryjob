document.addEventListener("DOMContentLoaded", function(){

    mostrarMenuIzq()
    let botonesAplicar = document.querySelectorAll(".btnAplicar");
    let botonesAnular = document.querySelectorAll(".btnAnular");

    botonesAplicar.forEach(btnAplicar => {
        btnAplicar.addEventListener("click", function(e){
            e.preventDefault();
            
            console.log(btnAplicar);
            data = {"oferta_id" : this.value};

            this.disabled=true;
            this.innerHTML="Aplicado";
            this.style.pointerEvents = "none";
            this.style.color="white";
            this.style.boxShadow = "none";
            this.style.backgroundColor ="#075588";

            fetch("/api/alumno/postulaciones.php", {
                method: "POST",
                headers: {
                    "Content_Type":"application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success)
                {
                    alert("Postulación Realizada");
                }
                else
                {
                    alert("Error conectando la api postulaciones")
                }
            })
        })
    });



    botonesAnular.forEach(btnAnular => {
        btnAnular.addEventListener("click", function(e){
            e.preventDefault();
            
            data = {"oferta_id" : this.value};

            this.disabled=true;
            this.innerHTML="Anulada";
            this.style.pointerEvents = "none";
            this.style.color="white";
            this.style.boxShadow = "none";
            this.style.backgroundColor ="#075588";

            fetch("/api/alumno/postulaciones.php", {
                method: "DELETE",
                headers: {
                    "Content_Type":"application/json"
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if(data.success)
                {
                    alert("Postulación Anulada");
                }
                else
                {
                    alert("Error conectando la api postulaciones")
                }
            })
        })
    });










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