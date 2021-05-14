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
	    <script src="./js/Confirmar.js"></script>

    <title>N' FORMAS</title>
    <link href="./styles/style.css" rel="stylesheet">
    </head>
	
	<script type="text/javascript">
		window.history.forward();
		function sinVueltaAtras(){ window.history.forward(); }
	</script>
	
<body onload="sinVueltaAtras();" onpageshow="if (event.persisted) sinVueltaAtras();" onunload="">
    <header><!--
            <div>
                <h1 class="titulo"></h1>
                <img src="./assets/img/logo.jpg" height="100" alt="N'Formas" class="logoGym"> 
            </div>-->
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
    <div>
        <div class="col-md-8 col-md-offset-2">
             <br/>
            <h1 class="clientesIns">CLIENTES INSCRITOS</h1>
            <div method="POST" action="" class="filt">
                        <button class="fi">Filtrar por</button>
                            <div class="contenidoFiltro">
                                <a href="formulario.php?nom=<?php echo $nom; ?>">Nombre</a>
                                <a href="formulario.php?ape=<?php echo $ape; ?>">Apellido</a>
                                <a href="formulario.php?ced=<?php echo $ced; ?>">Cedula</a>
                                <a href="formulario.php?nac=<?php echo $nac; ?>">Nacimiento</a>
                                <a href="formulario.php?fec=<?php echo $fec; ?>">Fecha de inscripcion</a>
                                <a href="formulario.php?sal=<?php echo $sal; ?>">Saldo a pagar</a>
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
                    <tr align="center" class="campos">
                        <td class="campos">ID</td>
                        <td>NOMBRE</td>
                        <td>APELLIDO</td>
                        <td>CÉDULA</td>
                        <td>FECHA DE NACIMIENTO</td>
                        <td>INSCRIPCIÓN</td>
                        <td>PLAN</td>
                        <td>SALDO A PAGAR</td>
                        <td>ACCIÓN</td>
                        <td class="campos">ACCIÓN</td>
                    </tr>

                    <?php
                 
                        if(isset($_GET['nom'])){
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS ORDER BY NOMBRE";
                        }
                        elseif(isset($_GET['ape'])){
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS ORDER BY APELLIDO";
                        }
                        elseif(isset($_GET['ced'])){
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS ORDER BY CEDULA";
                        }
                        elseif(isset($_GET['nac'])){
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS ORDER BY F_NACIMIENTO";
                        }
                        elseif(isset($_GET['fec'])){
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS ORDER BY FECHA_INSCRIPCION";
                        }
                        elseif(isset($_GET['sal'])){
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS ORDER BY DEUDA";
                        }
                        elseif(isset($_POST['btnBuscar'])){
                            $b = $_POST['buscar'];
                            $consulta = "EXEC SP_CLIENTES_INSCRITOS_UNO '$b'";
                        }
                        else{
                            $consulta = "SELECT * FROM CLIENTES_INSCRITOS";
                        }
                        $ejecutar = sqlsrv_query($con, $consulta);
                        $i = 0;
                        while ($fila = sqlsrv_fetch_array($ejecutar)) {
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

                            if(is_null($fila['FECHA_INSCRIPCION'])){
                                $inscripcion = "-";
                            }
                            else{
                                $fecha_ins = $fila['FECHA_INSCRIPCION'];
                                $inscripcion = date_format($fecha_ins, "d/m/Y");
                            }

                            $plan = $fila['TIPO_DE_PLAN'];
                            if(is_null($plan)){
                                $plan = "-";
                            }

                            $deuda = $fila['DEUDA'];
                            if(is_null($deuda)){
                                $deuda = "-";
                            }

                            $i++;
                                
                    ?>

                        <tr align="center">
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nombre; ?></td>
                            <td><?php echo $apellido; ?></td>
                            <td><?php echo $cedula; ?></td>
                            <td><?php echo $nacimiento; ?></td>
                            <td><?php echo $inscripcion; ?></td>
                            <td><?php echo $plan; ?></td>
                            <td><?php echo $deuda; ?></td>
                            <td><a class="botones" href="formulario.php?editar=<?php echo $id; ?>">Editar</a></td>
                            <td><a class="botones2" href="formulario.php?borrar=<?php echo $id; ?>">Borrar</a></td>
                        </tr>

                    <?php } ?>
            
                </table>
            </div>

        <?php
            if(isset($_GET['editar'])){
                include("editar.php");
            }
        ?>

        <?php
            if(isset($_GET['borrar'])){
                include("borrar.php");
            }
        ?>

        <?php
            if(isset($_POST['btnvolver'])){
                echo "<script> window.open('formulario.php', '_self')</script>";
            }
        ?>
</body>
</html>