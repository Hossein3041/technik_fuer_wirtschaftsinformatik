<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


if(isset($_SESSION['name']) && $_SESSION['rolle'] == "benutzer"){

	$conn = mysqli_connect($servername, $username, $password, $db);
	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}
	
	$sql = "SELECT * FROM kurs_angemeldet WHERE Kunden_ID = ?";
	$kunden_id = $_SESSION['id'];
	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 's', $kunden_id);
	mysqli_execute($query);
	$result = mysqli_stmt_get_result($query);

	echo("<div id='outpout'></div><br><br><br>");

	echo("<table class='table_1'>");
	echo("<tr class='table_1'><th class='table_1'>Kursname&nbsp;&nbsp;</th><th class='table_1'>Trainer&nbsp;&nbsp;</th><th class='table_1'>Fitnessziel&nbsp;&nbsp;</th><th class='table_1'>Raum&nbsp;&nbsp;</th><th class='table_1'>Status&nbsp;&nbsp;</th><th class='table_1'>Stornieren&nbsp;&nbsp;</th></tr>");
	while($row = mysqli_fetch_assoc($result)){
		$sql2 = "SELECT * FROM kurs WHERE Kurs_ID = ?";
		$query2 = mysqli_prepare($conn, $sql2);
		mysqli_stmt_bind_param($query2, 's', $row['Kurs_ID']);
		mysqli_execute($query2);
		$result2 = mysqli_stmt_get_result($query2);
		while($row2 = mysqli_fetch_assoc($result2)){
			echo("<tr class='table_1'><td class='table_1'>".$row2['Kursname']."</td><td class='table_1'>".$row2['Fitnesstrainer']."</td><td class='table_1'>".$row2['Fitnessziel']."</td><td class='table_1'>".$row2['Raum']."</td><td class='table_1'>".$row2['Status']."</td><td class='table_1'><form id='theform".$kunden_id."' method='POST'><input type='hidden' name='kunden_id' value=".$kunden_id."/><input type='hidden' name='kursname' value=".$row2['Kursname']."/><input type='hidden' name='kurs_id' value=".$row['Kurs_ID']."/><button type='submit' id='abmelden' class='button2' onclick='storno(".$kunden_id.")'>Abmelden</button></form></td><tr>");
		}
	}
	echo("</table>");

	mysqli_close($conn);
} else {
	echo("Sie müssen sich anmelden");
}