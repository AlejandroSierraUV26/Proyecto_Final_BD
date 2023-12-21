<?php
session_start();

// Verificamos si hay un mensaje de error en la sesión
if (isset($_SESSION['login_error']) && $_GET['error'] == 1) {
    echo "<script>alert('".$_SESSION['login_error']."');</script>";
    unset($_SESSION['login_error']); // Limpiar el mensaje de error después de mostrarlo
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content="width-device-width, initial-scale =1.0">
    <title>Login</title>

    <link rel="stylesheet" href="assets\css\estilos.css">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-admin">
                    <h3>¿Eres administrador?</h3>
                    <p>Inicia sesión para entrar</p>
                    <button id="btn__iniciar-sesion_admin">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-vendedor">
                    <h3>¿Eres vendedor?</h3>
                    <p>Inicia sesión para entrar</p>
                    <button id="btn__iniciar-sesion_vendedor">Iniciar Sesión</button>
                </div>
            </div>
            <div class="contenedor__login">
                
            <form action="validarAdmin.php" method="post" class="formulario__login-admin">
                <h2>Iniciar Sesión Administrador</h2>
                <input type="text" name="usuario" placeholder="Usuario Administrador">
                <input type="password" name="contraseña" placeholder="Contraseña">
                <!-- Campo oculto para enviar el usuario -->
                <input type="hidden" name="usuario_enviado" value="usuario_que_envias_aqui">
                <input type="submit" value="Entrar">
            </form>


                <form action="validarVendedor.php" method="post" class="formulario__login-vendedor">
                    <h2>Iniciar Sesión Vendedor</h2>
                    <input type="text" name="usuario_vendedor" placeholder="Usuario Vendedor">
                    <input type="password" name="contraseña_vendedor" placeholder="Constraseña">
                    <input type="submit" value="Entrar">
                </form>
            </div>
        </div>
    </main>
    <script src="assets/js/script.js"></script>
</body>
</html>