<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
	
    <link href="login/css/bootstrap.css" rel="stylesheet">
    <link href="login/micss/login.css" rel="stylesheet">
    

    <script src="login/js/jquery-3.3.1.min.js"></script>
    <script src="login/js/bootstrap.js"></script>

  </head>

	<style>
		form{
			background-color: white;
		}
	
		body{
			background-color: white;
		}
	</style>
  <body class="text-center ">

    
    <form class="form-signin container" name="login" >
      <img class="mb-4" src="login/imagenes/logo.jpg" alt="" width="260" height="120">
      <h1 class="h3 mb-3 font-weight-normal">Ingresa tu usuario</h1>

      <label for="inputEmail" class="sr-only">User</label>
      <input type="text" id="inputEmail" name="inputEmail" class="form-control" placeholder="Nombre de usuario" required autofocus>

      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>

      <div class="checkbox mb-3">

        <label>
          <input type="checkbox" value="remember-me"> Recordar
        </label>
      </div>

      <input class="btn btn-lg btn-danger btn-block" type="button" onclick="check(this.form)" value="Login">
      <p class="mt-5 mb-3 text-muted">&copy; 2018</p>
      

    </form>

    <script language="javascript">
        function check(form)
        {
         var nombre = form.inputEmail.value;
         nombre=nombre.toUpperCase();
        var clave =form.inputPassword.value
        clave=clave.toUpperCase();
        var a= 0;
         
         if(nombre == "DAYANA" && clave == "HWORLD")
          {
            window.open('formulario.php', '_self')
          }
         else
         {
           alert("Nombre de usuario o clave incorrecta")
           a++
          }
        }
        </script>



   
  </body>
</html>
