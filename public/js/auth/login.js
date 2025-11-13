document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById("form-login");

    formulario.addEventListener("submit", async function(e){
        e.preventDefault();

        const datosFormulario = new FormData(formulario);

        const datosObjeto = Object.fromEntries(datosFormulario.entries());

        await fetch("/api/TokenController.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosObjeto)
        })
        .then(response => response.json())
        .then(data => {
            if(data.success)
            {

                sessionStorage.setItem("token", data.token);
            }
            else
            {
                alert(data.error || "Error al iniciar sesion");
            }
        })

        await fetch("/api/auth/LoginController.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`
            },
            body: JSON.stringify(datosFormulario)
            .then(response => response.json())
            .then(data => {
                if(data.success)
                {
                    window.location.href = data.redirec_url;
                }
                else
                {
                    alert(data.error || "Error al iniciar sesión")
                }
            })
        })
    });

})