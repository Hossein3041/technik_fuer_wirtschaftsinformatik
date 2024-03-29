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
	$result = mysqli_query($conn,$sql);
	echo("<div id='outpout'></div><br><br><br>");
	echo("<form id='theform4' method='POST'>");
	echo("<label for='kurs_name' class='eingabe'>Kurs auswählen</label><br><br><br><select name='kurs_name' class='select'>");
	while($row = mysqli_fetch_assoc($result)){
		echo("<option>".$row['Kursname']."</option>");
	}
	echo("</select>");
	echo("     <button type='submit' id='submit' class='button'>Sich anmelden</button></form>");
	mysqli_close($conn);
} else {
	echo "Sie müssen erst angemeldet sein";
}