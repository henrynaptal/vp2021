<?php
$database = "if21_henry_naptal";

function sign_up($firstname, $surname, $email, $gender, $birth_date, $password){
	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("INSERT INTO vprg_users (firstname, lastname, birthdate, gender, email, password) values(?,?,?,?,?,?)");
	echo $conn->error;
	//krüpteerime parooli
	$option = ["cost" => 12];
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
	$stmt->bind_param("sssiss", $firstname, $surname, $birth_date, $gender, $email, $pwd_hash);
	if($stmt->execute()){
		$notice = " Uus kasutaja edukalt loodud!";
	} else {
		$notice = "Tekkis viga uue kasutaja loomisega!" .$stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

function sign_in($email, $password){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM vprg_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            if(password_verify($password, $password_from_db)){
                $_SESSION["user_id"] = $id_from_db;
                $_SESSION["first_name"] = $firstname_from_db;
                $_SESSION["last_name"] = $lastname_from_db;
				$stmt->close();
                $conn->close();
                header("Location: home.php");
                exit();
            } else {
                $notice = "Kasutajanimi voi parool on vale!";
            }
        } else {
            $notice = "Kasutajanimi voi parool on vale!";
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }
	