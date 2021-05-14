<?php
    if(isset($_GET['borrar'])){
        $editar_id = $_GET['borrar'];
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

                            $plan = $fila['TIPO_DE_PLAN'];
                            if(is_null($plan)){
                                $plan = "-";
                            }

    }
?>

<br/>

<div id="registro">
		<h5 id="crear2">ELIMINAR CLIENTE</h5>
        <form method="POST" action="" id="regis">
                <label class="titu">ID</label>
                <input type="text" name="id" class="in" value="<?php echo $id; ?>"><br/>

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
            
                <input id="delete" type="submit" name="del" class="btnReg2" value="Eliminar cliente"><br/>
        </form>
</div>

<?php
    if(isset($_POST['del'])){
        $borra= "DELETE FROM CLIENTES WHERE ID = '$editar_id'";
        $ejecutar = sqlsrv_query($con, $borra);
        
        if($ejecutar){
            echo "<script> alert('Cliente eliminado')</script>";
            echo "<script> window.open('formulario.php', '_self')</script>";
        }
    }
?>