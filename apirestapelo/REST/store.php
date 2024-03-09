<!-- store.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario para agregar modelo</title>
</head>
<body>

<h2>Formulario para agregar modelo</h2>

<form id="modeloForm">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="brand">Marca:</label>
    <input type="text" id="brand" name="brand" required><br>

    <label for="year">Año:</label>
    <input type="text" id="year" name="year" required><br>

    <button type="button" onclick="submitForm()">Enviar</button>
</form>

<script>
function submitForm() {
    var formData = new FormData(document.getElementById("modeloForm"));
    alert ("Modelo creado exitosamente");

    // Enviar el formulario
    fetch("http://localhost:8080/php/serviciosWeb/REST/index.php?api/modelo/store", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        return response.json();
    })
}


</script>

</body>
</html>
