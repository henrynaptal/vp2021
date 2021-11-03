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
	$film_html = null;
	$film_html = read_all_films();
	
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
	<h2>Eesti filmid</h2>
	<?php echo $film_html; ?>
</body>
</html>