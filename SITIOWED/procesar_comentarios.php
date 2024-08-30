<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comentarios";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario al enviarse
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $comentario = $conn->real_escape_string($_POST['comentario']);
    $fecha = date('Y-m-d H:i:s'); // Obtén la fecha y hora actual

    // Inserción de datos en la tabla de comentarios
    $sql = "INSERT INTO tabla1 (nombre, comentario, fecha)
            VALUES ('$nombre', '$comentario', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        echo "Gracias por tu comentario.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
