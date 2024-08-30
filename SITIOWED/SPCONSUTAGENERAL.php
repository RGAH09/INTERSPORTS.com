<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "prueba";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT id, nombre_cliente, equipo_seleccion, imagen, tipo_camisa, personalizar, talla, precio, nombre_numero FROM camisas";
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
    <title>Consulta de Ventas</title>
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
        img {
            width: 100px;
            height: auto;
        }
        h2 {
            text-align: center;
            color: white;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #444;
            font-weight: bold;
        }
        .actions a:hover {
            text-decoration: underline;
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
        <h1>Lista de Camisetas Vendidas</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre del Cliente</th>
                <th>Equipo o Selección</th>
                <th>Imagen</th>
                <th>Tipo de Camisa</th>
                <th>Personalizar</th>
                <th>Talla</th>
                <th>Precio</th>
                <th>Nombre y Número</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar datos de cada fila
                while($row = $result->fetch_assoc()) {
                    $base_price = $row['precio']; // Precio base de la camiseta

                    // Calcular incremento según el tipo de camisa
                    $incremento = 0;
                    if ($row['tipo_camisa'] == 'Original') {
                        $incremento = $base_price * 0.15; // 15% adicional
                    } elseif ($row['tipo_camisa'] == 'Retro') {
                        $incremento = $base_price * 0.10; // 10% adicional
                    }

                    // Incremento adicional del 15% si la camiseta está personalizada
                    if ($row['personalizar'] == 'Sí') {
                        $incremento += $base_price * 0.15;
                    }

                    $precio_final = $base_price + $incremento;

                    // Sumar el precio final al total general
                    $total += $precio_final;

                    echo "<tr>";
                    echo "<td>" . $row["id"]. "</td>";
                    echo "<td>" . $row["nombre_cliente"]. "</td>";
                    echo "<td>" . $row["equipo_seleccion"]. "</td>";
                    echo "<td><img src='uploads/" . $row['imagen'] . "' alt='Imagen'></td>";
                    echo "<td>" . $row["tipo_camisa"]. "</td>";
                    echo "<td>" . $row["personalizar"]. "</td>";
                    echo "<td>" . $row["talla"]. "</td>";
                    echo "<td>L. " . number_format($base_price, 2) . "</td>";
                    echo "<td>" . $row["nombre_numero"]. "</td>";
                    echo "<td>L. " . number_format($precio_final, 2) . "</td>";
                    echo "<td class='actions'>
                            <a href='BUSQUEDA.Html?id=" . $row["id"] . "'>Editar</a>
                            <a href='ELIMINARCOMPRA.Html?id=" . $row["id"] . "'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No hay registros</td></tr>";
            }
            $conn->close();
            ?>
        </table>
      
        <a href="index.html" class="back-button">Regresar al Inicio</a>
    </div>
</body>
</html>
