<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
include("../../private/redis.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");



if(isset($_SESSION['name']) && $_SESSION['rolle'] == "benutzer"){

	$conn = mysqli_connect($servername, $username, $password, $db);
	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}
	$kunden_id = $_POST['kunden_id'];
	$kurs_id = $_POST['kurs_id'];
	$kursname = $_POST['kursname'];

	$sql = "DELETE FROM kurs_angemeldet WHERE Kunden_ID = ? AND Kurs_ID = ?";
	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 'ii', $kunden_id, $kurs_id);
	mysqli_execute($query);
	
	//Prüfen ob die SQL_Abfrage erfolgreich war
  if(mysqli_affected_rows($conn) ){
		echo("<span class='positiv_response'>Sie haben sich erfolgreich vom folgenden Kurs abgemeldet</span>");
	} else {
		echo("<span class='negativ_response'>Fehler bei der Abfrage</span>");
	}
	mysqli_close($conn);
} else {
	echo("Sie müssen angemeldet sein");
}
