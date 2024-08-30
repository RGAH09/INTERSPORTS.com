<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "prueba";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $tipo_camisa = $_POST['tipo_camisa'];
    $talla = $_POST['talla'];
    $personalizar = $_POST['personalizar'];
    $nombre_numero = $_POST['nombre_numero'] ?? null; // Valor por defecto si no se proporciona
    $imagen_nueva = $_FILES['imagen_nueva']['name'];

    if ($imagen_nueva) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($imagen_nueva);

        // Mover la imagen subida al directorio de destino
        if (move_uploaded_file($_FILES['imagen_nueva']['tmp_name'], $target_file)) {
            // Actualizar el registro con la nueva imagen
            $sql = "UPDATE camisas SET nombre_cliente=?, tipo_camisa=?, talla=?, personalizar=?, nombre_numero=?, imagen=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $nombre_cliente, $tipo_camisa, $talla, $personalizar, $nombre_numero, $imagen_nueva, $id);
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    } else {
        // Actualizar el registro sin cambiar la imagen
        $sql = "UPDATE camisas SET nombre_cliente=?, tipo_camisa=?, talla=?, personalizar=?, nombre_numero=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre_cliente, $tipo_camisa, $talla, $personalizar, $nombre_numero, $id);
    }

    if ($stmt->execute()) {
        echo "Registro actualizado exitosamente.";
    } else {
        echo "Error al actualizar el registro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
