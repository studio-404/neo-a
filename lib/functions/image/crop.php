<?php
namespace lib\functions\image;

use config\main as c;

class crop{
	public function dojob($f, $w, $h, $blackAndWhite){
		// $f = filter_input(INPUT_GET, "f"); 
		// $f = str_replace( array("\\",";","(",")"), array("","","",""), strip_tags($f));
		// $w = filter_input(INPUT_GET, "w"); 
		// $w = str_replace( array("\\",";","(",")"), array("","","",""), strip_tags($w));
		// $h = filter_input(INPUT_GET, "h"); 
		// $h = str_replace( array("\\",";","(",")"), array("","","",""), strip_tags($h));
 
		$img = $f;
		$w = is_null($w) ? $h : $w;
		$h = is_null($h) ? $w : $h;
		$ext = substr(strrchr($img, '.'), 1);
		if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'))){
			return false;
		} 
		
		$cache_file_name = sha1('crop_' . $img . $w . $h) . '.' . $ext;
		
		$file_path = c::PUBLIC_FOLDER_NAME.'/temporaty/' . $cache_file_name;

		ini_set("gd.jpeg_ignore_warning", 1);
		if (file_exists($file_path))
		{
		    return c::WEBSITE.$file_path;
		}
		else
		{
			$src = c::PUBLIC_FOLDER_NAME.'/temporaty/' . sha1('to_crop_' . $img . $w . $h) . '.' . $ext;
			
			$without = str_replace(c::WEBSITE, "", $img);
			
			@copy($without, $src);
			$this->make_thumb($src, $w, $h, $file_path, $ext, $blackAndWhite);
			@unlink($src);
			return c::WEBSITE.$file_path;
		}
	}


	private function make_thumb($img_name, $new_w, $new_h, $new_name = null, $ext, $blackAndWhite)
	{
		try
		{
		    switch($ext)
		    {
		        case 'JPEG':
		        case 'JPG':
		        case 'jpeg':
		        case 'jpg':
		            $src_img = imagecreatefromjpeg($img_name);
		            break;
		        case 'PNG':
		        case 'png':
		            $src_img = imagecreatefrompng($img_name);
		            break;
		        case 'GIF':
		        case 'gif':
		            $src_img = imagecreatefromgif($img_name);
		            break;
		        default:
		            return false;
		    }

		    $old_w = (imagesx($src_img)) ? imagesx($src_img) : 1;
		    $old_h = (imagesy($src_img)) ? imagesy($src_img) : 1;
		    $new_x = 0;
		    $new_y = 0;
		    if($old_h==0 || $new_h==0){ exit(); }
			
			if($old_w/$old_h > $new_w/$new_h) {
		        $orig_h = $old_h;
		        $orig_w = round($new_w * $orig_h / $new_h);
		        $new_x = ($old_w - $orig_w) / 2;
			} else {
		        $orig_w = $old_w;
		        $orig_h = round($new_h * $orig_w / $new_w);
		        $new_y = ($old_h - $orig_h) / 2;
			}

		    $dst_img = @imagecreatetruecolor($new_w, $new_h);
		    if($blackAndWhite==1){
		    	$this->ImageToBlackAndWhite($src_img);
			}
			@imagecopyresampled($dst_img, $src_img, 0, 0, $new_x, $new_y, $new_w, $new_h, $orig_w, $orig_h);
		    @imagejpeg($dst_img, $new_name, 95);

		    @imagedestroy($dst_img);
		    @imagedestroy($src_img);
		}catch(Exception $e){
			return false;
		}
	}

	private function ImageToBlackAndWhite($im) {
		try{
			imagefilter($im, IMG_FILTER_GRAYSCALE);
			imagefilter($im, IMG_FILTER_CONTRAST, -100);
		}catch(Exception $e){ 
			return false;
		}
	}

} 
?>