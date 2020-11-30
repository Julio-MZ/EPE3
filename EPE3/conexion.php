<?php
	function conectar(){
		$servername="localhost";
		$username="root";
		$password="";
		$dbname="epe3";
		
		$con= mysqli_connect($servername,$username,$password,$dbname);
		
		if($con->connect_error){
			die("Conexión Fallida: ".$con->connect_error);
		}
		return $con;
	}
?>