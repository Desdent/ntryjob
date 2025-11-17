document.addEventListener("DOMContentLoaded", function(){

    mostrarMenuIzq()
    let botonesAplicar = document.querySelectorAll(".btnAplicar");
    // TO-DO APLICARLES LOS EVENTLISTENER CLICK











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