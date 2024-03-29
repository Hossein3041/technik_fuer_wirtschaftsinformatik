<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


if(isset($_SESSION['name'])){

	$conn = mysqli_connect($servername, $username, $password, $db);
	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}

	$sql = "SELECT * FROM kurs";
	$result = mysqli_query($conn, $sql);


	while($row = mysqli_fetch_assoc($result)){
		echo("<div class='katalog-div'><h4 style='font-size: 25px; color: white;'>Kursname: ".$row['Kursname']."<br>");
		echo("Kursbeschreibung: ".$row['Beschreibung']."<br>");
		echo("Trainer: ".$row['Fitnesstrainer']."<br>");
		echo("Raum: ".$row['Raum']."<br>");
		echo("Status: ".$row['Status']."</h4></div><br><br><br>");
	}
	mysqli_close($conn);

} else {
	echo("Sie brauchen ein Konto und müssen angemeldet sein");
}
?>
