<?php
session_start();

// Configuración de la base de datos en XAMPP
$servername = "localhost"; // El servidor de la base de datos en XAMPP
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // Contraseña por defecto en XAMPP (en blanco)
$dbname = "proyectobd"; // Nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario_vendedor'];
    $contraseña = $_POST['contraseña_vendedor'];

    // Consulta SQL para verificar las credenciales del administrador
    $sql = "SELECT * FROM administradores WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso para el administrador
        $_SESSION['admin_usuario'] = $usuario;
    
        // Guardar otros datos del usuario en la sesión si es necesario
        $_SESSION['admin_datos'] = $result->fetch_assoc(); // Guarda todos los datos del usuario
    
        header("Location: homevendedor.php?id='$usuario'"); // Redirigir al home del administrador
        exit();
    }
     else {
        // Aquí establecemos un mensaje de error directamente en la sesión
        $_SESSION['login_error'] = "Nombre de usuario o contraseña incorrectos.";

        // Redirigimos incluyendo el mensaje en la URL
        header("Location: index.php?error=1");
        exit();
    }
}


// Cerrar conexión
$conn->close();
?>
