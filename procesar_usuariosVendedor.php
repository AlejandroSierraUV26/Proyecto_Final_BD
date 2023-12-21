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

// Recoger los datos del formulario
$identificacion = $_POST['identificacion'];
$contraseña = $_POST['contraseña'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$rol = $_POST['rol'];
$usuario = $_POST['usuario_enviado'];


$verificarUsuario = "SELECT usuario FROM administradores WHERE usuario = '$identificacion'";
$resultado = $conn->query($verificarUsuario);
if ($resultado->num_rows > 0) {
    echo "El Dato ya existe en la base de datos.";
} else {
    $sqlUniforme = "INSERT INTO `administradores` (`usuario`, `contraseña`, `nombre`, `apellido`, `direccion`, `telefono`, `rol`) VALUES ('$identificacion', '$contraseña', '$nombre', '$apellido', '$direccion', '$telefono', '$rol')";
    if ($conn->query($sqlUniforme) === TRUE) {
            // Si los datos se insertan correctamente, redirigir a home.php
            header("Location: homevendedor.php?id=$usuario");
            $conn->close();
            exit(); // Asegura que el código se detenga aquí para la redirección
        } else {
        echo "Error al insertar datos del cliente: " . $conn->error;
    }
}



