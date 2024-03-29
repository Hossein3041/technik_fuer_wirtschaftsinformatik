<?php
include('init.php');
include('../../private/dbconnection.inc.php');
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");

$firstname = $_POST['nachname'];
$lastname = $_POST['vorname'];
$geburtsort = $_POST['geburtsort'];
$geburtsdatum = $_POST['geburtsdatum'];
$email = $_POST['email'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$rolle = "benutzer";
$password_hash = password_hash($password1, PASSWORD_ARGON2ID);
$password_hash2 = password_hash($password2, PASSWORD_ARGON2ID);

$heutigesDatum = date("Y-m-d");
$geburtsdatumObj = new DateTime($geburtsdatum);
$heutigesDatumObj = new DateTime($heutigesDatum);
$alter = $heutigesDatumObj->diff($geburtsdatumObj)->y;

$conn = mysqli_connect($servername, $username, $password, $db);
if(!$conn){
	die('Failed to connect to database'.mysqli_connect_error());
}
$sql = "SELECT * FROM user WHERE nachname = ? AND vorname = ? AND email = ? AND geburtsdatum = ? AND geburtsort = ? AND Age = ? AND rolle = ?";
$query = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($query, 'sssssss', $firstname, $lastname, $email, $geburtsdatum, $geburtsort, $alter, $rolle);
mysqli_execute($query);
$result = mysqli_stmt_get_result($query);
$numOfRow = mysqli_num_rows($result);
if($numOfRow > 0){
	echo ("<span class='negativ_response'>Es existiert bereits ein Konto für diesen Benutzer.<br> Loggen Sie sich bitte ein.<br> <strong id='login' onclick='loginformular()' class='regis'>Hier einloggen</strong></span>");
} else if ($password1 !== $password2 ){
		echo("<span class='negativ_response'>Beide Passwörter stimmen nicht überein</span>");
	} else{
		$sql = "INSERT INTO user (nachname, vorname, email, geburtsdatum, geburtsort, Age, rolle, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$query = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($query, 'ssssssss', $firstname, $lastname, $email, $geburtsdatum, $geburtsort, $alter, $rolle, $password_hash);
		mysqli_execute($query);
		mysqli_stmt_store_result($query);
		$result = mysqli_stmt_get_result($query);
		if(mysqli_affected_rows($conn) > 0){
		echo "<span class='positiv_response'>erfolgreich registriert</span>";	
	} else {
		echo "<span class='negativ_response'>Fehler beim Einfügen in der Datenbank</span>";
	}
	mysqli_close($conn);
}

?>