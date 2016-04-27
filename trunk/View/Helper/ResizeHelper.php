<?php

App::uses('Helper', 'View');

/**
 * Resize helper
 *
 * Extends the cakePHP image method to dynamically resize images.
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class ResizeHelper extends AppHelper {

	var $helpers = array('Html');
	
	var $cacheDir = 'cache';
	
	function image($path, $width, $height, $aspect = true, $htmlAttributes = array(), $return = false, $base = true) {
		
		ini_set('max_execution_time', 300); 
		ini_set('memory_limit','128M');
        
        $types = array(1 => "gif", "jpeg", "png", "swf", "psd", "wbmp"); // used to determine image type
        
        $fullpath = ROOT.'/'.APP_DIR.'/'.WEBROOT_DIR.'/'.IMAGES_URL;
        $url = $fullpath.$path;
        $_theme = false;
        // determine if image is in root or theme area...
        if (!file_exists($url)) {
        	$_folder = (Configure::read('MySite.theme'))? 'Themed' . '/' . Configure::read('MySite.theme') . '/' : '';
        	$url = ROOT.'/'.APP_DIR.'/'.'View'.'/'.$_folder.WEBROOT_DIR.'/'.IMAGES_URL.$path;
        	$_theme = true;
        	if (!file_exists($url)) {
        		return;
        	}
        }
        
        if (!($size = getimagesize($url))) 
            return; // image doesn't exist
            
        if ($aspect) { // adjust to aspect.
            if (($size[1]/$height) > ($size[0]/$width))  // $size[0]:width, [1]:height, [2]:type
                $width = round(($size[0]/$size[1]) * $height);
            else 
                $height = round($width / ($size[0]/$size[1]));
        }
        
        $r_file = $this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path); 
        $relfile = $this->webroot.IMAGES_URL.$this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path); // relative file
        $cachefile = $fullpath.$this->cacheDir.'/'.$width.'x'.$height.'_'.basename($path);  // location on server
        
        if (file_exists($cachefile)) {
            $csize = getimagesize($cachefile);
            $cached = ($csize[0] == $width && $csize[1] == $height); // image is cached
            if (@filemtime($cachefile) < @filemtime($url)) // check if up to date
                $cached = false;
        } else {
            $cached = false;
        }
        
        if (!$cached) {
            $resize = ($size[0] > $width || $size[1] > $height) || ($size[0] < $width || $size[1] < $height);
        } else {
        	$resize = false;
        }
        
        if ($size[0] == $width || $size[1] == $height) {
        	$r_file = $path;
        	if ($_theme) {
        		$r_file = 'theme' . '/' . strtolower(Configure::read('MySite.theme')) . '/' . 'img' . '/' . $r_file;
        	}
        	$resize = false;
        } 
        
        if ($resize) {
            $image = call_user_func('imagecreatefrom'.$types[$size[2]], $url);
            if (function_exists("imagecreatetruecolor") && ($temp = imagecreatetruecolor ($width, $height))) {
				if ($types[$size[2]] == 'png' || $types[$size[2]] == 'gif'){
					if ($types[$size[2]] == 'gif') {
						imagealphablending($temp, false);
						imagesavealpha($temp, true);
						$trans_colour = imagecolorallocatealpha($temp, 0, 0, 0, 127);
						imagefilledrectangle($temp, 0, 0, $width, $height, $trans_colour);
						imagecolortransparent($temp, $trans_colour);
					} else {
						imagesavealpha($temp, true);
						$trans_colour = imagecolorallocatealpha($temp, 0, 0, 0, 127);
						imagefill($temp, 0, 0, $trans_colour);
					}
				}
                imagecopyresampled ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
              } else {
                $temp = imagecreate ($width, $height);
                imagecopyresized ($temp, $image, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
            }
            call_user_func("image".$types[$size[2]], $temp, $cachefile);
            imagedestroy ($image);
            imagedestroy ($temp);
        } 
        
		if($return){
            if ($base) {
                return $this->webroot . IMAGES_URL . $r_file;
            } else {
                return '/' . IMAGES_URL . $r_file;
            }
		}else{
			return $this->Html->image($r_file, $htmlAttributes);
			//return $this->output(sprintf($this->Html->tags['image'], $relfile, $this->Html->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
		}
    
	}

}