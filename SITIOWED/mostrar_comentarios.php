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

// Mostrar comentarios existentes
$sql = "SELECT nombre, comentario, fecha FROM tabla1 ORDER BY fecha DESC";
$result = $conn->query($sql);

// Mostrar comentarios en HTML
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<h4>" . htmlspecialchars($row['nombre']) . "</h4>";
        echo "<p>" . htmlspecialchars($row['comentario']) . "</p>";
        echo "<p class='fecha'>" . htmlspecialchars($row['fecha']) . "</p>"; // Mostrar la fecha y hora
        echo "</div>";
    }
} else {
    echo "<p>No hay comentarios aún. ¡Sé el primero en comentar!</p>";
}

// Cerrar la conexión
$conn->close();
?>
