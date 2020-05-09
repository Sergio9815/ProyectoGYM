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
	
	<script type="text/javascript">
		window.history.forward();
		function sinVueltaAtras(){ window.history.forward(); }
	</script>
	
<body onload="sinVueltaAtras();" onpageshow="if (event.persisted) sinVueltaAtras();" onunload="">
    <header>
    <div id="barMenu">
                <nav id="menu">
                    <ul>
                        <li><a href="insertar.php">INSERTAR CLIENTES</a></li>          
                        <div class="dropdown">
                            <button class="dropbtn">CONSULTAS</button>
                                <div class="dropdown-content">
                                    <a href="formulario.php">Clientes</a>
                                    <a href="clientesPlan.php">Inscritos por plan</a>
                                    <a href="contacto.php">Contacto</a>
                                    <a href="estadoClientes.php">Datos del cliente</a>
                                    <a href="asistencia.php">Asistencia</a>
                                    <a href="historialPagos.php">Historial de pagos</a>
                                </div>
                        </div>
                        <li><a id="cerrarSec" href="login2.php">CERRAR SESIÓN</a></li> 
                    </ul>   
                    <form method="post" class="box">
                        <input type="number" name="buscar" autofocus class="barra" placeholder="Buscar cliente..." title="Ingrese el ID del cliente">
                        <input type="submit" name="btnBuscar" class="btn" value="Buscar" >
                        <input type="submit" name="btnvolver" class="btn2" value="Deshacer" >
                    </form>   
                            
                </nav>
            </div>
    </header>
        <div class="col-md-8 col-md-offset-2">
             <br/>
            <h1 class="clientesIns">INFORMACIÓN DE CONTACTO</h1>
            <div method="POST" action="" class="filt">
                        <button class="fi">Filtrar por</button>
                            <div class="contenidoFiltro">
                                <a href="contacto.php?nom=<?php echo $nom; ?>">Nombre</a>
                                <a href="contacto.php?ape=<?php echo $ape; ?>">Apellido</a>
                                <a href="contacto.php?ced=<?php echo $ced; ?>">Cedula</a>
                            </div>
            </div>
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

        <div id="contenedor" class="col-md-8 col-md-offset-2">
        <table class="table table-bordered table-responsive" align="center">
            <tr align="center">
                <td>ID</td>
                <td>NOMBRE</td>
                <td>APELLIDO</td>
                <td>CÉDULA</td>
                <td>WHATSAPP</td>
                <td>FACEBOOK</td>
                <td>INSTAGRAM</td>
                <td>EMAIL</td>
                <td>TELÉFONO FAMILIAR</td>
                <td>DIRECCIÓN</td>
                <td>ACCIÓN</td>
                <!--<td>ACCION</td>-->
            </tr>

            <?php
                if(isset($_GET['nom'])){
                    $consulta = "SELECT * FROM CONTACTO ORDER BY NOMBRE";
                }
                elseif(isset($_GET['ape'])){
                    $consulta = "SELECT * FROM CONTACTO ORDER BY APELLIDO";
                }
                elseif(isset($_GET['ced'])){
                    $consulta = "SELECT * FROM CONTACTO ORDER BY CEDULA";
                }
                elseif(isset($_POST['btnBuscar'])){
                    $b = $_POST['buscar'];
                    $consulta = "EXEC SP_CONTACTO_UNO '$b'";
                }
                else{
                    $consulta = "SELECT * FROM CONTACTO";
                }
                $ejecutar = sqlsrv_query($con, $consulta);
                $i = 0;
                while ($fila = sqlsrv_fetch_array($ejecutar)) {
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

                    $i++;
                        
            ?>

            <tr align="center">
                <td><?php echo $cod; ?></td>
                <td><?php echo $nom; ?></td>
                <td><?php echo $ape; ?></td>
                <td><?php echo $cedu; ?></td>
                <td><?php echo $whats; ?></td>
                <td><?php echo $face; ?></td>
                <td><?php echo $ins; ?></td>
                <td><?php echo $correo; ?></td>
                <td><?php echo $telf; ?></td>
                <td><?php echo $direc; ?></td>
                <td><a class="botones" href="contacto.php?editarCon=<?php echo $cod; ?>">Editar</a></td>
                <!--<td><a class="botones" href="formulario.php?borrar=<?php/* echo $cod; */?>">Borrar</a></td>-->
            </tr>

        <?php } ?>
                
        </table>
        </div>

        <?php
            if(isset($_GET['editarCon'])){
                include("editarContacto.php");
            }
        ?>
        
        <!--
        <?php/*
            if(isset($_GET['borrar'])){
                include("borrar.php");
            }*/
        ?>
        -->
        
        <?php
            if(isset($_POST['btnvolver'])){
                echo "<script> window.open('contacto.php', '_self')</script>";
            }
        ?>
</body>
</html>