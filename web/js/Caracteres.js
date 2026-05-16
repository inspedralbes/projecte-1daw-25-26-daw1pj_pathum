document.getElementById('miFormulario').onsubmit = function(event) {
        var comentario = document.getElementById('textoSolucion').value;

       
        if (comentario.trim().length < 20) {
            alert("La descripció de l'actuació ha de tenir almenys 20 caràcters!");
            event.preventDefault(); 
        }
    };