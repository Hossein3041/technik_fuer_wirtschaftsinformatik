<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


if(isset($_SESSION['rolle']) && $_SESSION['rolle'] == "admin"){
	$conn = mysqli_connect($servername, $username, $password, $db);

	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}

	$rolle = "benutzer";

	$sql = "SELECT * FROM user WHERE rolle = ?";

	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 's', $rolle);
	mysqli_execute($query);
	$result = mysqli_stmt_get_result($query);

	echo("<div id='outpout'></div>");
	echo ("<table class='table_1'>");
	echo("<tr class='table_1'><th class='table_1'>ID</th><th class='table_1'>Nachname</th><th class='table_1'>Vorname</th><th class='table_1'>E-Mail</th><th class='table_1'>Geburtsdatum</th><th class='table_1'>Geburtsort</th><th class='table_1'>Alter</th><th class='table_1'>Löschen</th><tr>");
	while($row = mysqli_fetch_assoc($result)){
		echo("<tr class='table_1'>");
		echo("<td class='table_1'>".$row['ID']."</td>");
		echo("<td class='table_1'>".$row['nachname']."</td>");
		echo("<td class='table_1'>".$row['vorname']."</td>");
		echo("<td class='table_1'>".$row['email']."</td>");
		echo("<td class='table_1'>".$row['geburtsdatum']."</td>");
		echo("<td class='table_1'>".$row['geburtsort']."</td>");
		echo("<td class='table_1'>".$row['Age']."</td>");
		echo("<td class='table_1'><form id='theform".$row['ID']."' method='POST'><input type='hidden' name='ID' value=".$row['ID']."/><button id='remove' type='sumit' class='button2' onclick='loeschen(".$row['ID'].")'>Konto löschen</button></form></td>");
		echo("</tr>");
	}
	echo("</table>");
	mysqli_close($conn);
} else {
	echo ("<strong style='font-size: 75px; color: red'>Nur Admins haben Zugriff zu diesen sensiblen Daten. Und Sie sind leider keinen Admin</strong>");
}