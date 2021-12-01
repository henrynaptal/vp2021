<?php
    require_once("classes/SessionManager.class.php");
    SessionManager::sessionStart("vp", 0, "/~hennap/vp2021/12_tund", "greeny.cs.tlu.ee");
	
	 require_once("../../../config.php");
	
    if(isset($_GET["photo"]) and !empty($_GET["photo"])){
		$id = filter_var($_GET["photo"], FILTER_VALIDATE_INT);
	}
	if(isset($_GET["rating"]) and !empty($_GET["rating"])){
		$rating = filter_var($_GET["rating"], FILTER_VALIDATE_INT);
	}
	
	$response = "Hinne teadmata!";
	
	if(!empty($id)){
		require_once("../../../config.php");
		$database = "if21_henry_naptal";
		$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
		$conn->set_charset("utf8");
		if(!empty($rating)){
			$stmt = $conn->prepare("INSERT INTO vprg_photoratings (photoid, userid, rating) VALUES(?, ?, ?)");
			echo $conn->error;
			$stmt->bind_param("iii", $id, $_SESSION["user_id"], $rating);
			$stmt->execute();
			$stmt->close();
		}
		//loeme keskmise hinde
		$stmt = $conn->prepare("SELECT AVG(rating) as avgValue FROM vprg_photoratings WHERE photoid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $id);
		$stmt->bind_result($score);
		$stmt->execute();
		if($stmt->fetch()){
			$response = "Hinne: " .round($score, 2);
		}
		$stmt->close();
		$conn->close();
	}
    echo $response;