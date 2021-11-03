<?php
    //Sessioon algab
    session_start();
	    require ("fnc_user.php");
	
	//Vaatab, kas on sisselogitud
	if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
	//Lehelt väljalogimine
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }
	$author_name = "Henry Naptal";
	
	require("page_header.php");
	
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="utf-8">
	<title><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</title>
</head>
<body>
    <h1><?php echo $author_name; ?>, veebiprogrammeerimine</h1>
	<style type="text/css">
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
	
	<ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="list_films.php">Filmide nimekiri</a></li>
		<li><a href="add_films.php">Lisage filme filmibaasi</a></li>
		<li><a href="user_profile.php">Kasutajaprofiil</a></li>
		<li><a href="movie_relations.php">Filmi, isiku ja muude seoste loomine</a></li>
		<li><a href="gallery_photo_upload.php">Galeriipiltide üleslaadimine</a></li>
		<li><a href="gallery_public.php">Kasutajatele nähtav galerii</a></li>
		<li><a href="gallery_own.php">Minu fotode galerii</a></li>
    </ul>

</body>
</html>