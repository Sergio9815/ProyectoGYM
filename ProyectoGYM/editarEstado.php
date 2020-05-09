<?php
    if(isset($_GET['editarEs'])){
        $editar_id = $_GET['editarEs'];
        $consulta = "SELECT * FROM ESTADO_CLIENTES WHERE ID = '$editar_id'";
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
        
        $estatura = $fila['ESTATURA'];
        if((is_null($estatura)) or ($estatura < 1)){
            $estatura = "-";
        }

        $pesoIni = $fila['PESO_INICIAL'];
        if((is_null($pesoIni)) or ($pesoIni < 1)){
            $pesoIni = "-";
        }

        $pesoFin = $fila['PESO_ACTUAL'];
        if((is_null($pesoFin)) or ($pesoFin < 1)){
            $pesoFin = "-";
        }

        $lesion = $fila['NOMBRE_LESION'];
        if(is_null($lesion)){
            $lesion = "-";
        }

        if(is_null($fila['DIA'])){
            $dia = "-";
        }
        else{
            $fecha_i = $fila['DIA'];
            $dia = date_format($fecha_i, "d/m/Y");
        }

        $desc = $fila['DESCRIPCION'];
        if(is_null($desc)){
            $desc = "-";
        }

        $consulta2 = "SELECT * FROM PERFILES WHERE ID_CLIENTE = '$editar_id'";
        $ejecutar2 = sqlsrv_query($con, $consulta2);
        $fila2 = sqlsrv_fetch_array($ejecutar2);        
        $id_per = $fila2['ID_PERFIL'];

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
            
                <label class="titu">Estatura</label>
                <input type="text" name="estatura" class="in" value="<?php echo $estatura; ?>"><br/>
            
                <label class="titu">Peso inicial</label>
                <input type="text" name="pesoinicial" class="in" value="<?php echo $pesoIni; ?>"><br/>
            
                <label class="titu">Peso actual</label>
                <input type="text" name="pesoactual" class="in" value="<?php echo $pesoFin; ?>"><br/>
            
                <label class="titu">Lesión</label>
                <input type="text" name="lesiones" class="in" value="<?php echo $lesion; ?>"><br/>
           
                <label class="titu">Fecha</label>
                <input type="date" name="f_lesion" class="in" value="<?php echo $dia; ?>"><br/>
           
                <label class="titu">Descripción</label>
                <input type="text" name="descripcion" class="in" value="<?php echo $desc; ?>"><br/>
            
                <input id="update" type="submit" name="actualizarEs" class="btnReg" value="Actualizar datos"><br/><br/>
            </div>
        </form>
</div>


<?php
    if(isset($_POST['actualizarEs'])){
        $actualizar_estatura = $_POST['estatura'];
        $actualizar_inicial = $_POST['pesoinicial'];
        $actualizar_actual = $_POST['pesoactual'];
        $actualizar_less = $_POST['lesiones'];
        $actualizar_dia = $_POST['f_lesion'];
        $actualizar_des = $_POST['descripcion'];
        
        $consulta = "UPDATE PERFILES SET ESTATURA = '$actualizar_estatura', PESO_INICIAL = '$actualizar_inicial', 
        PESO_ACTUAL = '$actualizar_actual' WHERE ID_CLIENTE = '$editar_id'";

        $ejecutar = sqlsrv_query($con, $consulta);

        $consulta = "UPDATE LESIONADOS SET NOMBRE_LESION = '$actualizar_less', DIA = '$actualizar_dia', 
        DESCRIPCION = '$actualizar_des' WHERE ID_PERF  = '$id_per'";

        $ejecutar = sqlsrv_query($con, $consulta);

        if($ejecutar){
            echo "<script> alert('Datos actualizados')</script>";
            echo "<script> window.open('estadoClientes.php', '_self')</script>";
        }

    }
?>