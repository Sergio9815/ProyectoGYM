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
    <link href="./styles/style.css" rel="stylesheet">
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
            <h1 class="clientesIns">HISTORIAL DE PAGOS</h1>
            <div method="POST" action="" class="filt">
                        <button class="fi">Filtrar por</button>
                            <div class="contenidoFiltro">
                                <a href="historialPagos.php?nom=<?php echo $nom; ?>">Nombre</a>
                                <a href="historialPagos.php?ape=<?php echo $ape; ?>">Apellido</a>
                                <a href="historialPagos.php?ced=<?php echo $ced; ?>">Cedula</a>
                                <a href="historialPagos.php?sal=<?php echo $sal; ?>">Saldo</a>
                                <a href="historialPagos.php?fec=<?php echo $fec; ?>">Fecha de pago</a>
                            </div>
            </div>
        </div>

        <?php
            $serverName="DESKTOP-GLDD0PS\SQLEXPRESS";
            $connectionInfo = array("Database"=>"GYM");
            $con =sqlsrv_connect($serverName, $connectionInfo);
        ?>

        <div id="contenedor" class="col-md-8 col-md-offset-2">
        <table class="table table-bordered table-responsive" align="center">
            <tr align="center">
                <td>ID</td>
                <td>NOMBRE</td>
                <td>APELLIDO</td>
                <td>CÉDULA</td>
                <td>SALDO</td>
                <td>FECHA</td>
                <td>DETALLES</td>
                <!--<td>ACCIÓN</td>-->
            </tr>

            <?php
                if(isset($_GET['nom'])){
                    $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS ORDER BY NOMBRE";
                }
                elseif(isset($_GET['ape'])){
                    $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS ORDER BY APELLIDO";
                }
                elseif(isset($_GET['ced'])){
                    $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS ORDER BY CEDULA";
                }
                elseif(isset($_GET['sal'])){
                    $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS ORDER BY SALDO";
                }
                elseif(isset($_GET['fec'])){
                    $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS ORDER BY FECHA";
                }
                elseif(isset($_POST['btnBuscar'])){
                    $b = $_POST['buscar'];
                    $consulta = "EXEC SP_HISTORIAL_DE_PAGOS_UNO '$b'";
                }
                else{
                    $consulta = "SELECT * FROM HISTORIAL_DE_PAGOS";
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

                    $saldo = $fila['SALDO'];
                    if(is_null($saldo)){
                        $saldo = "-";
                    }
                    
                    if(is_null($fila['FECHA'])){
                        $fech = "-";
                    }
                    else{
                        $fecha = $fila['FECHA'];
                        $fech = date_format($fecha, "d/m/Y");
                    }

                    $deta = $fila['DETALLES'];
                    if(is_null($deta)){
                        $deta = "-";
                    }

                    $i++;
                        
            ?>

            <tr align="center">
                <td><?php echo $cod; ?></td>
                <td><?php echo $nom; ?></td>
                <td><?php echo $ape; ?></td>
                <td><?php echo $cedu; ?></td>
                <td><?php echo $saldo; ?></td>
                <td><?php echo $fech; ?></td>
                <td><?php echo $deta; ?></td>
                <!--<td><a class="botones" href="historialPagos.php?editarP=<?php /*echo $cod; ?>">Editar</a></td>
                <!--<td><a class="botones" href="formulario.php?borrar=<?php /*echo $cod; */?>">Borrar</a></td>-->
            </tr>

        <?php } ?>
                
        </table>
        </div>

        <!--
        <?php
           /* if(isset($_GET['editarP'])){
                include("editarPagos.php");
            }
        ?>
        <?php/*
            if(isset($_GET['borrar'])){
                include("borrar.php");
            }*/
        ?>
        -->

        <?php
            if(isset($_POST['btnvolver'])){
                echo "<script> window.open('historialPagos.php', '_self')</script>";
            }
        ?>
</body>
</html>