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
	$sql = "SELECT * FROM kurs";
	$result = mysqli_query($conn,$sql);
	echo("<p class='eingabe'>Wählen Sie den Kurs, von dem Sie den Status ändern möchten</p><br><br>");
	echo("<form id='theform8'  method='POST'>");
	echo("<label for='kurs_name' class='eingabe'>Kurs auswählen</label><br><br><br><select name='kurs_id' class='select'>");
	while($row = mysqli_fetch_assoc($result)){
		echo("<option value=".$row['Kurs_ID'].">".$row['Kurs_ID']."   -   ".$row['Kursname']."</option>");
	}
	echo("</select><br>");
	echo("<label for='status' class='eingabe'>Status wählen</label><br>");
	echo("<select name='status' class='select'>");
	echo("<option>findet statt</option>");
	echo("<option>abgesagt</option>");
	echo("</select>");
	echo("<br><br><button type='submit' id='submit' class='button'>Status</button></form>");
	echo("<br><br><br><div id='outpout'></div>");
	mysqli_close($conn);
} else {
	echo "Sie müssen erst angemeldet sein";
}