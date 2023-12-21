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
$identificacion = $_POST['identificacion_colegio'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono1 = $_POST['telefono1'];
$telefono2 = $_POST['telefono2'];
$usuario = $_POST['usuario_enviado'];

$verificarUsuario = "SELECT Id_Colegio FROM colegio WHERE Id_Colegio = '$identificacion'";
$resultado = $conn->query($verificarUsuario);

if ($resultado->num_rows > 0) {
    // Si el usuario ya existe, mostrar un mensaje o tomar la acción correspondiente
    echo "El usuario ya existe en la base de datos.";
} else {
    // Insertar datos del cliente si no existe
    $sqlColegio = "INSERT INTO `colegio`(`Id_Colegio`, `Nombre`, `Direccion`) VALUES ('$identificacion','$nombre','$direccion')";
    if ($conn->query($sqlColegio) === TRUE) {
        // Insertar datos en la tabla telefono_cliente solo si el teléfono 2 no está vacío
        if (!empty($telefono2)) {
            $sqlTelefono = "INSERT INTO `telefono_colegio`(`Id_Colegio`, `Telefono`) VALUES ('$identificacion', '$telefono1'), ('$identificacion', '$telefono2')";
        } else {
            $sqlTelefono = "INSERT INTO `telefono_colegio`(`Id_Colegio`, `Telefono`) VALUES ('$identificacion','$telefono1')";
        }
        if ($conn->multi_query($sqlTelefono) === TRUE) {
            // Si los datos se insertan correctamente, redirigir a home.php
            header("Location: homevendedor.php?id=$usuario");
            $conn->close();
            exit(); // Asegura que el código se detenga aquí para la redirección
        } else {
            echo "Error al insertar números de teléfono: " . $conn->error;
        }
    } else {
        echo "Error al insertar datos del cliente: " . $conn->error;
    }
}
