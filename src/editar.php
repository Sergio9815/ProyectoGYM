<?php
    if(isset($_GET['editar'])){
        $editar_id = $_GET['editar'];
        $consulta = "SELECT * FROM CLIENTES_INSCRITOS WHERE ID = '$editar_id'";
        $ejecutar = sqlsrv_query($con, $consulta);
        $fila = sqlsrv_fetch_array($ejecutar);

        $id = $fila['ID'];
        if(is_null($id)){
            $id = "-";
        }

        $nombre = $fila['NOMBRE'];
        if(is_null($nombre)){
            $nombre = "-";
        }

        $apellido = $fila['APELLIDO'];
        if(is_null($apellido)){
            $apellido = "-";
        }

        $cedula = $fila['CEDULA'];
        if(is_null($cedula)){
            $cedula = "-";
        }

        if(is_null($fila['F_NACIMIENTO'])){
            $nacimiento = "-";
        }
        else{
            $fecha_na = $fila['F_NACIMIENTO'];
            $nacimiento = date_format($fecha_na, "d/m/Y");
        }
        /*
        if(is_null($fila['FECHA_INSCRIPCION'])){
            $inscripcion = "-";
        }
        else{
            $fecha_ins = $fila['FECHA_INSCRIPCION'];
            $inscripcion = date_format($fecha_ins, "d/m/Y");
        }
        */
        $plan = $fila['TIPO_DE_PLAN'];
        if(is_null($plan)){
            $plan = "-";
        }
    }
?>

<br/>

<div id="registro">
		<h5 id="crear2">ACTUALIZAR DATOS</h5>
        <form method="POST" action="" id="regis">
                <label class="titu">Nombre</label>
                <input type="text" name="nombre" class="in" value="<?php echo $nombre; ?>"><br/>
            
                <label class="titu">Apellido</label>
                <input type="text" name="apellido" class="in" value="<?php echo $apellido; ?>"><br/>
           
                <label class="titu">Cédula</label>
                <input type="text" name="cedula" class="in" value="<?php echo $cedula; ?>"><br/>
            
                <label class="titu">Fecha de nacimiento</label>
                <input type="date" name="f_nacimiento" class="date" value="<?php echo $nacimiento; ?>"><br/>
           
                <label class="titu">Plan</label>
                <input type="text" name="plan" class="in" value="<?php echo $plan; ?>"><br/>
            
                <input id="update" type="submit" name="actualizar" class="btnReg" value="Actualizar datos"><br/>
        </form>
</div>


<?php
    if(isset($_POST['actualizar'])){
        $actualizar_nom = $_POST['nombre'];
        $actualizar_ape = $_POST['apellido'];
        $actualizar_cedu = $_POST['cedula'];
        $actualizar_naci = $_POST['f_nacimiento'];
        //$actualizar_ins = $_POST['FECHA_INSCRIPCION'];
        $actualizar_plan = $_POST['plan'];

        $consulta = "UPDATE CLIENTES SET NOMBRE = '$actualizar_nom', APELLIDO = '$actualizar_ape', 
        CEDULA = '$actualizar_cedu', F_NACIMIENTO = '$actualizar_naci' 
        WHERE ID = '$editar_id'";

        $ejecutar = sqlsrv_query($con, $consulta);

        $consulta = "EXEC SP_ACTUALIZA_INSCRIP '$editar_id', '$actualizar_plan'";

        $ejecutar = sqlsrv_query($con, $consulta);

        if($ejecutar){
            echo "<script> alert('Datos actualizados')</script>";
            echo "<script> window.open('formulario.php', '_self')</script>";
        }

    }
?>