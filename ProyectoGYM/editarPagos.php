<?php
    if(isset($_GET['editarP'])){
        $editar_id = $_GET['editarP'];
        $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS WHERE ID = '$editar_id'";
        $ejecutar = sqlsrv_query($con, $consulta);
        $fila = sqlsrv_fetch_array($ejecutar);        
                    $cod = $fila['ID'];
                    if(is_null($cod)){
                        $cod = "-";
                    }

                    $nom = $fila['NOMBRE'];
                    if(is_null($nom)){
                        $nom = "-";
                    }

                    $ape = $fila['APELLIDO'];
                    if(is_null($ape)){
                        $ape = "-";
                    }

                    $cedu = $fila['CEDULA'];
                    if(is_null($cedu)){
                        $cedu = "-";
                    }

                    $saldo = $fila['SALDO'];
                    if(is_null($saldo)){
                        $saldo = 0;
                    }
                    
                    if(is_null($fila['FECHA'])){
                        $fecha = "-";
                    }
                    else{
                        $fecha_pa = $fila['FECHA'];
                        $fecha = date_format($fecha_pa, "d/m/Y");
                    }

                    $deta = $fila['DETALLES'];
                    if(is_null($deta)){
                        $deta = "-";
                    }

                    $consulta2 = "SELECT * FROM INSCRIPCIONES WHERE ID_CLIENTE = '$editar_id'";
                    $ejecutar2 = sqlsrv_query($con, $consulta2);
                    $fila2 = sqlsrv_fetch_array($ejecutar2);        
                    $$cod = $fila2['NRO_INSCRIPCION'];
    }
?>

<br/>

<div id="registro">
		<h5 id="crear2">ACTUALIZAR DATOS</h5>
        <form method="POST" action="" id="regis">
                <label class="titu">Nombre</label>
                <input type="text" name="nombre" class="in" readonly value="<?php echo $nom." ".$ape; ?>"><br/>
            
                <label class="titu">Cédula</label>
                <input type="text" name="cedula" class="in" readonly value="<?php echo $cedu; ?>"><br/>
            
                <label class="titu">Monto pagado</label>
                <input type="number" name="saldo" class="in" value="<?php echo $saldo; ?>"><br/>
            
                <label class="titu">Fecha</label>
                <input type="date" name="fecha" class="date" value="<?php echo $fecha; ?>"><br/>
            
                <label class="titu">Detalles</label>
                <input type="text" name="detalle" class="in" value="<?php echo $deta; ?>"><br/>
            
                <input id="update" type="submit" name="actualizar" class="btnReg" value="Actualizar datos"><br/>
            </div>
        </form>
</div>


<?php
    if(isset($_POST['actualizar'])){
        $actualizar_saldo = $_POST['saldo'];
        $actualizar_fecha = $_POST['fecha'];
        $actualizar_detalles = $_POST['detalle'];

        $consulta = "UPDATE PAGO SET SALDO = '$actualizar_saldo', FECHA = '$actualizar_fecha', 
        DETALLES = '$actualizar_detalles' WHERE COD_INSCRIPCION = '$cod'";

        $ejecutar = sqlsrv_query($con, $consulta);

        if($ejecutar){
            echo "<script> alert('Datos actualizados')</script>";
            echo "<script> window.open('historialPagos.php', '_self')</script>";
        }

    }
?>