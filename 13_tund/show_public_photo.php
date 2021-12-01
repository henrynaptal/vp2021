<?php

    require_once("classes/SessionManager.class.php");
    SessionManager::sessionStart("vp", 0, "/~hennap/vp2021/13_tund", "greeny.cs.tlu.ee");
	
	$id = null;
	$type = "image/png";
	$output = "../pics/wrong.png";
	
	if(isset($_GET["photo"]) and !empty($_GET["photo"])){
		$id = filter_var($_GET["photo"], FILTER_VALIDATE_INT);
	}
	
	if(!empty($id)){
		require_once("../../../config.php");
		$database = "if21_henry_naptal";
		$conn = new mysqli($server_host, $server_user_name, $server_password, $database);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT filename from vprg_photos WHERE id - ? AND privacy - ? AND deleted IS NULL");
		$privacy = 3
		$stmt->bind_param("ii", $id, $privacy);
		$stmt->bind_result($filename_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$output = $photo_upload_normal_dir .$filename_from_db;
			$check = getimagesize($output)
			$type = $check["mime"];
		}
		$stmt->close();
		$conn->close();
	}
	
	header("content-type: " .$type);
	readfile($output);