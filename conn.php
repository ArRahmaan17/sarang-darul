	<?php
	ini_set('date.timezone', 'Asia/Jakarta');
	$host = "localhost";
	$username = "root";
	$password = "";
	$database = "sarang";

	$conn = mysqli_connect($host, $username, $password, $database);
	$querynomeradmin = "SELECT * FROM admin limit 1";
	$execnomeradmin = mysqli_query($conn, $querynomeradmin);
	$dataadmin = mysqli_fetch_array($execnomeradmin, MYSQLI_ASSOC);
	$nomeradmin = $dataadmin['nomer_petugas'];
