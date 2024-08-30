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
            <title>Editar Registro</title>
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
                .container input[type="text"], .container input[type="number"], .container select {
                    width: 100%;
                    padding: 10px;
                    margin: 10px 0;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }
                .container input[type="submit"] {
                    background: #5cb85c;
                    color: #fff;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    width: 100%;
                }
                .container input[type="submit"]:hover {
                    background: #4cae4c;
                }
                .container img {
                    max-width: 100%;
                    height: auto;
                    border-radius: 10px;
                }
            </style>
        </head>
        <body>

        <div class="container">
            <h2>Editar Registro</h2>
            <form action="ACTUALIZARCOMPRA.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

                <label for="nombre_cliente">Nombre del Cliente:</label>
                <input type="text" name="nombre_cliente" id="nombre_cliente" value="<?php echo htmlspecialchars($row['nombre_cliente']); ?>" required>

                <label for="tipo_camisa">Tipo de Camisa:</label>
                <select name="tipo_camisa" id="tipo_camisa">
                    <option value="Original" <?php if ($row['tipo_camisa'] == 'Original') echo 'selected'; ?>>Original</option>
                    <option value="Retro" <?php if ($row['tipo_camisa'] == 'Retro') echo 'selected'; ?>>Retro</option>
                    <option value="Aficionado" <?php if ($row['tipo_camisa'] == 'Aficionado') echo 'selected'; ?>>Aficionado</option>
                </select>

                <label for="talla">Talla:</label>
                <input type="text" name="talla" id="talla" value="<?php echo htmlspecialchars($row['talla']); ?>" required>

                <label for="personalizar">Personalizar:</label>
                <select name="personalizar" id="personalizar">
                    <option value="Sí" <?php if ($row['personalizar'] == 'Sí') echo 'selected'; ?>>Sí</option>
                    <option value="No" <?php if ($row['personalizar'] == 'No') echo 'selected'; ?>>No</option>
                </select>

                <?php if ($row['personalizar'] == 'Sí'): ?>
                <label for="nombre_numero">Nombre y Número:</label>
                <input type="text" name="nombre_numero" id="nombre_numero" value="<?php echo htmlspecialchars($row['nombre_numero']); ?>" required>
                <?php endif; ?>

                <label for="imagen_actual">Imagen Actual:</label><br>
                <img src="uploads/<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen del Producto"><br><br>

                <label for="imagen_nueva">Cambiar Imagen:</label>
                <input type="file" name="imagen_nueva" id="imagen_nueva">

                <input type="submit" value="Actualizar">
            </form>
        </div>

        </body>
        </html>

        <?php
    } else {
        echo "No se encontró ningún registro con ese ID.";
    }

    $stmt->close();
}

$conn->close();
?>
