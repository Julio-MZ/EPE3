<?php
	session_start();

	if(isset($_SESSION['idUsuario'])){
		session_destroy();
		unset($_SESSION['idUsuario']);
		unset($_SESSION['nombreUsuario']);
		header("Location: index.php");
	}else{
		header("Location: index.php");
	}
?>