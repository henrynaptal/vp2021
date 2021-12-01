<?php
    $database = "if21_henry_naptal";
	
	function read_all_person_for_select($selected){
		$options_html = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT * FROM person");
		echo $conn->error;
		$stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $date_of_birth_from_db);
		$stmt->execute();
		while($stmt->fetch()){
			$options_html .= '<option value="' .$id_from_db .'"';
			if($id_from_db == $selected){
				$options_html .= " selected";
			}
			$options_html .= ">" .$firstname_from_db ." " .$lastname_from_db ." (" .$date_of_birth_from_db .")</options> \n";
		}
		$stmt->close();
		$conn->close();
		return $options_html;
	}
	
	function read_all_movie_for_select($selected){
        $options_html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, title, production_year FROM movie");
        echo $conn->error;
        $stmt->bind_result($id_from_db, $title_from_db, $production_year_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $options_html .= '<option value="' .$id_from_db .'"';
            if($id_from_db == $selected){
                $options_html .= " selected";
            }
            $options_html .= ">" .$title_from_db ." (" .$production_year_from_db .")</options> \n";
        }
        
        $stmt->close();
        $conn->close();
        return $options_html;
    }
		
	function read_all_position_for_select($selected){
        $options_html = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, position_name FROM position");
        echo $conn->error;
        $stmt->bind_result($id_from_db, $position_name_from_db);
        $stmt->execute();
        while($stmt->fetch()){
            $options_html .= '<option value="' .$id_from_db .'"';
            if($id_from_db == $selected){
                $options_html .= " selected";
            }
            $options_html .= ">" .$position_name_from_db ."</options> \n";
        }
        
        $stmt->close();
        $conn->close();
        return $options_html;
    }
	
	function store_person_movie_relation($selected_person, $selected_movie, $selected_position, $role){
        echo $selected_person .$selected_movie .$selected_position .$role ."ahaa";
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, role FROM person_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ?");
        echo $conn->error;
        $stmt->bind_param("iii", $selected_person, $selected_movie, $selected_position);
        $stmt->bind_result($id_from_db, $role_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            if($role_from_db == $role){
                //selline on olemas
                $notice = "Selline seos on juba olemas!";
            }
        }
		
	}
		
    /* function store_person_photo($file_name, $person_id){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, role FROM person_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ?");
		$stmt->bind_param("iii", $selected_person, $selected_movie, $selected_position);
		$stmt->bind_result($id_from_db, $role_from_db);
	} */
	