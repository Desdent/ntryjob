document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('form-login');
    
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                alert('Por favor completa todos los campos');
                return;
            }
            
            fetch('/api/auth/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const role = data.user.role;
                    
                    if (role === 'admin') {
                        window.location.href = '/public/index.php?page=dashboard-admin';
                    } else if (role === 'empresario') {
                        if (data.user.aprobada == 1) {
                            window.location.href = '/public/index.php?page=dashboard-empresario';
                        } else {
                            alert('Tu empresa está pendiente de aprobación');
                        }
                    } else if (role === 'alumno') {
                        window.location.href = '/public/index.php?page=dashboard-alumno';
                    }
                } else {
                    alert(data.error || 'Error al iniciar sesión');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de conexión. Intenta de nuevo.');
            });
        });
    }

    const btnRegistrarse = document.getElementById('botonRegistrarse');
    if (btnRegistrarse) {
        btnRegistrarse.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/public/index.php?page=register';
        });
    }
});