<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");
include("../../private/redis.inc.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


if(isset($_SESSION['name'])){
	$kurs = $_POST['kurs_name'];
	$conn = mysqli_connect($servername, $username, $password, $db);

	if(!$conn){
		die("Connection failed".mysqli_connect_error());
	}

	$sql = "SELECT Kurs_ID FROM kurs WHERE Kursname = ?";
	$query = mysqli_prepare($conn, $sql);
	mysqli_stmt_bind_param($query, 's', $kurs);
	mysqli_execute($query);
	$result = mysqli_stmt_get_result($query);

	$row = mysqli_fetch_assoc($result);
	$id = $_SESSION['id'];
	$kurs_id = $row['Kurs_ID'];

	$sql2 = "SELECT * FROM kurs_angemeldet WHERE Kunden_ID = ? AND Kurs_ID = ?";
	$query2 = mysqli_prepare($conn, $sql2);
	mysqli_stmt_bind_param($query2, 'ss', $id, $kurs_id);
	mysqli_execute($query2);
	$result = mysqli_stmt_get_result($query2);
	$numOfRow = mysqli_num_rows($result);
	if($numOfRow > 0){
		echo("<span class='positiv_response'>Sie haben sich schon für den folgenden Kurs angemeldet: ".$kurs."</span>");
	} else {

		$sql3 = "SELECT * FROM kurs WHERE Kurs_ID = ?";
		$query3 = mysqli_prepare($conn, $sql3);
		mysqli_stmt_bind_param($query3, 'i', $kurs_id);
		mysqli_execute($query3);
		$result2 = mysqli_stmt_get_result($query3);
		$row2 = mysqli_fetch_assoc($result2);
		if($row2['Status'] == "abgesagt"){
			echo("<span class='negativ_response'>Der Kurs, für den Sie sich anmelden möchten wurde leider abgesagt</span>");
		} else {
			  $redis = new Redis();
			  $redis->connect('127.0.0.1',6379); 
   			$redis->auth($redispassword);
   			$counter = $redis->get($kurs_id);
			if($counter >= 15){
				echo("<span class='negativ_response'>Die maximale Anzahl an Teilnehmern für diesen Kurs ist schon erreicht. Es ist keine Anmeldung mehr möglich</span>");
			} else{
        $redis->incr($kurs_id);
        $redis->close();
				$sql4 = "INSERT INTO kurs_angemeldet (Kunden_ID, Kurs_ID) VALUES (?, ?)";
				$query4 = mysqli_prepare($conn, $sql4);
				mysqli_stmt_bind_param($query4, 'ss', $id, $kurs_id);
				mysqli_execute($query4);
				if(mysqli_affected_rows($conn) > 0){
					echo("<span class='positiv_response'>Sich haben sich erfolgreich für den gewünschten Kurs angemeldet</span> ");
				} else {
				echo("<span class='negativ_response'>Ein Fehler ist bei der Buchung entstanden. Versuchen Sie zu einem späteren Zeitpunkt</span>");
				}
			}
		}
	}
	mysqli_close($conn);
} else {
	echo("<span class='negativ_response'>Sie müssen sich erstmal anmelden</span>");
}
