<?php
    require_once("../../../config.php");
	require_once("fnc_films.php");
	//echo $server_host;
    $author_name = "Henry Naptal";
	$film_html = null;
	$film_html = read_all_films();
	

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
	<h2>Eesti filmid</h2>
	<?php echo $film_html; ?>
</body>
</html>