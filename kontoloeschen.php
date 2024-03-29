<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


if(isset($_SESSION['name']) && $_SESSION['rolle'] == "admin"){
	$conn = mysqli_connect($servername, $username, $password, $db);

	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}
	$kunden_id = $_POST['ID'];

	$sql = "DELETE FROM user WHERE ID = ?";
	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 'i', $kunden_id);
	mysqli_execute($query);
	if(mysqli_affected_rows($conn) > 0){
		echo("<span class='positiv_response'>Benutzerkonto mit der folgenden ID(".$kunden_id.") erfolgreich gelöscht</span>");
	} else {
		echo("<span class='negativ_response'>Benutzerkonto könnte nicht gelöscht werden</span>");
	}
} else {
	echo("Sie müssen als Administrator angemeldet sein.");
}