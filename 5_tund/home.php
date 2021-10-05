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
	
	<ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="list_films.php">Filmide nimekiri</a></li>
		<li><a href="add_films.php">Lisage filme filmibaasi</a></li>
    </ul>

</body>
</html>