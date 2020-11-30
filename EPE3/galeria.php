<?php
session_start();
require("conexion.php");
$conexion=conectar();

$select="SELECT rutaImagen FROM galeria";

if(isset($_POST['subir'])){
    $imagen=$_FILES['imagen']['name'];
    $ruta='Imagenes/'.$imagen;

    $insert="INSERT INTO galeria(rutaImagen) VALUES('$ruta')";
    
    if($conexion->query($insert)===TRUE){
        move_uploaded_file($_FILES['imagen']['tmp_name'],$ruta);
    }
}

$result=$conexion->query($select);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Galería</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
	
	<?php if(isset($_POST['login'])){
		$email = mysqli_real_escape_string($conexion, $_POST['email']);
		$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
		$resultlogin = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '".$email."' and contrasena = '".md5($contrasena)."'");
	
		if($row = mysqli_fetch_array($resultlogin)){
			$_SESSION['idUsuario'] = $row['idUsuario'];
			$_SESSION['nombreUsuario'] = $row['nombre'];
		}else{
			$errormsglogin = "¡Revisa los datos!"; 
			?> <script>$(document).ready(function(){$("#ingresar").modal("show")});</script> <?php
		}
	}
	
	if(isset($_POST['registrarse'])){
		$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
		$email = mysqli_real_escape_string($conexion, $_POST['email']);
		$contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']);
		$ccontrasena = mysqli_real_escape_string($conexion, $_POST['ccontrasena']);
		$resultregistro = "INSERT INTO usuarios(nombre,email,contrasena) VALUES('".$nombre."', '".$email ."', '".md5($contrasena)."')";
		
		if(!preg_match("/^[a-zA-Zn-Ñ ]+$/",$nombre)){
			$error = true;
			$nombre_error = "El nombre debe contener solo caracteres del alfabeto y espacios.";
			?> <script>$(document).ready(function(){$("#registrar").modal("show")});</script> <?php
		}
		
		if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			$error = true;
			$email_error = "Ingrese un e-mail válido.";
			?> <script>$(document).ready(function(){$("#registrar").modal("show")});</script> <?php
		}
		
		if(strlen($contrasena) < 6){
			$error = true;
			$contrasena_error = "La contraseña debe tener un mínimo de 6 caracteres.";
			?> <script>$(document).ready(function(){$("#registrar").modal("show")});</script> <?php
		}
		
		if($contrasena != $ccontrasena){
			$error = true;
			$ccontrasena_error = "Las contraseñas no coinciden.";
			?> <script>$(document).ready(function(){$("#registrar").modal("show")});</script> <?php
		}
		
		if(!$error){
			if(mysqli_query($conexion, $resultregistro)){
				$successmsg = "¡Registrado exitosamente!";
				?> <script>$(document).ready(function(){$("#registrar").modal("show")});</script> <?php
			}else{
				$errormsgregistro = "El e-mail ingresado ya está en uso.";
				?> <script>$(document).ready(function(){$("#registrar").modal("show")});</script> <?php
			}
		}
	} ?>
	
<body>
	<div class="bg-light">
			<div class="container-fluid">
				<div class="row justify-content-between">
					<nav class="navbar navbar-expand-sm">
						<p class="mt-3">Síguenos:</p>
						<a href="https://twitter.com" class="nav-link p-2"><i class="fab fa-twitter fa-lg"></i></a>
						<a href="https://facebook.com" class="nav-link p-2"><i class="fab fa-facebook fa-lg"></i></a>
						<a href="https://instagram.com" class="nav-link p-2"><i class="fab fa-instagram fa-lg"></i></a>
					</nav>
					<div class="mt-2">
						<img src="Imagenes/logo.png">
					</div>
					<div class="p-3">
						<?php if(isset($_SESSION['idUsuario'])){ ?>
							<h6>Logueado como: <span class="badge badge-warning"><?php echo $_SESSION['nombreUsuario']; ?></span></h6>
							<p align="right"><a href="logout.php"><button type="button" class="btn btn-danger btn-sm">Cerrar Sesión</button></a></p>
						<?php }else{ ?>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ingresar">Ingresar</button>
							<button type="button" class="btn btn-success" data-toggle="modal" data-target="#registrar" >Registrarse</button>
						<?php } ?>
					</div>
				</div>
			</div>
			
			<hr>
			
			<div class="container-fluid">
				<script>$(document).ready(function(){$('[data-toggle="mensaje"]').tooltip();});</script>
				<?php if(isset($_SESSION['idUsuario'])){ ?>
					<nav class="nav nav-tabs justify-content-center">
						<a href="index.php" class="nav-link">Inicio</a>
						<a href="foro.php" class="nav-link">Foro</a>
						<a href="#" class="nav-link active">Galería</a>
						<a href="#" class="nav-link" data-toggle="modal" data-target="#sobreNosotros">Sobre Nosotros</a>
						<a href="contacto.php" class="nav-link">Contáctanos</a>
					</nav>
				<?php }else{ ?>
					<nav class="nav nav-tabs justify-content-center">
						<a href="index.php" class="nav-link">Inicio</a>
						<a href="#" class="nav-link disabled" data-toggle="mensaje" title="Inicie sesión para ingresar al Foro">Foro</a>
						<a href="#" class="nav-link active">Galería</a>
						<a href="#" class="nav-link" data-toggle="modal" data-target="#sobreNosotros">Sobre Nosotros</a>
						<a href="contacto.php" class="nav-link">Contáctanos</a>
					</nav>
				<?php } ?>
			</div>
			
			<div class="modal fade" id="ingresar" tabindex="-1" role="dialog" aria-labelledby="ingresar" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title">Iniciar Sesión</h3>
							<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						</div>
						<div class="modal-body">
							<form role="form" action="" method="post" name="ingreso">
								<fieldset>
									<div class="form-group">
										<label for="email">E-mail:</label>
										<input type="email" name="email" placeholder="E-mail" required class="form-control">
									</div>
									<div class="form-group">
										<label for="contrasena">Contraseña:</label>
										<input type="password" name="contrasena" placeholder="Contraseña" required class="form-control">
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary" name="login">Iniciar Sesión</button>
									</div>
									<span class="text-danger"><?php if(isset($errormsglogin)) echo $errormsglogin; ?></span>
								</fieldset>
							</form>
						</div>
						<div class="modal-footer justify-content-center">
							<p>¿No tienes cuenta? <a href="#registrar" data-toggle="modal" data-dismiss="modal">Registrate aquí</a></p>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="registrar" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title">Registro</h3>
							<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
						</div>
						<div class="modal-body">
							<form role="form" action="" method="post" name="registro">
								<fieldset>
									<div class="form-group">
										<label for="nombre">Nombre:</label>
										<input type="text" name="nombre" placeholder="Nombre" required value="<?php if($error) echo $nombre; ?>" class="form-control">
										<span class="text-danger"><?php if(isset($nombre_error)) echo $nombre_error; ?></span>
									</div>
									<div class="form-group">
										<label for="email">E-mail:</label>
										<input type="email" name="email" placeholder="E-mail" required value="<?php if($error) echo $email; ?>" class="form-control">
										<span class="text-danger"><?php if(isset($email_error)) echo $email_error; ?></span>
									</div>
									<div class="form-group">
										<label for="contrasena">Contraseña:</label>
										<input type="password" name="contrasena" placeholder="Contraseña" required class="form-control">
										<span class="text-danger"><?php if(isset($contrasena_error)) echo $contrasena_error; ?></span>
									</div>
									<div class="form-group">
										<label for="ccontrasena">Confirmar contraseña:</label>
										<input type="password" name="ccontrasena" placeholder="Repetir contraseña" required class="form-control">
										<span class="text-danger"><?php if(isset($ccontrasena_error)) echo $ccontrasena_error; ?></span>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" name="terminosycond" id="terminosycond" required> Acepto todos los <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-dismiss="modal" data-target="#terminosCondiciones">Términos y Condiciones</button>
										</label>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary" name="registrarse">Registrarse</button>
									</div>
									<span class="text-success"><?php if(isset($successmsg)) echo $successmsg; ?></span>
									<span class="text-danger"><?php if(isset($errormsgregistro)) echo $errormsgregistro; ?></span>
								</fieldset>
							</form>
						</div>
						<div class="modal-footer justify-content-center">
							<p>¿Ya te registraste? <a href="#ingresar" data-toggle="modal" data-dismiss="modal">Inicia sesión aquí</a></p>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="terminosCondiciones" tabindex="-1" role="dialog" aria-labelledby="terminosCondiciones" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h3 class="modal-title">Términos y Condiciones</h3>
							<button type="button" class="close" data-toggle="modal" data-dismiss="modal" data-target="#registrar"><span>&times;</span></button>
						</div>
						<div class="modal-body">
							<p>Mediante la simple utilización de serviciosturisticosepe3.com y al contratar cualquiera de los servicios ofrecidos a través de serviciosturisticosepe3.com, el cliente reconoce haber leído y acepta los términos expuestos en el presente Acuerdo y/o las políticas que formen parte del mismo.</p>

							<p><b>Uso de la cuenta de usuario en serviciosturisticosepe3.com:</b></p>

							<ul>
								<li>El usuario de serviciosturisticosepe3.com se compromete a proporcionar mediante su registro datos veraces, exactos y completos sobre su identidad. También se compromete a revisar periódicamente la información proporcionada y garantiza la validez y la vigencia de los datos asociados tanto a su cuenta de usuario como a los productos y servicios contratados. El incumplimiento de esta condición podrá motivar la cancelación de la cuenta y la denegación al usuario el acceso a los servicios de serviciosturisticosepe3.com de forma temporal o permanente.</li>

								<li>serviciosturisticosepe3.com se reserva el derecho de solicitar la verificación y/o actualización de la información proporcionada por el cliente, quien deberá responder satisfactoriamente a la petición en el plazo máximo de 5 días laborables. El cliente entiende y acepta que el no cumplimiento de este requisito constituye una vulneración del presente Acuerdo y puede dar lugar a la cancelación de los productos y/o servicios contratados.</li>
							</ul>
						</div>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#registrar">Cerrar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="sobreNosotros" tabindex="-1" role="dialog" aria-labelledby="sobreNosotros" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sobre nosotros</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <img src="Imagenes\QuienesSomos.png" class="img-fluid rounded" alt="">
                                </div>
                                <div class="col-lg-6">
                                    <h5>¿Quiénes somos?</h5>
                                    <p class="text-muted">Somos un sitio web dedicado a ofrecer serivicos de turismo a distintos lugares del mundo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	
    <div class="jumbotron">
        <h1 class="display-4">Galería de fotos</h1>
        <p class="lead">Echa un vistazo a algunos de los lugares y experiencias que te esperan...</p>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <img src="Imagenes\Galeria1.jpg" class="img-fluid rounded mb-1" alt="">
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="Imagenes\Galeria2.jpg" class="img-fluid rounded mb-1" alt="">
                    </div>
                    <div class="col-lg-6">
                        <img src="Imagenes\Galeria3.jpg" class="img-fluid rounded mb-1" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <img src="Imagenes\Galeria4.jpg" class="img-fluid rounded mb-1" alt="">
                    </div>
                    <div class="col-lg-6">
                        <img src="Imagenes\Galeria5.jpg" class="img-fluid rounded mb-1" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-5" style="background-color:#1d1d1d">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 mt-5">
                <div id="galeria" class="carousel slide carousel-fade" data-ride="carousel" style="position:relative">
                    <ol class="carousel-indicators">
                        <?php
                        $i=0;
                        foreach($result as $row){
                            $actives="";
                            if($i==0){
                                $actives="active";
                            }
                        ?>
                        <li data-target="#galeria" data-slide-to="<?= $i; ?>" class="<?= $actives; ?>"></li>
                        <?php $i++;} ?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $i=0;
                        foreach($result as $row){
                            $actives="";
                            if($i==0){
                                $actives="active";
                            }
                        ?>
                        <div class="carousel-item <?= $actives; ?>">
                            <img class="d-block w-100" src="<?= $row['rutaImagen'] ?>">
                        </div>
                        <?php $i++;} ?>
                    </div>
                    <a class="carousel-control-prev" href="#galeria" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#galeria" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="container text-center">
                    <button type="button" class="btn btn-dark btn-md my-3" data-toggle="modal" data-target="#subirImagen">
                        Subir imagen
                    </button>
                </div>
                <div class="modal fade" id="subirImagen" tabindex="-1" role="dialog" aria-labelledby="subirImagen" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Subir imagen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="file" name="imagen" class="form-control-file" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="subir" class="btn btn-success" value="Subir archivo">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<footer class="bg-light">
			<div class="panel panel-default">
				<hr>
				<div class="container-fluid text-center p-3">
					<p class="panel-default">© Las condes 1322 </p>
				</div>
			</div>
		</footer>
	
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>