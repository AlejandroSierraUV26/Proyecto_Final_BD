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

$identificacion = $_POST['id_uniforme'];
$nombre = $_POST['tipo_uniforme'];
$color = $_POST['color'];
$tipo_tela = $_POST['tipo_tela'];
$id_colegio = $_POST['id_colegio'];
$usuario = $_POST['usuario_enviado'];

$verificarUsuario = "SELECT Id_Uniforme FROM uniforme WHERE Id_Uniforme = '$identificacion'";
$resultado = $conn->query($verificarUsuario);

if ($resultado->num_rows > 0) {
    echo "El Dato ya existe en la base de datos.";
} else {
    $sqlUniforme = "INSERT INTO `uniforme` (`Id_Uniforme`, `Tipo_Uniforme`, `Color`, `Tipo_Tela`, `Id_Colegio`) VALUES ('$identificacion', '$nombre', '$color', '$tipo_tela', '$id_colegio')";
    if ($conn->query($sqlUniforme) === TRUE) {
            // Si los datos se insertan correctamente, redirigir a home.php
            header("Location: home.php?id=$usuario");
            $conn->close();
            exit(); // Asegura que el código se detenga aquí para la redirección
        } else {
        echo "Error al insertar datos del cliente: " . $conn->error;
    }
}
