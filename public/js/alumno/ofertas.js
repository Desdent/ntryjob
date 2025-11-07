document.addEventListener("DOMContentLoaded", function(){

    cargarOfertas();

    async function cargarOfertas() {
        try {
            let res1 = await fetch("/api/alumno/ofertas.php?action=findCiclos", {
                method: "GET",
            });
            let data = await res1.json();

            if (!data.success) {
                alert(data.error || "Error al cargar las ofertas");
                return;
            }

            let idsString = data.ciclos.join(',');

            let res2 = await fetch(`/api/alumno/ofertas.php?ids=${idsString}`);
            let data2 = await res2.json();

            console.log("Ofertas:", data2);
            
            if (Array.isArray(data2)) {
                mostrarOfertas(data2);
            } else if (data2.ofertas) {
                mostrarOfertas(data2.ofertas);
            } else {
                console.error("Formato inesperado:", data2);
            }
            
        } catch(error) {
            console.error("Error: ", error);
            alert("Error de conexión");
        }
    }

    function mostrarOfertas(ofertas) {
        const container = document.getElementById('ofertasContainer');
        if (!container) return;
        
        container.innerHTML = '';
        
        ofertas.forEach(oferta => {
            const card = document.createElement('div');
            card.className = 'oferta-card';
            card.innerHTML = `
                <h3>${oferta.titulo}</h3>
                <p><strong>Empresa:</strong> ${oferta.empresa_nombre}</p>
                <p><strong>Ciclo:</strong> ${oferta.ciclo_nombre}</p>
                <p><strong>Modalidad:</strong> ${oferta.modalidad}</p>
                <p>${oferta.descripcion}</p>
                <button onclick="postularse(${oferta.id})">Postularme</button>
            `;
            container.appendChild(card);
        });
    }




    window.postularse = function(ofertaId) {
    if (!confirm('¿Seguro que quieres postularte a esta oferta?')) {
        return;
    }
    
    fetch('/api/alumno/postulaciones.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ oferta_id: ofertaId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Postulación enviada correctamente');
        } else {
            alert(data.error || 'Error al postularse');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}

})
