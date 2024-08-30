<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ventadecomida";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para seleccionar todos los datos
$sql = "SELECT * FROM pedido";
$result = $conn->query($sql);

// Verificar si la consulta tuvo éxito
if (!$result) {
    die("Error en la consulta SQL: " . $conn->error);
}

$total = 0;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Pedidos</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            background-image: url('Imagenes/descarga (2).jpeg'); /* Reemplaza con la ruta de tu imagen de fondo */
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1 {
            text-align: center;
            color: white;
        }
        table {
            border-collapse: collapse;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semi-transparente para la tabla */
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }
        th, td {
            border: 2px solid #444;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #444;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #444;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div>
        <h1>Lista de Pedidos</h1>
        <table>
            <tr>
                <th>NCliente</th>
                <th>Plato</th>
                <th>Acompañamiento</th>
                <th>Bebida</th>
                <th>Salsa</th>
                <th>Postre</th>
                <th>Total</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar datos de cada fila
                while($row = $result->fetch_assoc()) {
                    // Verificar si el campo Total está presente en la fila
                    $totalValue = isset($row['Total']) ? $row['Total'] : 0;
                    $total += $totalValue; // Sumar el total general

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["NCliente"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Plato"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Acompanamiento"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Bebida"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Salsa"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Postre"]) . "</td>";
                    echo "<td>L. " . number_format($totalValue, 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay registros</td></tr>";
            }
            $conn->close();
            ?>
        </table>
        <h2>Total General: L. <?php echo number_format($total, 2); ?></h2>
        <a href="index.html" class="back-button">Regresar al Inicio</a>
    </div>
</body>
</html>
