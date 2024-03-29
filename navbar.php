<?php
session_start();
include("init.php");
echo("<link rel='stylesheet' type='text/css' href='styles.css'>");


echo("<script type='text/javascript' src='script.js'></script>");

if(isset($_SESSION['name'])){
	if($_SESSION['rolle'] == "admin"){
		echo("<ul>");
		echo("<li id='benutzerkonten'>Benutzerkonten</li>");
		echo("<li id='registed'>Anmeldungen</li>");
		echo("<li id='katalog'>Katalog</li>");
		echo("<li id='aendern'>Status ändern</li>");
		echo("<li id='logout' style='float: right;'>Logout</li>");
		echo("<li style='float: center;'>Willkommen @".$_SESSION['name']."</li>");
		echo("</ul>");
	} else {
		echo("<ul>");
		echo("<li id='home'>Home</li>");
		echo("<li id='kurse'>Mitmachen</li>");
		echo("<li id='kurse2'>angemeldete Kurse</li>");
		echo("<li id='katalog'>Katalog</li>");
		echo("<li id='logout' style='float: right;'>Logout</li>");
		echo("<li style='float: center;'>Willkommen zurück @".$_SESSION['name']."</li>");
		echo("</ul>");
	} 
} else {
	echo("<ul>");
	echo("<li id='home'>Home</li>");
	echo("<li id='youshallnotpass' >alle Fitnesskurse ansehen</li>");
	echo("<li id='login' >Login</li>");
	echo("<li id='registrieren' style='float: right;'>Registrierung</li>");
	echo("</ul>");
}