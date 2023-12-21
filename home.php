<?php
    // Tu código PHP para consultar la base de datos y mostrar los datos aquí
    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "proyectobd"; // Reemplaza con el nombre de tu base de datos

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    $usuario = $_GET['id'];
    $actualizar_estado = "UPDATE factura SET Estado = 'Entregado' WHERE Monto < 0";
    $conn->query($actualizar_estado);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" 
    rel="stylesheet"/>    
    <link rel="stylesheet" href="assets\css\estilohome.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="contenedor">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="assets\images\UniClothesLogo.png" >
                    <h2>Uni<span class="danger">Clothes</span></h2>
                </div>
                <div class="close" id="close-btn">
                    <span class="material-symbols-outlined">close</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="#" class="active" >
                    <span class="material-symbols-outlined">grid_view</span>
                    <h3>Menu</h3>
                </a>
                <a href="#"  title = "Clientes">
                    <span class="material-symbols-outlined">person</span>
                    <h3>Clientes</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">orders</span>
                    <h3>Pedidos</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">receipt_long</span>
                    <h3>Facturas</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">school</span>
                    <h3>Colegios</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">apparel</span>
                    <h3>Uniformes</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">inventory</span>
                    <h3>Inventario</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">cut</span>
                    <h3>Materia Prima</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">conveyor_belt</span>
                    <h3>Proveedores</h3>
                </a>
                <a href="#" >
                    <span class="material-symbols-outlined">settings</span>
                    <h3>Ajustes</h3>
                </a>
                <a id="logout" href="index.php">
                    <span class="material-symbols-outlined">logout</span>
                    <h3>Logout</h3>
                </a>
            </div>
        </aside>
        <main>
            <h1 id="Titulo-pagina">Menu</h1>
            <div class="contenedor__menu">
                <h2>Realizar <span class="danger">Consulta</span></h2>
                <form method="post" action=
                <?php 
                echo"home.php?id=$usuario" 
                ?>
                >
                    <div class="contenedor__menu__textarea">
                        <textarea name="consulta" id="" cols="30" rows="10"></textarea>
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type="submit">Consultar</button>
                    </div>
                </form>
                <div class="contenedor__menu__tablas">
                    <h2>Tablas <span class="danger">Consulta</span></h2>
                    <div class="contenedor__menu__tablas1">
                    <?php
                        // Aquí va tu código de conexión a la base de datos
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST['consulta'])) {
                                $user_query = $_POST['consulta']; // Obtener la consulta del textarea
                        
                                // Verificar si es una consulta SELECT
                                if (stripos($user_query, 'SELECT') !== false) {
                                    // Ejecutar la consulta en la base de datos
                                    $result = $conn->query($user_query);
                        
                                    if ($result !== false && $result->num_rows > 0) {
                                        // Mostrar los resultados en la tabla HTML
                                        echo '<table id="tabla__consulta" class="table-striped table-condensed">';
                                        echo '<thead><tr>';
                        
                                        // Mostrar encabezados de la tabla
                                        $shownColumns = array(); // Array para almacenar las columnas mostradas
                        
                                        while ($fieldinfo = $result->fetch_field()) {
                                            // Verificar si la columna ya ha sido mostrada previamente
                                            if (!in_array($fieldinfo->name, $shownColumns)) {
                                                echo '<th>' . $fieldinfo->name . '</th>';
                                                $shownColumns[] = $fieldinfo->name; // Agregar la columna al array de columnas mostradas
                                            }
                                        }
                                        echo '</tr></thead><tbody>';
                        
                                        // Mostrar los datos
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            foreach ($row as $value) {
                                                echo '<td>' . $value . '</td>';
                                            }
                                            echo '</tr>';
                                        }
                        
                                        echo '</tbody></table>';
                                    } elseif ($result === false) {
                                        // En caso de error en la consulta SELECT
                                        echo "Error en la consulta: " . $conn->error;
                                    } else {
                                        // Si no se encontraron resultados
                                        echo "No se encontraron resultados.";
                                    }
                                } else {
                                    // Si es una consulta de modificación (INSERT, UPDATE, DELETE)
                                    if ($conn->query($user_query) === TRUE) {
                                        echo "<h1>Operación realizada con éxito</h1>";
                                    } else {
                                        echo "<h1>Error al ejecutar la operación: </h1>" . $conn->error;
                                    }
                                }
                            }
                        } else {
                            // Si no se envía una consulta o si la solicitud no es un POST
                            echo '<table id="tabla__consulta" class="table-striped table-condensed">';
                            echo '<thead><tr>';
                            echo '</tr></thead><tbody>';
                            echo '</tbody></table>';
                        }
                        
                        ?>

                    </div>
                </div>
            </div>
            <div class="contenedor__clientes">
                <h2>Registrar <span class="danger">Clientes</span></h2>
                <div class="contenedor__clientes__formulario">
                    <form action="procesar.php" method="post" class="formulario__clientes">
                        <input type="text" name = "identificacion_c" placeholder="Identificacion">
                        <input type="Text" name = "nombre_c" placeholder="Nombre">
                        <input type="Text" name = "telefono1" placeholder="Telefono 1">
                        <input type="Text" name = "telefono2" placeholder="Telefono 2">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type ="submit">Registrar</button>
                    </form>
                </div>
                <div class="contenedor__clientes__tablas">
                    <div class="contenedor_clientes__tabla1">
                        <h2>Nombre <span class="danger">Clientes</span></h2>
                        <table id="tabla__clientes__nombres">
                            <thead>
                                <tr>
                                    <th>Identificacion</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Documento, Nombre FROM Clientes";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Documento'] . "</td><td>" . $row['Nombre'] . "</td></tr>";
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="contenedor_clientes__tabla2">
                        <h2>Numero <span class="danger">Clientes</span></h2>
                        <table id="tabla__clientes__numeros">
                            <thead>
                                <tr>
                                    <th>Identificacion</th>
                                    <th>Telefono</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            // Consulta SQL para obtener datos de clientes
                            $sql = "SELECT Documento, Telefono FROM Telefono_Cliente";
                            $result = $conn->query($sql);

                            // Mostrar datos en la tabla
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row['Documento'] . "</td><td>" . $row['Telefono'] . "</td></tr>";
                                }
                            } 
                        
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="pedidoContenedor" class="contenedor__pedidos">
                <h2>Registrar <span class="danger">Pedidos</span></h2>
                <div class="contenedor__pedidos__registro">
                    <button id="nuevoPedidoBoton">Nuevo Pedido</button>
                    <form method="post" action="procesar_pedido.php">
                        <div id="pedidoid" class="pedido"> 
                            <div class="pedidoRellenar">
                                <input type="text" name ="identificacion" id="identificacionCliente" placeholder="Identificacion Cliente">
                                <input type="text" name ="abono" id="abono" placeholder="Abono">
                                <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                                <button type = "submit" id="confirmarPedido">Confirmar Pedido</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="contenedor__pedidos__tablas">
                    <div class="contenedor_pedidos__tabla1">
                        <h2>Lista <span class="danger">Pedidos</span></h2>
                        <table id="tabla__pedidos">
                            <thead>
                                <tr>
                                    <th>Numero de Pedido</th>
                                    <th>Fecha de Encargo</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Abono</th>
                                    <th>Identificacion Cliente</th>
                                    <th>Numero de Factura</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT numero_pedido, Fecha_Encargo, Fecha_Entrega, Abono, Di_Cliente1, Num_Factura1 FROM Pedido";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['numero_pedido'] . "</td><td>" . $row['Fecha_Encargo'] . "</td><td>" . $row['Fecha_Entrega'] . "</td><td>" . $row['Abono'] . "</td><td>" . $row['Di_Cliente1'] . "</td><td>" . $row['Num_Factura1'] . "</td></tr>";
                                    }
                                } 
                            
                                ?> 
                            </tbody>
                        </table>
                    </div>
                    <div class="contenedor_pedidos__tabla2">
                        <h2>Detalles <span class="danger">Pedidos</span></h2>
                        <table id="tabla__pedidos__detalles">
                            <thead>
                                <tr>
                                    <th>Numero de Pedido</th>
                                    <th>Articulo</th>
                                    <th>Medidas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Numero_Pedido, Articulo, Medidas FROM Detalle_Pedido";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Numero_Pedido'] . "</td><td>" . $row['Articulo'] . "</td><td>" . $row['Medidas'] . "</td></tr>";
                                    }
                                } 
                
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="contenedor__facturas">                
                <div class="contenedor__facturas__tablas">
                    <div class="contenedor_facturas__tabla1">
                        <h2>Lista <span class="danger">Facturas</span></h2>
                        <table id="tabla__facturas">
                            <thead>
                                <tr>
                                    <th>Numero de Factura</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Numero_Factura, Monto, Estado FROM Factura";
                                $result = $conn->query($sql);
        
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Numero_Factura'] . "</td><td>$" . $row['Monto'] . " COP</td><td>" . $row['Estado'] . "</td></tr>";
                                        
                                    }
                                } 
                            
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contenedor__colegios">
                <h2>Registrar <span class="danger">Colegios</span></h2>
                <div class="contenedor__colegios__formulario">
                    <form action="procesar_colegio.php" method="post" class="formulario__colegios">
                        <input type="text" name = "identificacion_colegio" placeholder="Identificacion">
                        <input type="Text" name = "nombre" placeholder="Nombre">
                        <input type="Text" name = "direccion" placeholder="Dirección">
                        <input type="Text" name = "telefono1" placeholder="Telefono 1">
                        <input type="Text" name = "telefono2" placeholder="Telefono 2">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type="submit">Registrar</button>
                    </form>
                </div>
                <div class="contenedor__colegios__tablas">
                    <div class="contenedor_colegios__tabla1">
                        <h2>Datos <span class="danger">Colegios</span></h2>
                        <table id="tabla__colegios__datos">
                            <thead>
                                <tr>
                                    <th>Identificacion</th>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Id_Colegio, Nombre, Direccion FROM Colegio";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Id_Colegio'] . "</td><td>" . $row['Nombre'] . "</td><td>" . $row['Direccion'] . "</td></tr>";
                                        
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="contenedor_colegios__tabla2">
                        <h2>Numeros <span class="danger">Colegios</span></h2>
                        <table id="tabla__colegios__numeros">
                            <thead>
                                <tr>
                                    <th>Identificacion</th>
                                    <th>Telefono</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Id_Colegio, Telefono FROM Telefono_Colegio";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Id_Colegio'] . "</td><td>" . $row['Telefono'] . "</td></tr>";
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contenedor__uniformes">
                <h2>Registrar <span class="danger">Uniformes</span></h2>
                <div class="contenedor__uniformes__formulario">
                    <form action="procesar_uniforme.php" method="post" class="formulario__colegios">
                        <input type="text" name ="id_uniforme" placeholder="ID Uniforme">
                        <input type="Text" name ="tipo_uniforme" placeholder="Tipo Uniforme">
                        <input type="Text" name = "color" placeholder="Color">
                        <input type="Text" name = "tipo_tela" placeholder="Tipo de Tela">
                        <input type="Text" name = "id_colegio" placeholder="ID Colegio">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type="submit">Registrar</button>
                    </form>
                </div>
                <div class="contenedor__uniformes__tablas">
                    <div class="contenedor_uniformes__tabla1">
                        <h2>Datos <span class="danger">Uniformes</span></h2>
                        <table id="tabla__uniformes__datos">
                            <thead>
                                <tr>
                                    <th>ID Uniforme</th>
                                    <th>Tipo Uniforme</th>
                                    <th>Color</th>
                                    <th>Tipo Tela</th>
                                    <th>ID Colegio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Id_Uniforme, Tipo_Uniforme, Color, Tipo_Tela, Id_Colegio FROM `uniforme`";
                                $result = $conn->query($sql);
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Id_Uniforme'] . "</td><td>" . $row['Tipo_Uniforme'] . "</td><td>" . $row['Color'] . "</td><td>" . $row['Tipo_Tela']. "</td><td>" . $row['Id_Colegio']  . "</td></tr>";
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contenedor__producto__terminado">
                <h2>Registrar <span class="danger">Producto</span></h2>
                <div class="contenedor__producto__terminado__formulario">
                    <form action="procesar_invetario.php" method="post" class="formulario__producto__terminado">
                        <input type="text" name="codigo_producto" placeholder="Codigo Producto">
                        <input type="Text" name="descripcion" placeholder="Descripcion">
                        <input type="Text" name="talla" placeholder="Talla">
                        <input type="Text" name="sexo" placeholder="Sexo">
                        <input type="Text" name="precio_venta" placeholder="Precio Venta"> 
                        <input type="Text" name="cantidad_existencia" placeholder="Cantidad Existencia">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type = "submit">Registrar</button>
                    </form>
                </div>
                <div class="contenedor__producto__terminado__tablas">
                    <div class="contenedor_producto__terminado__tabla1">
                        <h2>Datos <span class="danger">Productos</span></h2>
                        <table id="tabla__producto__terminado__datos">
                            <thead>
                                <tr>
                                    <th>Codigo Producto</th>
                                    <th>Descripcion</th>
                                    <th>Talla</th>
                                    <th>Sexo</th>
                                    <th>Precio Venta</th>
                                    <th>Cantidad Existencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Codigo_Producto, Descripcion, Talla, Sexo, Precio_Venta, Cantidad_Existencia FROM `Producto_Terminado`";
                                $result = $conn->query($sql);
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Codigo_Producto'] . "</td><td>" . $row['Descripcion'] . "</td><td>" . $row['Talla'] . "</td><td>" . $row['Sexo']. "</td><td>" . $row['Precio_Venta']  . "</td><td>" . $row['Cantidad_Existencia']  . "</td></tr>";
    
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contenedor__materia__prima">
                <h2>Registrar <span class="danger">Materia Prima</span></h2>
                <div class="contenedor__materia__prima__formulario">
                    <form action="procesar_materia.php" method="post" class="formulario__materia__prima">
                        <input type="text" name = "codigo_materia" placeholder="Codigo Materia">
                        <input type="Text" name = "tipo_materia" placeholder="Tipo Materia">
                        <input type="Text" name = "descripcion" placeholder="Descripción">
                        <input type="Text" name = "cantidad_existente" placeholder="Cantidad Existente">
                        <input type="Text" name = "unidad_medida" placeholder="Unidad Medida">
                        <input type="Text" name = "Nit" placeholder="Nit Proveedor">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type= "submit">Registrar</button>
                    </form>
                </div>
                <div class="contenedor__materia__prima__tablas">
                    <div class="contenedor_materia__prima__tabla1">
                        <h2>Datos <span class="danger">Materia Prima</span></h2>
                        <table id="tabla__materia__prima__datos">
                            <thead>
                                <tr>
                                    <th>Codigo Materia</th>
                                    <th>Tipo Materia</th>
                                    <th>Descripcion</th>
                                    <th>Cantidad Existente</th>
                                    <th>Nit Proveedor</th>
                                    <th>Unidad de Medida</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT Codigo_Materia, Tipo_Materia, Descripcion, Cantidad_Existente, NIT_Proveedor, Unidad_Medida FROM `materia_prima`";
                                $result = $conn->query($sql);
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['Codigo_Materia'] . "</td><td>" . $row['Tipo_Materia'] . "</td><td>" . $row['Descripcion'] . "</td><td>" . $row['Cantidad_Existente']. "</td><td>".$row['NIT_Proveedor'] ."</td><td>". $row['Unidad_Medida']. "</td></tr>";
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contenedor__proveedores">
                <h2>Registrar <span class="danger">Proveedor</span></h2>
                <div class="contenedor__proveedores__formulario">
                    <form action="procesar_proveedor.php" method="post" class="formulario__proveedores">
                        <input type="text" name="nit" placeholder="Nit Proveedor">
                        <input type="Text" name="nombre" placeholder="Nombre">
                        <input type="Text" name="contacto" placeholder="Nombre Contacto">
                        <input type="Text" name="direccion" placeholder="Direccion">
                        <input type="Text" name="telefono1" placeholder="Telefono 1">
                        <input type="Text" name="telefono2" placeholder="Telefono 2">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type="submit">Registrar</button>
                    </form>
                </div>
                <div class="contenedor__proveedores__tablas">
                    <div class="contenedor_proveedores__tabla1">
                        <h2>Datos <span class="danger">Proveedor</span></h2>
                        <table id="tabla__proveedores__datos">
                            <thead>
                                <tr>
                                    <th>Nit Proveedor</th>
                                    <th>Nombre</th>
                                    <th>Nombre Contacto</th>
                                    <th>Direccion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT NIT, Nombre, Nombre_Contacto, Direccion FROM Proveedor";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['NIT'] . "</td><td>" . $row['Nombre'] . "</td><td>" . $row['Nombre_Contacto'] . "</td><td>". $row['Direccion'] . "</td></tr>";
                                        
                                    }
                                } 
                            
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="contenedor_proveedores__tabla2">
                        <h2>Telefono <span class="danger">Proveedor</span></h2>
                        <table id="tabla__proveedores__numeros">
                            <thead>
                                <tr>
                                    <th>Nit Proveedor</th>
                                    <th>Telefono</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT NIT, Telefono FROM Telefono_Proveedor";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['NIT'] . "</td><td>" . $row['Telefono'] . "</td></tr>";
                                    }
                                } 
    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="contenedor__ajustes__usuario">
                <h2>Registrar <span class="danger">Usuario</span></h2>
                <div class="contenedor__ajustes__usuario__formulario">
                    <form action="procesar_usuarios.php" method="post" class="formulario__ajustes__usuario">
                        <input type="text" name="identificacion" placeholder="Identificacion">
                        <input type="password" name="contraseña" placeholder="Contraseña">
                        <input type="Text" name="nombre" placeholder="Nombre">
                        <input type="Text" name="apellido" placeholder="Apellido">
                        <input type="Text" name="direccion" placeholder="Direccion">
                        <input type="Text" name="telefono" placeholder="Telefono"> 
                        <input type="Text" name="rol" placeholder="Rol">  
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button type="submit">Registrar</button>
                    </form>
                </div>
                <h2>Eliminar <span class="danger">Usuario</span></h2>
                <div class="contenedor__eliminar__usuario__formulario">
                    <form action="eliminar_usuario.php" method="post" class="formulario__eliminar__usuario">
                        <input type="text" name="identificacion" placeholder="Identificacion">  
                        <input type="password" name="contraseña" placeholder="Contraseña">
                        <input type="hidden" name="usuario_enviado" value="<?php echo $_GET['id'];?>">
                        <button>Eliminar</button>
                    </form>
                </div>
                <div class="contenedor__ajustes__usuario__tablas">
                    <div class="contenedor_ajustes__usuario__tabla1">
                        <h2>Datos <span class="danger">Usuario</span></h2>
                        <table id="tabla__ajustes__usuario__datos">
                            <thead>
                                <tr>
                                    <th>Identificacion</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Direccion</th>
                                    <th>Telefono</th>
                                    <th>Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Consulta SQL para obtener datos de clientes
                                $sql = "SELECT usuario, nombre, apellido, direccion, telefono, rol  FROM administradores";
                                $result = $conn->query($sql);
    
                                // Mostrar datos en la tabla
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row['usuario'] . "</td><td>" . $row['nombre'] . "</td><td>" . $row['apellido'] . "</td><td>" . $row['direccion'] . "</td><td>" . $row['telefono'] . "</td><td>" . $row['rol'] . "</td></tr>";
                                    }
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <div class="derecha">
            <div class="top">
                <h2>ADMINISTRADOR</h2>
                <img src="assets\images\admin_imagen.png" alt="">
            </div>
            <?php
            $id = $_GET['id'];
            // Consulta SQL para obtener datos del usuario específico
            $sql = "SELECT usuario, nombre, apellido, direccion, telefono, rol FROM administradores WHERE usuario = $id";
            $result = $conn->query($sql);
            
            // Mostrar datos del usuario
            if ($result->num_rows > 0) {
                // Mostrar la información del usuario
                $row = $result->fetch_assoc(); ?>

                <div class="informacion__usuario">
                    <h2>Informacion <span class="danger">Usuario</span></h2>
                    <h3>Identificacion: <?php echo $row['usuario']; ?></h3>
                    <h3>Nombre: <?php echo $row['nombre']; ?></h3>
                    <h3>Apellido: <?php echo $row['apellido']; ?></h3>
                    <h3>Direccion: <?php echo $row['direccion']; ?></h3>
                    <h3>Telefono: <?php echo $row['telefono']; ?></h3>
                    <h3>Rol: <?php echo $row['rol']; ?></h3>
                </div>
                <?php
                } 
                ?>
            <div class="tiempo__activo">
                <h2>Tiempo <span class="danger">Activo</span></h2>
                <p id="counter">00:00:00</p>
            </div>
        </div>
    </div>
    <script src="assets\js\scripthome.js"></script>
     <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
        </script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script> 
    <script src="assets\js\dataTableConfig.js"></script>
</body>
</html>