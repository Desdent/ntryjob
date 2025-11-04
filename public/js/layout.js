document.addEventListener('DOMContentLoaded', function() {
    const btnLogout = document.getElementById('btnLogout');
    
    if (btnLogout) {
        btnLogout.addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch('/api/auth/logout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                window.location.href = '/public/index.php?page=login';
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = '/public/index.php?page=login';
            });
        });
    }
});

