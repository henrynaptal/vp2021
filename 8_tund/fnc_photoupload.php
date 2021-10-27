<?php
    function save_image($image, $file_type, $target) {
		$notice = null;
		
		if($file_type == "jpg"){
			if(imagejpeg($image, $target, 90)){
				$notice = "Foto salvestatud edukalt!";
			} else {
				$notice = "Foto salvestamine ebaõnnestus!";
			}
		}
		if($file_type == "png"){
			if(imagepng($image, $target, 6)){
				$notice = "Foto salvestatud edukalt!";
			} else {
				$notice = "Foto salvestamine ebaõnnestus!";
			}
		}
		if($file_type == "gif"){
			if(imagegif($image, $target)){
				$notice = "Foto salvestatud edukalt!";
			} else {
				$notice = "Foto salvestamine ebaõnnestus!";
			}
		}
		
		return $notice;
	}       
        



?>