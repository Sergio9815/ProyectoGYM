<?php
    if(isset($_GET['editarCon'])){
        $editar_id = $_GET['editarCon'];
        $consulta = "SELECT * FROM CONTACTO WHERE ID = '$editar_id'";
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

                    $whats = $fila['WHATSAPP'];
                    if(is_null($whats)){
                        $whats = "-";
                    }
                    
                    $face = $fila['FACEBOOK'];
                    if(is_null($face)){
                        $face = "-";
                    }

                    $ins = $fila['INSTAGRAM'];
                    if(is_null($ins)){
                        $ins = "-";
                    }

                    $correo = $fila['CORREO'];
                    if(is_null($correo)){
                        $correo = "-";
                    }

                    $telf = $fila['TEL_FAMILIAR'];
                    if(is_null($telf)){
                        $telf = "-";
                    }

                    $direc = $fila['DIRECCION'];
                    if(is_null($direc)){
                        $direc = "-";
                    }

                    $consulta2 = "SELECT * FROM INFO_CONTACTO WHERE ID_CLIENTE = '$editar_id'";
                    $ejecutar2 = sqlsrv_query($con, $consulta2);
                    $fila2 = sqlsrv_fetch_array($ejecutar2);        
                    $idRedes = $fila2['ID_SOCIAL'];
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
            
                <label class="titu">Whatsapp</label>
                <input type="text" name="whats" class="in" value="<?php echo $whats; ?>"><br/>
            
                <label class="titu">Facebook</label>
                <input type="text" name="face" class="in" value="<?php echo $face; ?>"><br/>
            
                <label class="titu">Instagram</label>
                <input type="text" name="insta" class="in" value="<?php echo $ins; ?>"><br/>
           
                <label class="titu">Correo</label>
                <input type="email" name="correo" class="in" value="<?php echo $correo; ?>"><br/>
            
                <label class="titu">Tel. familiar</label>
                <input type="text" name="familiar" class="in" value="<?php echo $telf; ?>"><br/>
            
                <label class="titu">Dirección</label>
                <input type="text" name="dir" class="in" value="<?php echo $direc; ?>"><br/>
            
                <input id="update" type="submit" name="actualizar" class="btnReg" value="Actualizar datos"><br/><br/>
            </div>
        </form>
</div>


<?php
    if(isset($_POST['actualizar'])){
        $actualizar_whats = $_POST['whats'];
        $actualizar_face = $_POST['face'];
        $actualizar_insta = $_POST['insta'];
        $actualizar_correo = $_POST['correo'];
        $actualizar_familiar = $_POST['familiar'];
        $actualizar_dir = $_POST['dir'];

        $consulta = "UPDATE REDES SET WHATSAPP = '$actualizar_whats', FACEBOOK = '$actualizar_face', 
        INSTAGRAM = '$actualizar_insta', CORREO = '$actualizar_correo' 
        WHERE ID_REDES = '$idRedes'";

        $ejecutar = sqlsrv_query($con, $consulta);

        if($ejecutar){
            echo "<script> alert('Datos actualizados')</script>";
            echo "<script> window.open('contacto.php', '_self')</script>";
        }

    }
?>