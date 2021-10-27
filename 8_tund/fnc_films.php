<?php
    $database = "if21_henry_naptal";
	
	function read_all_films(){
		$database = "if21_henry_naptal";
	    //loon andmebaasiga ühenduse: server, kasutaja, parool, andmebaas
	    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	    //määrame korrektse kooditabeli
	    $conn->set_charset("utf8");
	    //valmistan ette SQL käsu. stmt - statement
	    //SELECT * FROM film - tärn * tähendab kõike!
	    $stmt = $conn->prepare("SELECT * FROM film");
	    echo $conn->error;
	    //seome tulemused muutujatega
	    $stmt->bind_result($title_from_db, $year_from_db, $duration_from_db, $genre_from_db, $studio_from_db, $director_from_db);
	    //anname käsu täitmiseks
	    $film_html = null;
	    $stmt->execute();
	    //võtan andmed
	    while($stmt->fetch()){
	    //paneme andmed meile sobivasse vormi
	    $film_html .= "\n <h3>" .$title_from_db . "</h3> \n <ul> \n";
	    $film_html .= "<li>Valmimisaasta: " .$year_from_db ."</li> \n";
	    $film_html .= "<li>Kestus: " .$duration_from_db ."</li> \n";
	    $film_html .= "<li>Zanr: " .$genre_from_db ."</li> \n";
	    $film_html .= "<li>Tootja: " .$studio_from_db ."</li> \n";
	    $film_html .= "<li>Lavastaja: " .$director_from_db ."</li> \n";
	    $film_html .= "</ul> \n";
	    }
		//sulgeme käsu
		$stmt->close();
		//sulgeme andmebaasi ühenduse
		$conn->close();
		return $film_html;
	}
	
	function store_film($title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input){
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	    $conn->set_charset("utf8");
		//"INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES("Suvi", 1976, 80, "Komöödia", "Tallinnfilm", "Arvo Kruusement")"
		$stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
		echo $conn->error;
		//Seome SQL käsu päris andmetega
		//andmetüübid: i - integer, d - decimal, s - string
		$stmt->bind_param("siisss", $title_input, $year_input, $duration_input, $genre_input, $studio_input, $director_input);
		$success = null;
		if($stmt->execute()){
			$success = "Edukalt salvestatud!";
		} else {
			$success = "Error 404: " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $success;
	}






?>