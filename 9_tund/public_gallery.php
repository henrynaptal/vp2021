<?php
    //Sessioon alga
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
	
	require_once("../../../config.php");
	require_once("fnc_gallery.php");
	
	$page = 1;
    $page_limit = 5;
    $photo_count = count_public_photos(2);
    if(!isset($_GET["page"]) or $_GET["page"] < 1){
        $page = 1;
    } elseif(round($_GET["page"] - 1) * $page_limit >= $photo_count){
        $page = ceil($photo_count / $page_limit);
    } else {
        $page = $_GET["page"];
    }
    
    $to_head = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' ."\n";
	
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
	<hr>
    <h2>Fotogalerii</h2>
    <p>
        <?php
            if($page > 1){
                echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span> |' ."\n";
            } else {
                echo "<span>Eelmine leht</span> | \n";
            }
            if($page * $page_limit < $photo_count){
                echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a></span>' ."\n";
            } else {
                echo "<span>Järgmine leht</span> \n";
            }
            
        ?>
    </p>
    <?php echo read_public_photo_thumbs($page_limit, $page); ?>
</body>
</html>