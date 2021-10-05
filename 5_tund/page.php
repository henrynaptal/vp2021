<?php
    session_start();
    require_once("../../../config.php");
    require_once ("fnc_user.php");
	$author_name = "Henry Naptal";
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_now = date ("N");
	$day_category = "lihtsalt päev";
	$hour_now = date("H");
	$hour_category = "Tavaline aeg";
	
	//  võrdub == suurem/väiksem ... < >   <=  >= pole võrdne (excelis <>) !=
	
	//echo $weekday_names_et[2];
	
	//if($hour_now < 7 or $hour_now > 23)
	  
    //kontrollin, kas POST info jõuab kusagile 
     //var_dump($_POST)
	 //kontrollime, kas klikiti submit nuppu
	 $todays_adjective_html = null;
	 $todays_adjective_error = null;
	 if(isset($_POST["adjective_submit"])){
		 //echo "Aitäh kirjutamast! :)";
		 //<p>Aitäh kirjutamast.</p>
		 if(!empty($_POST["todays_adjective_input"])){
		 
		 $todays_adjective_html = "<p>Aitäh kirjutamast: " .$_POST["todays_adjective_input"] .".</p>";
		 } else {
			 $todays_adjective_error = "Te ei sisestanud midagi.";
			 }
	 }
	 
	 
	 
	//juhusliku foto lisamine
	$photo_dir = "photos/";
	//loen kataloogi sisu
	$all_files = scandir($photo_dir);
	$all_real_files = array_slice($all_files, 2);
	
	//sõelume välja päris pildid
	
	$photo_files = [];
	$allowed_photo_types = ["image/jpeg", "image/png"];
	foreach($all_real_files as $file_name) {
		$file_info = getimagesize($photo_dir .$file_name);
		if(isset($file_info["mime"])) {
			if(in_array($file_info["mime"], $allowed_photo_types)) {
				array_push($photo_files, $file_name);
			} //if in_array lõppeb
		} //if isset lõppeb
			
	} //foreach lõppes
	
	
	//var_dump($all_real_files);
	
	//loen massiivi elemendid kokku
	//loosin juhusliku arvu (esimene peab olema 0 ja max peab olema count - 1)
	$file_count = count($photo_files);
	$limit = count($photo_files);
	if (isset($_POST["photo_select"])){
		$photo_num = $_POST["photo_select"];
	}
	else{
		$photo_num = mt_rand(0, $limit - 1);
	}
	
	$photo_file = $photo_files[$photo_num];

	//<img src="kataloog/fail" alt="Tallinna Ülikool">
	$photo_html = '<img src="' .$photo_dir .$photo_files[$photo_num] .'"alt="Tallinna Ülikool"><p>' . $photo_file . '</p>';	
	
	//tsükkel
	//näiteks:
	//<ul>
	//      <li>pildifailinimi1.jpg</li>
	//      ....
	//</ul>
	

	
	$photo_list_html = "<ul> Valida saad nende piltide seast:";
	for($i = 0;$i < $file_count;$i ++) {
		$photo_list_html .= "<li>" .$photo_files[$i] ."</li> \n";
		}
	$photo_list_html .= "</ul>";
	
	
	$photo_select_html = '<select name="photo_select">' ."\n";
	for($i = 0; $i < $limit; $i++){
		if ($i == $photo_num){
			$photo_select_html .= '<option value="'. $i .'" selected>'. $photo_files[$i] .'</option>' . " \n";
		}
		else{
			$photo_select_html .= '<option value="' . $i . '">'. $photo_files[$i] .'</option>' . " \n";
		}
	}
	$photo_select_html .= '</select>';

	//Sisselogimine
	$notice = null;
	if(isset($_POST["login_submit"])){
		$notice = sign_in($_POST["email_input"], $_POST["password_input"]);
	}
	
	
	
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
	<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
</head>
<body>
    <h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<style type="text/css">
	      body
		  {
			  padding: 0;
			  margin: 0;
	          background: #17a9e8;
		  }
		  h1
		  {
			  font-size: 4em;
			  margin: 0;
			  padding: 0;
			  text-align: center;
		  }
	</style>
	<p>See leht on loodud õppetöö raames ning ei sisalda tõsiseltvõetavat sisu.</p>
	<p>Õppetöö toimub <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate Instituudis</a>.</p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	    <input type="email" name="email_input" placeholder="Kasutajatunnus ehk e-post">
		<input type="password" name="password_input" placeholder="Parool">
		<input type="submit" name="login_submit" value="Logi sisse"><span><?php echo $notice; ?></span>
	</form>
	<p>Loo endale <a href="add_user.php">kasutajakonto</a></p>
	<form method="POST">
	     <input type="text" placeholder="kirjuta mulle midagi :)" name="todays_adjective_input">
		 <input type="submit" name="adjective_submit" value="Saada ära!">
		 <span><?php echo $todays_adjective_error; ?></span>
		 </form>
	<?php echo $todays_adjective_html; ?>
		<form method="POST">
	    <?php echo $photo_select_html; ?> 
		<input type="submit" name="submit_photo" value="Kuva pilt!">
		</form>
	<hr>
    <?php echo $photo_html;
	echo $photo_list_html;
	?>

</body>
</html>