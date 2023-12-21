    <?php
    // Establecer conexión a la base de datos (debes completar esta parte con tus credenciales)
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

    // Obtener datos del formulario
    $identificacion = $_POST['identificacion'];
    $abono = $_POST['abono'];
    $usuario = $_POST['usuario_enviado'];
    $articulo = $_POST['articulo'];
    $ancho = $_POST['ancho'];
    $largo = $_POST['largo'];


    // Verificar si el número de factura ya está en uso
    $sql_check_invoice = "SELECT Numero_Factura FROM Factura WHERE Numero_Factura = '$identificacion'";
    $result_check_invoice = $conn->query($sql_check_invoice);

    if ($result_check_invoice->num_rows > 0) {
        if (empty($articulo) || empty($ancho) || empty($largo)) {
            // Si faltan campos del pedido, actualiza el monto en la factura con el valor del abono
            $sql_actualizar_factura = "UPDATE Factura SET Monto = Monto - '$abono' WHERE Numero_Factura = '$identificacion'";
    
            if ($conn->query($sql_actualizar_factura) === TRUE) {
                header("Location: home.php?id=$usuario");
                $conn->close();
                exit();
                // Aquí puedes redirigir o mostrar un mensaje de éxito al usuario
            } else {
                echo "Error al actualizar la factura: " . $conn->error;
            }
        }
        else{
            echo "Error al actualizar la factura: " . $conn->error;
        }
        // Si el número de factura ya existe, agregar un nuevo detalle de pedido a esa factura
        $fecha_encargo = date("Y-m-d");
        // Aquí podrías generar la fecha de entrega según tu lógica
        $fecha_entrega = date("Y-m-d", strtotime("+1 week")); // Ejemplo: entrega en una semana

        $sql_obtener_numero_pedido = "SELECT numero_pedido FROM pedido WHERE Num_Factura1 = '$identificacion'";
        $result_numero_pedido = $conn->query($sql_obtener_numero_pedido);

        if ($result_numero_pedido->num_rows > 0) {
            $row = $result_numero_pedido->fetch_assoc();
            $numero_pedido_existente = $row['numero_pedido'];

            // Insertar detalles del pedido en el pedido existente
            $sql_detalle_pedido = "INSERT INTO Detalle_Pedido (numero_pedido, Articulo, Medidas) 
                                VALUES ('$numero_pedido_existente', '$articulo', '$ancho x $largo')";

            if ($conn->query($sql_detalle_pedido) === TRUE) {
                // Obtener el código del producto basado en el nombre del artículo
                $sql_obtener_codigo = "SELECT Codigo_Producto FROM producto_terminado WHERE Descripcion = '$articulo'";
                $result_codigo = $conn->query($sql_obtener_codigo);
                
                if ($result_codigo->num_rows > 0) {
                    $row = $result_codigo->fetch_assoc();
                    $codigo_producto = $row['Codigo_Producto'];

                    // Reducir la cantidad existente del producto vendido en la tabla producto_terminado
                    $sql_actualizar_existencia = "UPDATE producto_terminado SET Cantidad_Existencia = Cantidad_Existencia - 1 WHERE Codigo_Producto = '$codigo_producto'";
                    $sql_update_monto = "UPDATE Factura
                    SET Monto = (
                    SELECT SUM(producto_terminado.Precio_Venta) AS Monto_Total
                        FROM Factura
                        INNER JOIN pedido ON Factura.Numero_Factura = pedido.Num_Factura1
                        INNER JOIN Detalle_Pedido ON pedido.numero_pedido = Detalle_Pedido.numero_pedido
                        INNER JOIN producto_terminado ON Detalle_Pedido.Articulo = producto_terminado.Descripcion
                        WHERE Factura.Numero_Factura = $identificacion AND detalle_pedido.Articulo = producto_terminado.Descripcion
                    ) - (Select pedido.abono from pedido where pedido.Num_Factura1 = $identificacion)
                    WHERE Numero_Factura = $identificacion ";
                    $conn->query($sql_update_monto);  
                    $sql_verificar_monto_cero = "SELECT Monto FROM Factura WHERE Numero_Factura = '$identificacion'";
                    $result_verificar_monto_cero = $conn->query($sql_verificar_monto_cero);

                    if ($result_verificar_monto_cero->num_rows > 0) {
                        $row = $result_verificar_monto_cero->fetch_assoc();
                        $monto_actualizado = $row['Monto'];

                        if ($monto_actualizado == 0) {
                            // Si el monto es cero, actualiza el estado de la factura a "Entregado"
                            $sql_actualizar_estado = "UPDATE Factura SET Estado = 'Entregado' WHERE Numero_Factura = '$identificacion'";
                            $conn->query($sql_actualizar_estado);
                        }
                    }

                    $sql_actualizar_abono = "UPDATE pedido SET Abono = Abono + '$abono' WHERE numero_pedido = $identificacion";
                    $conn->query($sql_actualizar_abono);
                    
                    if ($conn->query($sql_actualizar_existencia) === TRUE) {
                        header("Location: home.php?id=$usuario");
                        $conn->close();
                        exit();
                        // Aquí puedes redirigir o mostrar un mensaje de éxito al usuario
                    } else {
                        echo "Error al actualizar la cantidad existente del producto: " . $conn->error;
                    }
                } else {
                    echo "No se encontró el código del producto para el artículo: " . $articulo;
                }
                
            } else {
                echo "Error al insertar el detalle del pedido: " . $conn->error;
            }
        } else {
            echo "No se encontró el número de pedido asociado a la factura: " . $identificacion;
        }
    }
    else{
    $sql_create_invoice = "INSERT INTO Factura (Numero_Factura, Monto, Estado) VALUES ('$identificacion', 0, 'Encargado')";
    
    if ($conn->query($sql_create_invoice) === TRUE) {
        // Continuar con la creación del nuevo pedido
        $fecha_encargo = date("Y-m-d");
        // Aquí podrías generar la fecha de entrega según tu lógica
        $fecha_entrega = date("Y-m-d", strtotime("+1 week")); // Ejemplo: entrega en una semana

        $sql_nuevo_pedido = "INSERT INTO `pedido` (`numero_pedido`, `Fecha_Encargo`, `Fecha_Entrega`, `Abono`, `Di_Cliente1`, `Num_Factura1`) VALUES ($identificacion, '$fecha_encargo', '$fecha_entrega', '$abono', '$identificacion', '$identificacion')";

        if ($conn->query($sql_nuevo_pedido) === TRUE) {
            $numero_pedido = $conn->insert_id; // Obtener el número de pedido generado

            // Aquí podrías obtener los datos del detalle del pedido (artículo, medidas, etc.)

            // Insertar detalles del pedido
            $sql_detalle_pedido = "INSERT INTO Detalle_Pedido (numero_pedido, Articulo, Medidas) 
                                VALUES ('$identificacion', '$articulo', '$ancho x $largo')";

            if ($conn->query($sql_detalle_pedido) === TRUE) {
                // Actualizar la tabla Factura con el abono reducido
                $sql_actualizar_factura = "UPDATE Factura SET Monto = Monto - '$abono' WHERE Numero_Factura = '$identificacion'";

                if ($conn->query($sql_actualizar_factura) === TRUE) {
                    // Obtener el código del producto basado en el nombre del artículo
                    $sql_obtener_codigo = "SELECT Codigo_Producto FROM producto_terminado WHERE Descripcion = '$articulo'";
                    $result_codigo = $conn->query($sql_obtener_codigo);
                        
                    if ($result_codigo->num_rows > 0) {
                        $row = $result_codigo->fetch_assoc();
                        $codigo_producto = $row['Codigo_Producto'];
                
                        // Reducir la cantidad existente del producto vendido en la tabla producto_terminado
                        $sql_actualizar_existencia = "UPDATE producto_terminado SET Cantidad_Existencia = Cantidad_Existencia - 1 WHERE Codigo_Producto = '$codigo_producto'";
                        
                        if ($conn->query($sql_actualizar_existencia) === TRUE) {
                            $sql_update_monto = "UPDATE Factura
                    SET Monto = (
                    SELECT SUM(producto_terminado.Precio_Venta) AS Monto_Total
                        FROM Factura
                        INNER JOIN pedido ON Factura.Numero_Factura = pedido.Num_Factura1
                        INNER JOIN Detalle_Pedido ON pedido.numero_pedido = Detalle_Pedido.numero_pedido
                        INNER JOIN producto_terminado ON Detalle_Pedido.Articulo = producto_terminado.Descripcion
                        WHERE Factura.Numero_Factura = $identificacion AND detalle_pedido.Articulo = producto_terminado.Descripcion
                    )
                    WHERE Numero_Factura = $identificacion ";
                    $conn->query($sql_update_monto);  
                            header("Location: home.php?id=$usuario");
                            $conn->close();
                            exit();
                            // Aquí puedes redirigir o mostrar un mensaje de éxito al usuario
                        } else {
                            echo "Error al actualizar la cantidad existente del producto: " . $conn->error;
                        }
                    } else {
                        echo "No se encontró el código del producto para el artículo: " . $articulo;
                    }
                } else {
                    echo "Error al actualizar la factura: " . $conn->error;
                }
            } else {
                echo "Error al insertar el detalle del pedido: " . $conn->error;
            }
        } else {
            echo "Error al crear el nuevo pedido: " . $conn->error;
        }
    } else {
        echo "Error al crear la nueva factura: " . $conn->error;
    }
      // Actualizar la tabla Factura con el abono reducido
    }
    // Actualizar la tabla Factura con el abono reducido
    
    

    $conn->close();
    ?>
