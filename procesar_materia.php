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
$identificacion = $_POST['codigo_materia'];
$tipo_materia = $_POST['tipo_materia'];
$descripcion = $_POST['descripcion'];
$cantidad_existente = $_POST['cantidad_existente'];
$unidad_medida = $_POST['unidad_medida'];
$Nit = $_POST['Nit'];
$usuario = $_POST['usuario_enviado'];

$verificarUsuario = "SELECT Codigo_Materia FROM materia_prima WHERE Codigo_Materia = '$identificacion'";
$resultado = $conn->query($verificarUsuario);
if ($resultado->num_rows > 0) {
    echo "El Dato ya existe en la base de datos.";
} else {
    $sqlUniforme = "INSERT INTO `materia_prima` (`Codigo_Materia`, `Tipo_Materia`, `Descripcion`, `Cantidad_Existente`, `NIT_Proveedor`, `Unidad_Medida`) VALUES ('$identificacion', '$tipo_materia', '$descripcion', '$cantidad_existente', '$Nit', '$unidad_medida')";
    if ($conn->query($sqlUniforme) === TRUE) {
            // Si los datos se insertan correctamente, redirigir a home.php
            header("Location: home.php?id=$usuario");
            $conn->close();
            exit(); // Asegura que el código se detenga aquí para la redirección
        } else {
        echo "Error al insertar datos del cliente: " . $conn->error;
    }
}
