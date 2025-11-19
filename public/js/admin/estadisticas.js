document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Configuración del Menú Lateral (Igual que en alumnos.js)
    let opts = document.querySelectorAll(".optLateral");
    
    // Aseguramos textos (aunque ya están en el HTML)
    if(opts[0]) opts[0].innerText = "Panel de Alumnos";
    if(opts[1]) opts[1].innerText = "Panel de Empresas";
    if(opts[2]) opts[2].innerText = "Estadísticas";

    // Eventos de navegación
    if(opts[0]) {
        opts[0].addEventListener("click", function(){
            window.location.href ='index.php?page=dashboard-admin-alumnos';
        });
    }
    if(opts[1]) {
        opts[1].addEventListener("click", function(){
            window.location.href ='index.php?page=dashboard-admin-empresas';
        });
    }
    if(opts[2]) {
        opts[2].addEventListener("click", function(){
            window.location.href ='index.php?page=dashboard-admin-estadisticas';
        });
    }

    // 2. Cargar y Renderizar Gráficos
    fetch('/api/admin/estadisticas.php')
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                renderCharts(data.data);
            } else {
                console.error('Error data:', data.error);
            }
        })
        .catch(error => console.error('Error fetch:', error));

    function renderCharts(datos) {
        // --- GRÁFICO 1: USUARIOS (PIE) ---
        const ctxUsers = document.getElementById('chartUsuarios').getContext('2d');
        new Chart(ctxUsers, {
            type: 'doughnut',
            data: {
                labels: ['Alumnos', 'Empresas'],
                datasets: [{
                    data: [datos.usuarios.alumnos, datos.usuarios.empresas],
                    backgroundColor: ['#3b82f6', '#10b981'], // Azul y Verde
                    hoverOffset: 4
                }]
            },
            options: { responsive: true }
        });

        // --- GRÁFICO 2: TOP CICLOS (BAR HORIZONTAL) ---
        const nombresCiclos = datos.ciclos.map(c => c.nombre);
        const totalCiclos = datos.ciclos.map(c => c.total);

        const ctxCiclos = document.getElementById('chartCiclos').getContext('2d');
        new Chart(ctxCiclos, {
            type: 'bar',
            data: {
                labels: nombresCiclos,
                datasets: [{
                    label: 'Alumnos matriculados',
                    data: totalCiclos,
                    backgroundColor: '#8b5cf6', // Violeta
                    borderColor: '#7c3aed',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Hace que sea horizontal
                responsive: true,
                scales: { x: { beginAtZero: true } }
            }
        });

        // --- GRÁFICO 3: OFERTAS (BARRA VERTICAL) ---
        const estados = datos.ofertas.map(o => o.estado || 'Sin estado');
        const totalOfertas = datos.ofertas.map(o => o.total);

        const ctxOfertas = document.getElementById('chartOfertas').getContext('2d');
        new Chart(ctxOfertas, {
            type: 'bar',
            data: {
                labels: estados,
                datasets: [{
                    label: 'Cantidad de Ofertas',
                    data: totalOfertas,
                    backgroundColor: ['#f59e0b', '#ef4444', '#6366f1'], 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }
});