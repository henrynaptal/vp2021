<?php



    require_once("use_session.php");
    require_once("../../../config.php");
	require_once("fnc_user.php");
	require_once("fnc_general.php");
	$notice = null;
	$description = read_user_description();
	
	if(isset($_POST["profile_submit"])){
		$description = test_input(filter_var($_POST["description_input"], FILTER_SANITIZE_STRING));
		$notice = store_user_profile($description, $_POST["bg_color_input"],$_POST["text_color_input"]);
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
	   <li><a href="?logout=1">Logi välja</a></li>
	   <li><a href="home.php">Avaleht</a></li>
	<form method="POST">
        <label for="description_input">Lühikirjeldus</label>
		<br>
		<textarea name="description_input" id="description_input" rows="10" cols="80" placeholder="Minu lühikirjeldus..."><?php echo $description; ?></textarea>
		<br>
		<label for="bg_color_input">Taustavärv</label>
        <br>
		<input type="color" name="bg_color_input" id="bg_color_input" value="#FFFFFF">
		<br>
		<label for="text_color_input">Tekstivärv</label>
		<br>
		<input type="color" name="text_color_input" id="text_color_input" value="#000000">
		<br>
        <input type="submit" name="profile_submit" value="Salvesta">
    </form>
</body>
</html>