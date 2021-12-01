<?php
    require_once("use_session.php");


    require_once("../../../config.php");
	require_once("fnc_photoupload.php");
	require_once("fnc_general.php");
	require_once("classes/Photoupload.class.php");
	
	$news_error = null;
	$news_notice = null;
	$news_title = null;
	$news = null;
	
	$expire = new DateTime("now");
	$expire->add(new DateInterval("P7D"));
	$expire_date = date_format($expire, "Y-m-d");

    $normal_photo_max_width = 600;
    $normal_photo_max_height = 400;
	$thumbnail_width = $thumbnail_height = 100;
    $watermark_file = "../pics/vp_logo_w100_overlay.png";
	$photo_file = null;
    
    $photo_filename_prefix = "vp_news";
    $photo_upload_size_limit = 1024 * 1024;
    $allowed_photo_types = ["image/jpeg", "image/png"];
    $photo_size_ratio = 1;
    
    if(isset($_POST["news_submit"])){
        //kui uudisele on vlaitud foto, siis selle salvestan esimesena ja lisan esimesna ka andmetabelisse
		//siis lisan uudise koos uudise pealkirja, aegumise ja foto id-ga eraldi andmetabelisse
		//andmetabelisse salvestamisel saan p'rast execute() k2sku just salvestatud kirje id k2tte:
		//$muutuja = $conn->insert_id;
		//uudise sisu peaks labima funktsiooni test_input (fnc_general.php).
		//seal on htmlspecialchars funkltsioon, mis teisendab html m2rgised (nt. <--> &lt;   )
		//tagasi saab: htmlspecialchars_decode(uudis andmebaasist)
		
		//aegumistahtaja saan date inputist.
		//uudiste naitamisel vordlen SQL lauses andmebaasis olevat aegumiskuupaeva t2nasega.
		//$today = date("Y-m-d");
		//SQL-is WHERE expire >= ?
		if(empty($_POST["title_input"])){
			$news_error = "Uudise pealkiri on puudu!";
		} else {
			$news_title = test_input($_POST["title_input"]);
		}
		if(empty($_POST["news_input"])){
			$news_error .= " Uudise sisu on puudu!";
		} else {
			$news = test_input($_POST["news_input"]);
		}

		if(!empty($_POST["expire_input"])){
			$expire_date = $_POST["expire_input"];
			//echo $expire_date;
		} else {
			$news_error .= " Palun vali Aegumistähtaja päev!";
		}
		if($expire_date < date("Y-m-d")){
			$news_error .= " Aegumistähtaeg on minevikus!";
		}

		//kas foto on valitud
        if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
			$photo_upload = new Photoupload($_FILES["photo_input"]);
			if(empty($photo_upload->error)){
				$photo_upload->check_alowed_type($allowed_photo_types);
				if(empty($photo_upload->error)){
					$photo_upload->check_size($photo_upload_size_limit);
					if(empty($photo_upload->error) and empty($news_error)){
						$photo_upload->create_filename($photo_filename_prefix);
						$photo_upload->resize_photo($normal_photo_max_width, $normal_photo_max_height);
						$news_notice = "Uudise pildi " .$photo_upload->save_image($photo_news_upload_dir .$photo_upload->file_name);
						$photo_file .= $photo_upload->file_name;
						echo $photo_file;
					}
				}
			}
			$news_error .= $photo_upload->error;

			unset($photo_upload);
		}
		if(empty($news_error)){
			$news_notice .= save_news($news_title, $news, $expire_date, $photo_file);
		}
    }
	$to_head = '<script src="javascript/checkFileSize.js" defer></script>' ."\n";
    $to_head = '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>' ."\n";
    require("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Tagasi</a></li>
    </ul>
	<hr>
    <h2>Uudise lisamine</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	    <label for="title_input">Uudise pealkiri</label>
        <input type="text" id="title_input" name="title_input" value="<?php echo $news_title; ?>">
        <br>
	    <label for="news_input">Uudise sisu</label>
		<br>
		<textarea id="news_input" name="news_input"><?php echo htmlspecialchars_decode($news); ?></textarea>
		<script>CKEDITOR.replace( 'news_input' );</script>
		<br>
		<label for="expire_input">Uudis aegub pärast:</label>
		<input type="date" id="expire_input" name="expire_input" value="<?php echo $expire_date; ?>"
		<br>
        <label for="photo_input"> Vali pildifail! </label>
        <input type="file" name="photo_input" id="photo_input">
        <br>
        
        <input type="submit" name="news_submit" id="news_submit" value="Salvesta uudis"><span id="notice"><?php echo $news_error; ?></span>
    </form>
    <span><?php echo $news_notice ?></span>
</body>
</html>