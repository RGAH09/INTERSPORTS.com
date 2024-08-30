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

// Recoger los datos del formulario
$nombre_cliente = isset($_POST['nombre_cliente']) ? $_POST['nombre_cliente'] : '';
$equipo_seleccion = isset($_POST['equipo_seleccion']) ? $_POST['equipo_seleccion'] : '';
$tipo_camisa = isset($_POST['tipo_camisa']) ? $_POST['tipo_camisa'] : '';
$personalizar = isset($_POST['personalizar']) ? $_POST['personalizar'] : '';
$nombre_numero = isset($_POST['nombre_numero']) ? $_POST['nombre_numero'] : '';
$talla = isset($_POST['talla']) ? $_POST['talla'] : '';

// Definir precios base
$precios_base = [
    'Original' => 2000 * 1.15, // 15% más caro
    'Retro' => 1700 * 1.10,    // 10% más caro
    'Aficionado' => 1200        // Sin incremento
];

// Verificar que tipo_camisa es una cadena
if (is_string($tipo_camisa) && array_key_exists($tipo_camisa, $precios_base)) {
    $precio_total = $precios_base[$tipo_camisa];
} else {
    echo "Tipo de camisa no reconocido o no válido.";
    exit();
}

// Manejo de la imagen
$target_dir = "uploads/";
$imageFileType = "";
$imagen = "";

// Verificar si el directorio de destino existe
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true); // Crea el directorio si no existe
}

// Verificar si se subió una imagen o se proporcionó una URL
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == UPLOAD_ERR_OK) {
    // Procesar imagen subida desde el archivo
    $imagen = basename($_FILES["imagen"]["name"]);
    $target_file = $target_dir . $imagen;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Verificar si el archivo de imagen es una imagen real
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            // Imagen subida correctamente
        } else {
            echo "Error subiendo la imagen.";
            exit();
        }
    } else {
        echo "El archivo no es una imagen válida.";
        exit();
    }
} elseif (!empty($_POST['image_url'])) {
    // Procesar imagen desde la URL
    $image_url = $_POST['image_url'];
    $image_extension = pathinfo(parse_url($image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
    
    // Generar nombre de archivo único
    $imagen = uniqid() . '.' . $image_extension;
    $target_file = $target_dir . $imagen;
    
    // Descargar imagen desde la URL
    $image_data = file_get_contents($image_url);
    if ($image_data !== false) {
        if (file_put_contents($target_file, $image_data)) {
            // Imagen descargada correctamente
        } else {
            echo "Error descargando la imagen.";
            exit();
        }
    } else {
        echo "No se pudo obtener la imagen desde la URL.";
        exit();
    }
} else {
    echo "No se ha proporcionado ninguna imagen.";
    exit();
}

// Insertar datos en la base de datos
$sql = "INSERT INTO camisas (nombre_cliente, equipo_seleccion, imagen, tipo_camisa, personalizar, nombre_numero, talla, precio)
        VALUES ('$nombre_cliente', '$equipo_seleccion', '$imagen', '$tipo_camisa', '$personalizar', '$nombre_numero', '$talla', '$precio_total')";

if ($conn->query($sql) === TRUE) {
    echo "Registro creado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
