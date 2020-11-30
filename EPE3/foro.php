<?php
	session_start();
	require("conexion.php");
	$con=conectar();
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Servicios de Turismo | Foro</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	</head>
	
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
						<h6>Logueado como: <span class="badge badge-warning"><?php echo $_SESSION['nombreUsuario']; ?></span></h6>
						<p align="right"><a href="logout.php"><button type="button" class="btn btn-danger btn-sm">Cerrar Sesión</button></a></p>
					</div>
				</div>
			</div>
			
			<hr>
			
			<div class="container-fluid">
				<nav class="nav nav-tabs justify-content-center">
					<a href="index.php" class="nav-link">Inicio</a>
					<a href="#" class="nav-link active">Foro</a>
					<a href="galeria.php" class="nav-link">Galería</a>
					<a href="#" class="nav-link" data-toggle="modal" data-target="#sobreNosotros">Sobre Nosotros</a>
					<a href="contacto.php" class="nav-link">Contáctanos</a>
				</nav>
			</div>
		</div>
		
		<div class="container-fluid p-5">
			<?php $result = mysqli_query($con, "SELECT * FROM categorias");
			if(!$result){
				echo 'No se pudieron mostrar las categorias. Inténtelo de nuevo más tarde.';
			}else{
				if(mysqli_num_rows($result) == 0){
					echo 'Aún no se han definido categorias.';
				}else{ ?>
					<table class="table table-striped table-bordered table-hover table-light">
						<thead class="thead-dark"> 
							<tr> 
								<th>Categoría</th> 
								<th>Temas</th>
								<th>Publicaciones</th>
								<th>Última Publicación</th>
							</tr> 
						</thead>
						<tbody>
							<?php while($row = mysqli_fetch_assoc($result)){ ?>
								<tr>
									<td><h4><a href="tema.php?id= <?php echo $row['idCategoria'] ?> "> <?php echo $row['nombre'] ?> </a></h4> <?php echo $row['descripcion']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php }
			} ?>
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
		
		<footer class="bg-light">
			<div class="panel panel-default">
				<hr>
				<div class="container-fluid text-center p-3">
					<p class="panel-default">© Las condes 1322 </p>
				</div>
			</div>
		</footer>
	</body>
</html>