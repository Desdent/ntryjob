document.addEventListener('DOMContentLoaded', function() {
    
    const formulario = document.getElementById("form-login");

    formulario.addEventListener("submit", async function(e){
        e.preventDefault();

        const datosFormulario = new FormData(formulario);
        const datosObjeto = Object.fromEntries(datosFormulario.entries());

        try {
            // 1. Obtener token
            const tokenResponse = await fetch("/api/TokenController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(datosObjeto)
            });
            
            const tokenData = await tokenResponse.json();
            
            if (!tokenData.success) {
                alert(tokenData.error || "Error al obtener token");
                return;
            }
            
            const token = tokenData.token;
            sessionStorage.setItem("token", token);

            // 2. Hacer login con el token
            const loginResponse = await fetch("/api/auth/LoginController.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": `Bearer ${token}`
                },
                body: JSON.stringify(datosObjeto)
            });
            
            const loginData = await loginResponse.json();
            console.log(loginData);
            
            if (loginData.success) {
                window.location.href = loginData.redirect_url;
            } else {
                alert(loginData.error || "Error al iniciar sesión");
            }
            
        } catch (error) {
            console.error("Error:", error);
            alert("Error de conexión. Intenta de nuevo.");
        }
    });
});