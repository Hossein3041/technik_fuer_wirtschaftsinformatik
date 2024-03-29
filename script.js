//Funktion Für Home
function home(){
	document.getElementById('main').innerHTML = "<div id='main' class='eingabe' style='font-size: 40px'><h3>Willkommen auf unserer Homepage</h3></div>"
	
}


//function für den Katalog
function katalog(){
	let req9 = new XMLHttpRequest
	req9.open('POST', 'katalog.php?t='+Date.now(), true)
	req9.onreadystatechange = function (){
		if(req9.readyState == 4 && req9.status == 200){
			document.getElementById('main').innerHTML = req9.responseText
		}
	}
	req9.send()
}


//sich für einen Fitnesskurs anmelden
function allfitnesskurse(){
	let req6 = new XMLHttpRequest
	req6.open('POST', 'mitmachen.php?t='+Date.now(), true)
	req6.onreadystatechange = function (){
		if(req6.readyState == 4 && req6.status == 200){
			document.getElementById('main').innerHTML = req6.responseText
			if (document.getElementById('theform4') !== null) {
        		document.getElementById('theform4').addEventListener('submit', function (event) {
               		event.preventDefault();
              		mitmachen();
            	});	
			} else {
				console.log('nicht gefunden')
			}
			// document.getElementById('main').innerHTML = req6.responseText
		}
	}
	req6.send()
}
//Angemeldete Kurse einsehenfür den Kunden
function kurse2(){
	let req7 = new XMLHttpRequest
	req7.open('POST', 'angemeldetekurse.php?t='+Date.now(), true)
	req7.onreadystatechange = function (){
		if(req7.readyState == 4 && req7.status == 200){
			document.getElementById('main').innerHTML = req7.responseText
		}
	}
	req7.send()
}

//Anmeldung stonieren
function storno(userID){
	console.log("Storno-Funktion aufgerufen mit userID:", userID);
	let formID = "theform" + userID
	const form = document.getElementById(formID)
	let formData = new FormData(form)
	form.onsubmit = (event)=>{
		event.preventDefault();
	}
	let req14 = new XMLHttpRequest
	req14.open('POST', 'storno.php?t='+Date.now(), true);
	req14.onload = () =>{
		if(req14.readyState == 4 && req14.status == 200){
			console.log(req14.responseText);
			document.getElementById('outpout').innerHTML = req14.responseText
		}
	}
	req14.send(formData)
}

//Alle Benutzerkonten einsehen
function kontensehen(){
	let req5 = new XMLHttpRequest
	req5.open('POST', 'kontosehen.php?t='+Date.now())
	req5.onreadystatechange = function (){
		if(req5.readyState == 4 && req5.status == 200){
			document.getElementById('main').innerHTML = req5.responseText
		}
	}
	req5.send()
}

//Konten loeschen
function loeschen(userID){
	let formID = "theform" + userID
	const form = document.getElementById(formID)
	let formData = new FormData(form)
	form.onsubmit = (event)=>{
		event.preventDefault();
	}
	let req13 = new XMLHttpRequest
	req13.open('POST', 'kontoloeschen.php?t='+Date.now(), true);
	req13.onload = () =>{
		if(req13.readyState == 4 && req13.status == 200){
			document.getElementById('outpout').innerHTML = req13.responseText
			setTimeout(kontensehen,5000)
		}
	}
	req13.send(formData)
}


// Aufruf vom Loginformular, das vor dem Submit-Event überprüft wird
function loginformular(){
	document.getElementById('main').innerHTML = "<div id='outpout'></div><br><br><div id='main'><h2>Sing up</h2><br><div class='input_contents'><form class='login-form' id='myform' autocomplete='on' method='POST'><label for='email' class='eingabe'>E-Mail</label><input type='email' name='email' id='email' required/><br><br><br><label for='password' class='eingabe'>Password</label><input autocomplete='on' type='password' name='password' id='password'/><br><br><br><button type='submit' name='einloggen' id='submit'>Einloggen</button></form></div></div>"
	document.getElementById('myform').addEventListener('submit', function(event){
	 	event.preventDefault()
	 	anmelden()
	});
}

//Funktion mitmachen bei nicht angemeldeter Person
function youshallnotpass(){
	document.getElementById('main').innerHTML = "<div id='main' class='eingabe' style='font-size: 40px'><h3>Hier können Sie später alle die Kurse einsehen, für die Sie sich angemeldet haben. Aber Sie müssen sich im Voraus anmelden</h3></div>"
}

//Registrierformular anzeigen und auf Fehler überprüfen
function registrierungsformular(){
	document.getElementById('main').innerHTML = "<div id='outpout' class='output'></div><br><br><div id='main'><h2>Konto erstellen</h2><br><br><br><div class='input_contents'><form autocomplete='on' id='myform2' class='reg-form' method='POST'><label for='nachname' class='eingabe' >Nachname: </label><input type='text' name='nachname' id='nachname' required /><br><br><label for='vorname' class='eingabe' >Vorname: </label><input type='text' name='vorname' id='vorname' required /><br><br><label for='email' class='eingabe' >E-Mail: </label><input id='email' type='email' name='email' required /><br><br><label for='geburtsort' class='eingabe' >Geburtsort: </label><input id='geburtsort' type='text' name='geburtsort' required /><br><br><label for='geburtsdatum' class='eingabe' >Geburtsdatum: </label><input id='geburtsdatum'  type='date' name='geburtsdatum' max='2005-01-01' required /><br><br><label for='password1' class='eingabe' >Password: </label><input id='password1' type='password' name='password1' autocomplete='on' /><br><br><label for='password2' class='eingabe' >Password wiederholen: </label><input id='password2' type='password' name='password2' autocomplete='on' /><br><br><button type='submit' id='submit' name='erstellen' value='abschicken'>erstellen</button></form></div></div>"
	document.getElementById('myform2').addEventListener('submit', function(event){
	 	event.preventDefault()
		registrieren()
	 });
	if(document.getElementById('login') !== null){
		document.getElementById('login').addEventListener('click', loginformular)

	}
}
//Request an kursbuchen
function mitmachen(){
	const form = document.getElementById('theform4')
	let formData = new FormData(form)
	form.onsubmit = (event)=>{
		event.preventDefault();
	}
	let req8 = new XMLHttpRequest
	req8.open('POST', 'kursbuchen.php?t='+Date.now(), true);
	req8.onload = () =>{
		if(req8.readyState == 4 && req8.status == 200){
			document.getElementById('outpout').innerHTML = req8.responseText
		}
	}
	req8.send(formData)
}

//Formularverarbeitung für die Anmeldung
function anmelden(){
	const form = document.getElementById('myform')
	let formData = new FormData(form)
	form.onsubmit = (event)=>{
		event.preventDefault();
	}
	let req2 = new XMLHttpRequest
	req2.open('POST', 'login.php?t='+Date.now(), true);
	req2.onload = () =>{
		if(req2.readyState == 4 && req2.status == 200){
			document.getElementById('outpout').innerHTML = req2.responseText
			navbar(event)
			setTimeout(function(){window.location.reload()}, 2000)
		}
	}
	req2.send(formData)
}

function registrieren(){
	const form = document.getElementById('myform2')
	registrierung(form)	
}

//Fehlermeldung bei dem Registrieformular suchen und zugleich registrieren, wennn alles okay ist
function registrierung(form){
	const password1 = document.getElementById('password1')
	const password2 = document.getElementById('password2')
	const outpout = document.getElementById('outpout')
	let valeur = false
	form.addEventListener("submit", (e) =>{
		let passwordInput1 = password1.value
		let passwordInput2 = password2.value
		let errors = findErrors2(passwordInput1, passwordInput2)
		if(errors.length > 0){
			e.preventDefault()
			valeur = true
			outpout.innerHTML = errors.join(". ")
			outpout.classList.add("red-message")
			password1.classList.add("red-input")
			password2.classList.add("red-input")
		}

		password1.addEventListener("input", ()=>{
			password1.classList.remove("red-input")
			password2.classList.remove("red-input")
			outpout.innerHTML = ''
		})
	})
	if(valeur == false){
		let formData = new FormData(form)
		form.onsubmit = (event)=>{
			event.preventDefault();
		}
		let req2 = new XMLHttpRequest
		req2.open('POST', 'registrieren.php?t='+Date.now(), true);
		req2.onload = () =>{
			if(req2.readyState == 4 && req2.status == 200){
				document.getElementById('outpout').innerHTML = req2.responseText
			}
		}
		req2.send(formData)
	}
}

function findErrors2(password1, password2){
	let errorMessages = []

	if(password1 == null || password1 == '' || password2 == null || password2 == ''){
		errorMessages.push("<i>Kein Password eingegeben<i>")
	}
	if(password1 !== password2){
		errorMessages.push("<i>Die beiden Pässwörter stimmen nicht überein<i>")
	}

	return errorMessages
}
//Verwaltung der Navbar und main Inhalt. Callback von anderen Funktionen
function navbar(event){
	let req1 = new XMLHttpRequest()
	req1.onreadystatechange = function xhr(){
		if(req1.readyState == 4 && req1.status == 200){
			
			document.getElementById('navbar').innerHTML = req1.responseText

			if(document.getElementById('home') !== null){
				document.getElementById('home').addEventListener('click', home)
			}
			if(document.getElementById('youshallnotpass')!== null){
				document.getElementById('youshallnotpass').addEventListener('click', youshallnotpass)
			}
			if(document.getElementById('kurse')!== null){
				document.getElementById('kurse').addEventListener('click', allfitnesskurse)
			}
			if(document.getElementById('kurse2')!== null){
				document.getElementById('kurse2').addEventListener('click', kurse2)
			}
			if(document.getElementById('login') !== null){
				document.getElementById('login').addEventListener('click', loginformular)
			}
			if(document.getElementById('registrieren') !== null){
				document.getElementById('registrieren').addEventListener('click', registrierungsformular)
			}
			if(document.getElementById('logout') !== null){
				document.getElementById('logout').addEventListener('click', logout)
			}
			if(document.getElementById('benutzerkonten') !== null){
				document.getElementById('benutzerkonten').addEventListener('click', kontensehen)
			}
			if(document.getElementById('katalog') !== null){
				document.getElementById('katalog').addEventListener('click', katalog)
			}
			if(document.getElementById('registed') !== null){
				document.getElementById('registed').addEventListener('click', anmeldungen)
			}
			if(document.getElementById('aendern') !== null){
				document.getElementById('aendern').addEventListener('click', status)
			}
			while(document.getElementById('abmelden') !== null){
				document.getElementById('abmelden').addEventListener('submit', preventDefault)
			}
		}
	}
	req1.open('GET', 'navbar.php?t='+Date.now(), true)
	req1.send()	
}
//Auswhliste für alle Anmeldungen
function anmeldungen(){
	let req10 = new XMLHttpRequest
	req10.open('POST', 'kursliste.php?t='+Date.now(), true)
	function count2(){
		if(req10.readyState == 4 && req10.status == 200){
			document.getElementById('main').innerHTML = req10.responseText
			if (document.getElementById('theform6') !== null) {
        		document.getElementById('theform6').addEventListener('submit', function (event) {
               		event.preventDefault();
              		allanmeldungen()
            	});	
			} else {
				console.log('nicht gefunden')
			}
		}
	}
	req10.onreadystatechange = count2
	req10.send()
}

//Request an allanmeldungen.php
function allanmeldungen(){
	const form = document.getElementById('theform6')
	let formData = new FormData(form)
	form.onsubmit = (event)=>{
		event.preventDefault();
	}
	let req11 = new XMLHttpRequest
	req11.open('POST', 'allanmeldungen.php?t='+Date.now(), true);
	req11.onload = () =>{
		if(req11.readyState == 4 && req11.status == 200){
			document.getElementById('outpout').innerHTML = req11.responseText
		}
	}
	req11.send(formData)
}
//Anzeigen der Kursliste für die Statusänderung
function status(){
	let req12 = new XMLHttpRequest
	req12.open('POST', 'statusform.php?t='+Date.now(), true)
	function count2(){
		if(req12.readyState == 4 && req12.status == 200){
			document.getElementById('main').innerHTML = req12.responseText
			if (document.getElementById('theform8') !== null) {
        		document.getElementById('theform8').addEventListener('submit', function (event) {
               		event.preventDefault();
              		aendern()
            	});	
			} else {
				console.log('nicht gefunden')
			}
		}
	}
	req12.onreadystatechange = count2
	req12.send()
}

//Ajax-Aufruf vom entsprechenden Php-Skript für die Statusänderung
function aendern(){
	const form = document.getElementById('theform8')
	let formData = new FormData(form)
	form.onsubmit = (event)=>{
		event.preventDefault();
	}
	let req11 = new XMLHttpRequest
	req11.open('POST', 'statusaendern.php?t='+Date.now(), true);
	req11.onload = () =>{
		if(req11.readyState == 4 && req11.status == 200){
			document.getElementById('outpout').innerHTML = req11.responseText
		}
	}
	req11.send(formData)
}


function logout(){
	let req3 = new XMLHttpRequest
	req3.open('POST', 'logout.php?t='+Date.now())
	function count2(){
		if(req3.readyState == 4 && req3.status == 200){
			document.getElementById('main').innerHTML = req3.responseText
			setTimeout(function(){window.location.reload()}, 2000)
		}
	}
	req3.onreadystatechange = count2
	req3.send()
}

function init(event){
	navbar(event)
}
window.onload = init;
