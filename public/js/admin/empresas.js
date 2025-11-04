document.addEventListener('DOMContentLoaded', function() {
    cargarEmpresasPendientes();
});

/**
 * Listar empresas pendientes de aprobación
 */
function cargarEmpresasPendientes() {
    fetch('/api/admin/empresas.php', {
        method: 'GET',
        // headers: {
        //     'Content-Type': 'application/json'
        // } NO hace falta header aqui por get, el header es para indicar al php con el que te conectas y aqui lo que haces es recibir asi que no mandas nada que tendas que indicar formato
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarTablaEmpresas(data.empresas);
        } else {
            alert(data.error || 'Error al cargar empresas');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}

/**
 * Mostrar tabla de empresas
 */
function mostrarTablaEmpresas(empresas) {
    const contenedor = document.getElementById('tablaEmpresas');
    if (!contenedor) return;
    
    let html = '<table><thead><tr>';
    html += '<th>Nombre</th><th>CIF</th><th>Email</th><th>Sector</th><th>Acciones</th>';
    html += '</tr></thead><tbody>';
    
    empresas.forEach(empresa => {
        html += `<tr>
            <td>${empresa.nombre}</td>
            <td>${empresa.cif}</td>
            <td>${empresa.email}</td>
            <td>${empresa.sector || 'Sin sector'}</td>
            <td>
                <button onclick="aprobarEmpresa(${empresa.id})">Aprobar</button>
                <button onclick="rechazarEmpresa(${empresa.id})">Rechazar</button>
            </td>
        </tr>`;
    });
    
    html += '</tbody></table>';
    contenedor.innerHTML = html;
}

/**
 * Aprobar empresa
 */
function aprobarEmpresa(id) {
    fetch('/api/admin/empresas.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
            id: id,
            action: 'aprobar'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Empresa aprobada');
            cargarEmpresasPendientes();
        } else {
            alert(data.error || 'Error al aprobar empresa');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}

/**
 * Rechazar empresa
 */
function rechazarEmpresa(id) {
    fetch('/api/admin/empresas.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
            id: id,
            action: 'rechazar'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Empresa rechazada');
            cargarEmpresasPendientes();
        } else {
            alert(data.error || 'Error al rechazar empresa');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error de conexión');
    });
}
