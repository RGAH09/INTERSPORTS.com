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

// Verificar si se ha enviado el ID para buscar el registro
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Verificar si se ha presionado el botón para eliminar
    if (isset($_POST['delete'])) {
        // Eliminar el registro de la base de datos
        $sql = "DELETE FROM camisas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<p>Registro eliminado exitosamente.</p>";
        } else {
            echo "<p>Error al eliminar el registro: " . $conn->error . "</p>";
        }
        $stmt->close();
        $conn->close();
        echo '<a href="INDEX.html">Regresar al Índice</a>';
        exit;
    }

    // Consultar el registro por ID
    $sql = "SELECT * FROM camisas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>

        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Eliminar Compra</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f4f4f4;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    background: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                }
                .container label {
                    display: block;
                    margin: 10px 0 5px;
                }
                .container span {
                    display: block;
                    margin: 10px 0;
                }
                .container img {
                    max-width: 200px; /* Ajusta el tamaño máximo según lo necesario */
                    max-height: 200px; /* Ajusta el tamaño máximo según lo necesario */
                    object-fit: contain; /* Mantiene la proporción de la imagen */
                    margin: 10px 0;
                }
                .container input[type="submit"] {
                    background: #d9534f;
                    color: #fff;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    width: 100%;
                }
                .container input[type="submit"]:hover {
                    background: #c9302c;
                }
                .container a {
                    display: block;
                    margin-top: 10px;
                    text-align: center;
                    color: #5bc0de;
                    text-decoration: none;
                }
                .container a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>

        <div class="container">
            <h2>Detalles de la Compra</h2>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

                <label>Nombre del Cliente:</label>
                <span><?php echo htmlspecialchars($row['nombre_cliente']); ?></span>

                <label>Tipo de Camisa:</label>
                <span><?php echo htmlspecialchars($row['tipo_camisa']); ?></span>

                <label>Talla:</label>
                <span><?php echo htmlspecialchars($row['talla']); ?></span>

                <label>Personalizar:</label>
                <span><?php echo htmlspecialchars($row['personalizar']); ?></span>

                <label>Imagen:</label><br>
                <img src="uploads/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen del Producto"><br><br>

                <input type="submit" name="delete" value="Eliminar Registro">

                <a href="INDEX.html">Regresar al Índice</a>
            </form>
        </div>

        </body>
        </html>

        <?php
    } else {
        echo "No se encontró ningún registro con ese ID.";
    }

    $stmt->close();
} else {
    echo "ID no especificado.";
}

$conn->close();
?>
