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
	require_once("fnc_gallery.php");
	$privacy = 2;
	
	//http://greeny.cs.tlu.ee/~hennap/vp2021/9_tund/gallery_public.php?page=2
	$page = 1;
	$limit = 10;
	$photo_count = count_own_photos();
	//kontrollime, mis lehel oleme ja kas selline lehekylg on voimalik
	if(!isset($_GET["page"]) or $_GET["page"] < 1){
        $page = 1;
    } elseif(round($_GET["page"] - 1) * $limit >= $photo_count){
        $page = ceil($photo_count / $limit);
    } else {
        $page = $_GET["page"];
    }
	$to_head = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' . "\n";
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
	<h2>Minu fotod</h2>
	<div class="gallery">
	    <p>
		    <?php
			if($page > 1){
                    echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span>';
                } else {
                    echo "<span>Eelmine leht</span>";
                }
                echo " | ";
                if($page * $limit < $photo_count){
                    echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a></span>';
                } else {
                    echo "<span>Järgmine leht</span>";
                }
			?>
		</p>
	    <?php echo read_own_photo_thumbs($page, $limit); ?>
	</div>
</body>
</html>