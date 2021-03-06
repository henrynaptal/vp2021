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
	require_once("fnc_photoupload.php");
	require_once("fnc_general.php");
	
	$photo_upload_notice = null;
	$photo_upload_orig_dir = "../upload_photos_orig/";
	$photo_upload_normal_dir = "../upload_photos_normal/";
	$photo_upload_thumb_dir = "../upload_photos_thumb/";
	$photo_file_name_prefix = "vp_";
	$photo_file_size_limit = 2 * 1024 * 1024;
	$photo_width_limit = 600;
	$photo_height_limit = 400;
	$image_size_ratio = 1;
	$file_type = null;
	$file_name = null;
	$alt_text = null;
	$privacy = 1;
	$watermark_file = "../pics/vp_logo_w100_overlay.png";
	
	if(isset($_POST["photo_submit"])){
		//var_dump($_POST);
		//var_dump($_FILES);

		
		
		if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
		$image_check = getimagesize($_FILES["photo_input"]["tmp_name"]);
        if($image_check !== false){
            if($image_check["mime"] == "image/jpeg"){
                $file_type = "jpg";
            }
            if($image_check["mime"] == "image/png"){
                $file_type = "png";
            }
            if($image_check["mime"] == "image/gif"){
                $file_type = "gif";
            }
			
			//teeme failinime
			//genereerin ajatempli
			
		} else {
			$photo_upload_notice .= "Valitud fail ei ole pilt!";
		}
	} else {
		$photo_upload_notice .= " Pilt on valimata!";
	}
	if(empty($photo_upload_notice) and $_FILES["photo_input"]["size"] > $photo_file_size_limit){
		$photo_upload_notice .= "Pildifail on liiga suur!";
	} 
	
		if(empty($photo_upload_notice)){
			$time_stamp = microtime(1) * 10000;
			$file_name = $photo_file_name_prefix .$time_stamp ."." .$file_type;
			
			//muudame pildi suurust
			//loome image objekti ehk pikslikogumi
			if($file_type == "jpg"){
				$my_temp_image = imagecreatefromjpeg($_FILES["photo_input"]["tmp_name"]);
			}
			if($file_type == "png"){
				$my_temp_image = imagecreatefrompng($_FILES["photo_input"]["tmp_name"]);
			}
			if($file_type == "gif"){
				$my_temp_image = imagecreatefromgif($_FILES["photo_input"]["tmp_name"]);
			}
			//pildi originaal m????dud
			$image_width = imagesx($my_temp_image);
			$image_height = imagesy($my_temp_image);
			if($image_width / $photo_width_limit > $image_height / $photo_height_limit){
				$image_size_ratio = $image_width / $photo_width_limit;
			} else {
				$image_size_ratio = $image_height / $photo_height_limit;
			}
			$image_new_width = round($image_width / $image_size_ratio);
			$image_new_height = round($image_height / $image_size_ratio);
			//loome uue v??iksema pildiobjekti
			$my_new_temp_image = imagecreatetruecolor($image_new_width, $image_new_height);
			imagecopyresampled($my_new_temp_image, $my_temp_image, 0, 0, 0, 0, $image_new_width, $image_new_height, $image_width, $image_height);
			
			//lisan watermarki pildile
			$watermark = imagecreatefrompng($watermark_file);
			$watermark_width = imagesx($watermark);
			$watermark_height = imagesy($watermark);
			$watermark_x = $image_new_width - $watermark_width - 10;
			$watermark_y = $image_new_height - $watermark_height - 10;
			imagecopy($my_new_temp_image, $watermark, $watermark_x, $watermark_y, 0, 0, $watermark_width, $watermark_height);
			imagedestroy($watermark);
			
			//salvestamine
			$photo_upload_notice = save_image($my_new_temp_image, $file_type, $photo_upload_normal_dir .$file_name);
			//k??rvaldame pikslikogumi, et m??lu vabastada
			imagedestroy($my_new_temp_image);
			
			
			
			//imagedestroy($my_temp_image);
			
			if(move_uploaded_file($_FILES["photo_input"]["tmp_name"], $photo_upload_orig_dir .$file_name)){
				
			}
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
	<p>See leht on loodud ??ppet???? raames ning ei sisalda t??siseltv??etavat sisu.</p>
	<p>??ppet???? toimub <a href="https://www.tlu.ee/dt">Tallinna ??likooli Digitehnoloogiate Instituudis</a>.</p>
	<hr>
	   <li><a href="?logout=1">Logi v??lja</a></li>
	   <li><a href="home.php">Avaleht</a></li>
	<h2>Galeriipiltide ??leslaadimine</h2>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" enctype="multipart/form-data">
	<label for="photo_input">Vali pildifail</label>
	<input type="file" name="photo_input" id="photo_input">
	<br>
	<label for="alt_input">Alternatiivtekst (alt):</label>
	<input type="text" name="alt_input" id="alt_input" placeholder="alternatiivtekst..." value="<?php echo $alt_text; ?>">
	<br>
	<input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if($privacy == 1){echo " checked";} ?>>
	<label for="privacy_input_1">Privaatne</label>
	<br>
	<input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if($privacy == 1){echo " checked";} ?>>
	<label for="privacy_input_2">Teised kasutajad n??evad</label>
	<br>
	<input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if($privacy == 1){echo " checked";} ?>>
	<label for="privacy_input_3">Avalik</label>
	<br>
	
    <input type="submit" name="photo_submit" value="Lae pilt ??les">
	</form>
	<span><?php echo $photo_upload_notice; ?></span>
</body>
</html>