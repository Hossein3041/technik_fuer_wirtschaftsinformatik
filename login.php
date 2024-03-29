<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");
//Daten empfangen
$email= $_POST['email'];
$passwort = $_POST['password'];

//echo("<script type='text/javascript' src='script.js'></script>");

if(isset($_SESSION['number'])){
	$_SESSION['number'] = 0;
}

$conn = mysqli_connect($servername, $username, $password, $db);
if(!$conn){
	die("Connection failed".mysqli_connect_error());
}

$sql = "SELECT * FROM user WHERE email = ?";
$query = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($query, 's', $email);
mysqli_execute($query);
$result = mysqli_stmt_get_result($query);
$row = mysqli_fetch_assoc($result);
$numOfRow = mysqli_num_rows($result);
if($numOfRow > 0){
	if($email == $row['email']){
		if(password_verify($passwort, $row['password'])){
			echo ("<h3><span class='positiv_response'>Willkommen ". $row['vorname']."</span></h3>");
			$_SESSION['name'] = $row['vorname'];
			$_SESSION['id'] = $row['ID'];
			$_SESSION['rolle'] = $row['rolle'];
		} else {
			echo ("<h3><span class='negativ_response'>Falsches Password, versuchen Sie erneut</span></h3>");
		}
	} else {
		echo ("<h3><span class='eingabe'>Sie haben noch kein Konto!</span><strong id='registrieren2' class='regis'>Sie müssen sich registrieren</strong></h3>");
	}
} else {
	echo ("<h3><span class='eingabe'>Sie haben noch kein Konto!</span> <strong id='registrieren' class='regis'>Sie müssen sich registrieren</strong><h3>");
}
