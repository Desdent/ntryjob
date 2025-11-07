document.addEventListener("DOMContentLoaded", function(){
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