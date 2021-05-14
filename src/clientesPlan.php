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
    <div>
        <div class="col-md-8 col-md-offset-2">
             <br/>
            <h1 class="clientesIns">CLIENTES INSCRITOS POR PLAN</h1>
            <br/>
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
                        <td>NOMBRE DEL PLAN</td>
                        <td class="campos">CANTIDAD DE INSCRITOS</td>
                    </tr>

                    <?php
                 
                        $consulta = "SELECT * FROM CLIENTES_PLANES";
                        $ejecutar = sqlsrv_query($con, $consulta);
                        $i = 0;
                        while ($fila = sqlsrv_fetch_array($ejecutar)) {
                            $id = $fila['ID'];
                            if(is_null($id)){
                                $id = "-";
                            }

                            $nombre = $fila['PLANES'];
                            if(is_null($nombre)){
                                $nombre = "-";
                            }

                            $ins = $fila['INSCRITOS'];
                            if(is_null($ins)){
                                $ins = "-";
                            }


                            $i++;
                                
                    ?>

                        <tr align="center">
                            <td><?php echo $id; ?></td>
                            <td><?php echo $nombre; ?></td>
                            <td><?php echo $ins; ?></td>
                        </tr>

                    <?php } ?>
            
                </table>
            </div>

        <?php
            if(isset($_POST['btnvolver'])){
                echo "<script> window.open('formulario.php', '_self')</script>";
            }
        ?>
</body>
</html>