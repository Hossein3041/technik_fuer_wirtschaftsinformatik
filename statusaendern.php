<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


if(isset($_SESSION['name'] ) && $_SESSION['rolle'] == "admin"){
	$conn = mysqli_connect($servername, $username, $password, $db);
	
	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}
	
	$status = $_POST['status'];
	$kurs_id = $_POST['kurs_id'];

	$sql = "UPDATE kurs SET Status = ? WHERE Kurs_ID = ?";
	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 'ss', $status, $kurs_id);
	$result = mysqli_execute($query);
	if($result == true){
		echo("<span class='positiv_response'>Status erfolgreich geändert</span>");
	} else {
		echo("<span class='negativ_response'>Fehler bei der Abfrage</span>");
	}
	mysqli_close($conn);
} else {
	echo("Sie müssen erstmal als Administrator angemeldet sein");
}
?>