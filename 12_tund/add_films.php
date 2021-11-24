<?php
    session_start();
	
    if(!isset($_SESSION["user_id"])){
        header("Location: page.php");
    }
	
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: page.php");
    }



    require_once("../../../config.php");
	require_once("fnc_films.php");
	//echo $server_host;
    $author_name = "Henry Naptal";
	$film_store_notice = null;
	$title_input = null;
    $genre_input = null;
    $studio_input = null;
    $director_input = null;
    $film_store_notice = null;
    $film_store_notice_title = null;
    $film_store_notice_genre = null;
    $film_store_notice_studio = null;
    $film_store_notice_dir = null;

	
	
	if(isset($_POST["film_submit"])){
		if(!empty($_POST["title_input"]) and !empty($_POST["genre_input"]) and !empty($_POST["studio_input"]) and !empty($_POST["director_input"])){
			$film_store_notice = store_film ($_POST["title_input"], $_POST["year_input"], $_POST["duration_input"], $_POST["genre_input"], $_POST["studio_input"], $_POST["director_input"]);
		}
	     	if(empty($_POST["title_input"])) {
		$film_store_notice_title = "Palun sisestage filmi pealkiri.";
	    } if(empty($_POST["genre_input"])) {
		$film_store_notice_genre = "Palun sisestage filmi zanr.";	
	    } if(empty($_POST["studio_input"])) {
		$film_store_notice_studio = "Palun sisestage filmi tootja.";
	    } if(empty($_POST["director_input"])) {
		$film_store_notice_dir = "Palun sisestage filmi rezissöör.";
	    } else {
		$title_input = $_POST["title_input"];
		$genre_input = $_POST["genre_input"];
		$studio_input = $_POST["studio_input"];
		$director_input = $_POST["director_input"];	
		}
	}
	
	require("page_header.php");

?>
    <h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
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
	<h2>Eesti filmide lisamine</h2>
	<form method="POST">
        <label for="title_input">Filmi pealkiri</label>
        <input type="text" name="title_input" id="title_input" placeholder="filmi pealkiri" value="<?php echo $title_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_title; ?></span>
        <br>
        <label for="year_input">Valmimisaasta</label>
        <input type="number" name="year_input" id="year_input" min="1912" value="<?php echo date("Y"); ?>">
        <br>
        <label for="duration_input">Kestus</label>
        <input type="number" name="duration_input" id="duration_input" min="1" value="60" max="600">
        <br>
        <label for="genre_input">Filmi žanr</label>
        <input type="text" name="genre_input" id="genre_input" placeholder="žanr" value="<?php echo $genre_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_genre; ?></span>
        <br>
        <label for="studio_input">Filmi tootja</label>
        <input type="text" name="studio_input" id="studio_input" placeholder="filmi tootja" value="<?php echo $studio_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_studio; ?></span>
        <br>
        <label for="director_input">Filmi režissöör</label>
        <input type="text" name="director_input" id="director_input" placeholder="filmi režissöör" value="<?php echo $director_input; ?>">
		<span style="color:red;"><?php echo $film_store_notice_dir; ?></span>
        <br>
        <input type="submit" name="film_submit" value="Salvesta">
    </form>
</body>
</html>