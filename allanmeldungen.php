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
	
	$kurs_id = $_POST['kurs_id'];
	$sql = "SELECT * FROM kurs_angemeldet WHERE Kurs_ID = ? ";
	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 'i', $kurs_id);
	mysqli_execute($query);
	$result = mysqli_stmt_get_result($query);
	echo("<table class='table_1'>");
	echo("<tr class='table_1'><th class='table_1'>Kunden_ID&nbsp;&nbsp;</th><th class='table_1'>Nachname&nbsp;&nbsp;</th><th class='table_1'>Vorname&nbsp;&nbsp;</th><th class='table_1'>E-Mail&nbsp;&nbsp;</th></tr>");
	while($row = mysqli_fetch_assoc($result)){
		$sql2 = "SELECT * FROM user WHERE ID = ?";
		$query2 = mysqli_prepare($conn, $sql2);
		mysqli_stmt_bind_param($query2, 'i', $row['Kunden_ID']);
		mysqli_execute($query2);
		$result2 = mysqli_stmt_get_result($query2);
		if(mysqli_num_rows($result2) == 0){
			echo("<tr class='table_1'><td class='table_1' colspan='4'><span class='negativ_response'>Es hat sich noch niemanden für den gewählten Kurs angemeldet.</span></td></tr>");
		} else{
			while($row2 = mysqli_fetch_assoc($result2)){
				echo("<tr class='table_1'><td class='table_1'>".$row2['ID']."</td><td class='table_1'>".$row2['nachname']."</td><td class='table_1'>".$row2['vorname']."</td><td class='table_1'>".$row2['email']."</td><tr>");
			}
		}
	}
	echo("</table>");

	mysqli_close($conn);
} else {
	echo("Sie müssen sich erstmal anmelden");
}