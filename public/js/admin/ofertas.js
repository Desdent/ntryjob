document.addEventListener("DOMContentLoaded", function(){

    function editarOferta(id) {
        fetch("/api/admin/empresa.php", {
            method: "PUT",
        })
    }

    function borrarOferta(id) {
        fetch("/api/admin/ofertas.php", {
            method: "DELETE",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success == true){
                alert("Oferta borrada.");
            }
            else
            {
                alert(data.error || "No ha sido posible borrar la oferta.")
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        });
    }

})

