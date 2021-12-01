<?php
    require_once("use_session.php");
	
	$author_name = "Henry Naptal";
	
	//testin klassi
	/* require_once("classes/Test.class.php");
	$test_object = new Test(6);
	echo "Teadaolev avalik number: " .$test_object->known_number;
	$test_object->reveal();
	unset($test_object); */
	
	//küpsised
	// time() + sekundid, 86400 sekundit 24's tunnis (60 * 60 * 24)
	
	setcookie("vpvisitor", $_SESSION["first_name"] ." " .$_SESSION["last_name"], time() + (86400 * 8), "/~hennap/public_html/vp2021/12_tund", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
	$last_visitor = "pole teada";
	if(isset($_COOKIE["vpvisitor"]) and !empty($_COOKIE["vpvisitor"])){
		$last_visitor = $_COOKIE["vpvisitor"];
	}
	// cookie kustutamine, aegumine minevikus
	//time() - 3600
	
	
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
	<?php echo "<p>Eelmine külastaja " .$last_visitor ."</p> \n"; ?>
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
		<li><a href="add_news.php">Uudiste lisamine</a></li>
    </ul>
	    <br>
	    <h2>Uudised</h2>
	    <?php
	    echo latest_news(5);
        ?>


</body>
</html>