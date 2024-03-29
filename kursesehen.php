<?php
session_start();
include("init.php");
include("../../private/dbconnection.inc.php");

echo("
<!DOCTYPE html>
<html>
<head>
	<title>Deine Seite</title>
	<style>
		table.table_1 {
			font-size: 30px;
			border-collapse: collapse;
			border: 3px solid white;
			border-spacing: 2px;
			border-width: thin 1 1 thin;
			margin: 1 1 1em;
			table-layout: auto;
			max-width: 100%;
			color: white;
		}
		th.table_1, td.table_1 {
			font-weight: normal;
			text-align: center;
		}
		th.table_1 {
			/*background-color: pink;*/
			border-spacing: 2px;
			font-weight: 700;
		}
		caption.table_1 {
			background-color: white;
			font-weight: 1000;
		}
		table.table_1 {
			caption-side: bottom;
		}
	</style>
</head>
<body>");
//if(isset($_SESSION['name'])){
	$conn = mysqli_connect($servername, $username, $password, $db);
	$sql = "SELECT * FROM kurs";
	$query = mysqli_query($conn, $sql);

	$trainerCourses = array();

	// Annahme: $query enthält das Ergebnis der Datenbankabfrage
	while ($row = mysqli_fetch_assoc($query)) {
    	$trainer = $row['Fitnesstrainer'];

    	// Wenn der Trainer bereits im Array vorhanden ist, füge den Kurs hinzu
    	if (isset($trainerCourses[$trainer])) {
        	$trainerCourses[$trainer][] = $row;
    	} else {
        	// Wenn der Trainer noch nicht im Array ist, füge ihn hinzu und initialisiere das Array mit dem ersten Kurs
        	$trainerCourses[$trainer] = array($row);
    	}
	}
	$i = 1;
	// Erzeuge die Tabelle mit den gruppierten Kursen
	echo ("<table class='table_1'>");
	echo("<tr><th>Ebene</th><th>08.00 bis 10.00</th><th>11.00 bis 13.00</th><th>14.00 bis 16.00</th><th>17.00 bis 19.00</th></tr>");
	echo("");
	foreach ($trainerCourses as $trainer => $courses) {
    	echo("<tr>");
    	echo("<td>".$i.". Stock</td>");
    	foreach ($courses as $course) {
        	echo ("<td>");
        	echo ("Trainer: " . $course['Fitnesstrainer'] . "<br>");
        	echo ("Kurs: ".$course['Kursname'] . "<br> Status: " . $course['Status'] . "<br>");
        	echo ("<form id='myform3'>");
        	echo ("<input type='hidden' name=kurs_id value=" . $course['Kurs_ID'] . "/>");
        	echo ("<input type='hidden' name=kunden_id value=" . $_SESSION['id'] . "/>");
        	echo ("<button id='teilnehmen' type='submit'>jetzt teilnehmen</button>");
        	echo ("</form>");
        	echo ("</td>");
    	}
    	echo ("</tr>");
    	++$i;
	}
	echo ("</table>");
/*} else {
	echo("<strong class='eingabe'>Sie müssen sich erstmal anmelden.</strong>");
}*/
echo("</body></html>");