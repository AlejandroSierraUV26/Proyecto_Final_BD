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
$usuario = $_POST['usuario_enviado'];

$verificarUsuario = "SELECT usuario FROM administradores WHERE usuario = '$identificacion'";
$resultado = $conn->query($verificarUsuario);
if ($resultado->num_rows > 0) {
    $sqlUniforme = "DELETE FROM `administradores` WHERE usuario = '$identificacion' and contraseña = '$contraseña'";
    if ($conn->query($sqlUniforme) === TRUE) {
        // Si los datos se insertan correctamente, redirigir a home.php
        header("Location: home.php?id=$usuario");
        $conn->close();
        exit(); // Asegura que el código se detenga aquí para la redirección
    } else {
    echo "Error al borrar el cliente: " . $conn->error;
}
 
} else {
    echo "El Dato ya no existe en la base de datos.";
}



