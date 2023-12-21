<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyectobd"; 
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$identificacion = $_POST['codigo_producto'];
$descripcion = $_POST['descripcion'];
$talla = $_POST['talla'];
$sexo = $_POST['sexo'];
$precio_venta = $_POST['precio_venta'];
$cantidad_existente = $_POST['cantidad_existencia'];
$usuario = $_POST['usuario_enviado'];

$verificarUsuario = "SELECT Codigo_Producto FROM producto_terminado WHERE Codigo_Producto = '$identificacion'";
$resultado = $conn->query($verificarUsuario);
if ($resultado->num_rows > 0) {
    echo "El Dato ya existe en la base de datos.";
} else {
    $sqlUniforme = "INSERT INTO `producto_terminado` (`Codigo_Producto`, `Descripcion`, `Talla`, `Sexo`, `Precio_Venta`, `Cantidad_Existencia`) VALUES ('$identificacion', '$descripcion', '$talla', '$sexo', '$precio_venta', '$cantidad_existente')";
    if ($conn->query($sqlUniforme) === TRUE) {
            // Si los datos se insertan correctamente, redirigir a home.php
            header("Location: homevendedor.php?id=$usuario");
            $conn->close();
            exit(); // Asegura que el código se detenga aquí para la redirección
        } else {
        echo "Error al insertar datos del cliente: " . $conn->error;
    }
}
