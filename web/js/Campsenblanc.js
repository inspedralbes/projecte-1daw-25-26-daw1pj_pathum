 document.getElementById('formCrear').onsubmit = function(event) {
            var dep = document.getElementById('selDep').value;
            var tipo = document.getElementById('selTipo').value;
            var desc = document.getElementById('txtDesc').value;

            if (dep === "" || tipo === "" || desc.trim() === "") {
                alert("Error: Tots els camps són obligatoris!");
                event.preventDefault(); 
            }
        };