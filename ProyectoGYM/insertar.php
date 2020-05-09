<!DOCTYPE html>
<meta charset="UTF-8">
<html>
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>N' FORMAS</title>
    <link href="css/style.css" rel="stylesheet"> 

    </head>
<body>
            <div id="barMenu">
                <nav id="menu">
                    <ul>
                        <li><a id="adm" href="formulario.php">ADMINISTRAR CLIENTES</a></li>
                    </ul>
                </nav>
            </div>
        
        <?php
            $serverName="DESKTOP-GLDD0PS\SQLEXPRESS";
            $connectionInfo = array("Database"=>"GYM");
            $con =sqlsrv_connect($serverName, $connectionInfo);
            /*if($con){
                echo "<script> alert('Conexion Exitosa')</script>";
            }else{
                echo "<script> alert('Conexion Fallida')</script>";
            }*/
        ?>

            <div id="registro">
                <br><br><br>
				<h5 id="crear">REGISTRAR CLIENTE</h5>
				<form id="regis" method="POST" action="">
                    
                    <label class="titu">Nombre</label>
                    <input type="text" class="in" name="nombre"/>
									  
					<label class="titu">Apellido</label>
					<input type="text" id="bdate" name="apellido" class="date2"/>
									   
					<label class="titu2" for="pais">Género</label>
    				   <select id="pais" name="sexo" tabindex="12" class="country">
    						<option value="M">MASCULINO</option>
    						<option value="F">FEMENINO</option>
    					</select>
									   
					<label class="titu">Cédula</label>
					<input type="text" class="in" name="cedula"/>
									   
					<label class="titu">Fecha de nacimiento</label>
					<input type="date" name="f_nacimiento" maxlength="255" class="in"/>
                
                    <!--
                        <label class="titu">Whatsapp / Teléfono</label>
                        <input type="text"  name="whats" class="date2"/>
                                        
                        <label class="titu2" for="plan">Plan</label>
                        <select id="plan" name="plan" tabindex="12" class="country">
                                <option value="P_D">DIARIO</option>
                                <option value="P_M">MENSUAL</option>
                            </select>

                        <label class="titu">Correo</label>
                        <input type="email" class="in" name="mail"/>
                        
                        <label class="titu">Instagram</label>
                        <input type="text" class="in" name="insta"/>
                                        
                        <label class="titu">Dirección</label>
                        <input type="text"  name="dire" class="in"/>
                    -->
			        <input type="submit" name="insert" class="btnR" value="INSERTAR DATOS"><br /><br />
                </form>
			</div>

        </div>

        <br/><br/><br/>


        	<?php
		if(isset($_POST['insert'])){
			$nombre= $_POST['nombre'];
			$apellido = $_POST['apellido'];
            $cedula = $_POST['cedula'];
            $sexo = $_POST['sexo'];
			$naci = $_POST['f_nacimiento'];

            $insertar = "INSERT INTO  clientes(Nombre, apellido,cedula,sexo,F_nacimiento)VALUES('$nombre', '$apellido', '$cedula','$sexo','$naci')";

			$ejecutar = sqlsrv_query($con, $insertar);

			if($ejecutar){
				echo "<script> alert('¡Registro Exitoso!')</script>";
			}

		}

	?>

        <?php
            $serverName="localhost";
            $connectionInfo = array("Database"=>"GYM");
            $con =sqlsrv_connect($serverName, $connectionInfo);
            /*if($con){
                echo "<script> alert('Conexion Exitosa')</script>";
            }else{
                echo "<script> alert('Conexion Fallida')</script>";
            }*/
        ?>


</body>
</html>

