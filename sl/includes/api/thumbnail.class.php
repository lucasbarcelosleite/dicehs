<?php
class dThumbMaker{
	function getVersion(){
		return "2.4";
	}
	public $name;
	private $image;
	private $width;
	private $height;
	public $backgroundColor = 0xFFFFFF;
	public $backup;

	function __construct($origFilename=false){
		if($origFilename)	$this->loadFile($origFilename);
	}

	function __destruct(){
		@imagedestroy($this->image);
		if( $this->backup->image )
		@imagedestroy($this->backup->image);
	}

	function loadFile($origFilename){
		if(!file_exists($origFilename)){
			return "Imagem n�o encontrada ou n�o acess�vel.";
		}
		$this->name = $origFilename;
		$imagesize = @getimagesize($origFilename);
		$this->width = $imagesize[0];
		$this->height = $imagesize[1];
		switch($imagesize[2]){
			case 1  /*gif*/ : $this->image = imagecreatefromgif($origFilename); break;
			case 2  /*jpg*/ : $this->image = imagecreatefromjpeg($origFilename); break;
			case 3  /*png*/ : $this->image = imagecreatefrompng($origFilename); break;
			case 6  /*bmp*/ : $this->image = imagecreatefrombmp($origFilename); break;
			case 15 /*wbmp*/: $this->image = imagecreatefromwbmp($origFilename); break;
			default:
				return "A imagem precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		$this->backup = false;
		return true;
	}

	function imageColorAllocate($image){
		$r = ( (int)$this->backgroundColor/0x10000 )%0x10000;
		$g = ( (int)$this->backgroundColor/0x100 )%0x100;
		$b = $this->backgroundColor%0x100;
		return imagecolorallocate($image, $r, $g, $b);
	}

	function getWidth(){  // Returns image width
		return $this->width;
	}

	function getHeight(){ // Returns image height
		return $this->height;
	}

	function getImage(){
		return $this->image;
	}

	function resizeMaxSize($maxW, $maxH=false, $constraint=true, $lossQuality = false){
		$resizeByW = $resizeByH = false;

		if ($lossQuality) {
			if($maxW) $resizeByW = true;
			if($maxH) $resizeByH = true;
		} else {
			if($this->width > $maxW && $maxW) $resizeByW = true;
			if($this->height > $maxH && $maxH) $resizeByH = true;
		}

		if($resizeByH && $resizeByW){
			$resizeByH = ($this->width/$maxW<$this->height/$maxH);
			$resizeByW = !$resizeByH;
		}
		if($resizeByW){
			$this->resizeExactSize($maxW, 0, $constraint);
		}else if($resizeByH){
			$this->resizeExactSize(0, $maxH, $constraint);
		}
	}

	function resizeMinSize($minW, $minH=false, $constraint=true, $lossQuality=false){
		$resizeByH = $resizeByW = false;
		if ($lossQuality) {
			if($minW) $resizeByW = true;
			if($minH) $resizeByH = true;
		} else {
			if($this->width > $minW && $minW) $resizeByW = true;
			if($this->height > $minH && $minH) $resizeByH = true;
		}
		$heightNew = $this->height*$minW/$this->width;

		if($resizeByW && $resizeByH){
			$heightNew = $this->height*$minW/$this->width;

			if($heightNew > $minH){
				$this->resizeExactSize($minW);
			}else{
				$this->resizeExactSize(0, $minH);
			}
		}else if($resizeByW){
			$this->resizeExactSize($minW);
		}else if($resizeByH){
			$this->resizeExactSize(0, $minH);
		}
	}

	function resizeExactSize($outWidth, $outHeight = 0, $constraint=true){
		if($outWidth && $outHeight){
			$newWidth = $outWidth;
			$newHeight = $outHeight;
		}elseif($outWidth){
			if($constraint){
				$newWidth = $outWidth;
				$newHeight = ($this->height*$outWidth)/$this->width;
			}else{
				$newWidth = $outWidth;
				$newHeight = $this->height;
			}
		}elseif($outHeight){
			if($constraint){
				$newWidth = ($this->width*$outHeight)/$this->height;
				$newHeight = $outHeight;
			}else{
				$newWidth = $this->width;
				$newHeight = $outHeight;
			}
		}
		if($newWidth != $this->width || $newHeight != $this->height){
			$imN = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($imN, $this->image, 0, 0, 0, 0, $newWidth, $newHeight, $this->width, $this->height);
			imagedestroy($this->image);
			$this->image = $imN;

			$this->width = $newWidth;
			$this->height = $newHeight;
		}
	}

	function resizeNoBorder($outWidth, $outHeight){
		$heightNew = $this->height*$outWidth/$this->width;
		if($heightNew >= $outHeight){
			$this->resizeExactSize($outWidth);
		}else{
			$this->resizeExactSize(0, $outHeight);
		}

		$this->cropCenter($outWidth, $outHeight);
	}

	function resizeToArea($outWidth, $outHeight, $limitNoBorder = 0, $noLossQuality = false){
		$heightNew = $this->height*$outWidth/$this->width;

		if($heightNew <= $outHeight){
			//Verifica se nao havera perda de qualidade ou se a perda de qualidade esta desativada
			if(!$noLossQuality || ($outWidth <= $this->width && $outHeight <= $this->height) ){
				//Verifica se a perda de imagem nao e maior que o limite estabelecido
				if(1 - $heightNew/$outHeight <= $limitNoBorder){
					return $this->resizeNoBorder($outWidth, $outHeight);
				}else{
					$this->resizeExactSize($outWidth);
				}
				//Verifica se a perda de imagem sera maior que o limite estabelecido
			}else if( ($this->width-$outWidth)/$this->width > $limitNoBorder ){
				$this->resizeExactSize($outWidth);
			}
		}else{
			$widthNew = $this->width*$outHeight/$this->height;
			if(!$noLossQuality || ($outWidth <= $this->width && $outHeight <= $this->height) ){
				if(1 - $widthNew/$outWidth <= $limitNoBorder){
					return $this->resizeNoBorder($outWidth, $outHeight);
				}else{
					$this->resizeExactSize(0, $outHeight);
				}
			}else if( ($this->height-$outHeight)/$this->height > $limitNoBorder ){
				$this->resizeExactSize(0, $outHeight);
			}
		}
		$this->cropCenter($outWidth, $outHeight);
	}

	function crop($startX, $startY, $endX=false, $endY=false, $backgroundColorActive = true){
		if(!$endX)	$endX = $this->width-$startX;
		if(!$endY)	$endY = $this->height-$startY;

		$width  = $endX-$startX;
		$height = $endY-$startY;
		$imN = imagecreatetruecolor($width, $height);

		if($backgroundColorActive && ($this->width<$width || $this->height<$height) ){
			$imN = imagecreatetruecolor($width, $height);
			$color = $this->imageColorAllocate($imN);
			imagefilledrectangle($imN, 0, 0, $width, $height, $color);
			imagecopy($imN, $this->image, -$startX, -$startY, 0, 0, $this->width, $this->height);
		}else{
			imagecopy($imN, $this->image, 0, 0, $startX, $startY, $width, $height);
		}

		imagedestroy($this->image);

		$this->image = $imN;
		$this->width = $width;
		$this->height = $height;
	}

	function cropCenter($width, $height, $moveX=0, $moveY=0){
		$centerX  = $this->width/2;
		$centerY  = $this->height/2;

		$topX = $centerX-$width/2;
		$topY = $centerY-$height/2;
		$endX = $centerX+$width/2;
		$endY = $centerY+$height/2;
		$this->crop($topX+$moveX, $topY+$moveY, $endX+$moveX, $endY+$moveY);
	}

	function flip($vertical=false){
		$imN = imagecreatetruecolor($this->width, $this->height);
		if($vertical)
		for($y = 0; $y <$this->height; $y++)
		imagecopy($imN, $this->image, 0, $y, 0, $this->height - $y - 1, $this->width, 1);
		else
		for($x = 0; $x < $this->width; $x++)
		imagecopy($imN, $this->image, $x, 0, $this->width - $x - 1, 0, 1, $this->height);

		imagedestroy($this->image);
		$this->image = &$imN;
		return true;
	}

	function flipV(){
		return $this->flip(true);
	}

	function flipH(){
		return $this->flip();
	}

	function rotate90($times=1){
		$times = ($times%4);
		if($times < 0)
		$times += 4;

		if($times == 1){     // 90�
			$newW = $this->height;
			$newH = $this->width;
			$imN = imagecreatetruecolor($newW, $newH);

			for($x=0; $x<$newH; $x++)
			for($y=0; $y<$newW; $y++)
			imagecopy($imN, $this->image, $newW-$y-1, $x, $x, $y, 1, 1);
		}
		elseif($times == 2){ // 180�
			$this->flipH();
			$this->flipV();
			return true;
		}
		elseif($times == 3){ // 270�
			$newW = $this->height;
			$newH = $this->width;
			$imN = imagecreatetruecolor($newW, $newH);

			for($x=0; $x<$newH; $x++)
			for($y=0; $y<$newW; $y++)
			imagecopy($imN, $this->image, $y, $newH-$x-1, $x, $y, 1, 1);
		}
		else{
			return true;
		}

		imagedestroy($this->image);
		$this->image = $imN;
		$this->width = $newW;
		$this->height = $newH;

		return true;
	}

	function addBorder($filename, $paddingX=0, $paddingY=0){
		$origBSize = @getimagesize($filename);
		switch($origBSize[2]){
			case 1  /*gif*/ : $imB = imagecreatefromgif ($filename); break;
			case 2  /*jpg*/ : $imB = imagecreatefromjpeg($filename); break;
			case 3  /*png*/ : $imB = imagecreatefrompng ($filename); break;
			case 6  /*bmp*/ : $imB = imagecreatefrombmp ($filename); break;
			case 15 /*wbmp*/: $imB = imagecreatefromwbmp($filename); break;
			default:
				return "A borda precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		imagecopyresampled($this->image, $imB, $paddingX, $paddingY, 0, 0, $this->width-$paddingX, $this->height-$paddingY, $origBSize[0], $origBSize[1]);
		imagedestroy($imB);
		return true;
	}

	function addWaterMark($filename, $posX=0, $posY=0, $invertido=true, $opacity=100){
		$origWSize = @getimagesize($filename);
		switch($origWSize[2]){
			case 1  /*gif*/ : $imW = imagecreatefromgif ($filename); break;
			case 2  /*jpg*/ : $imW = imagecreatefromjpeg($filename); break;
			case 3  /*png*/ : $imW = imagecreatefrompng ($filename); break;
			case 6  /*bmp*/ : $imW = imagecreatefrombmp ($filename); break;
			case 15 /*wbmp*/: $imW = imagecreatefromwbmp($filename); break;
			default:
				return "A marca dagua precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		if($invertido===true || (is_array($invertido)&&$invertido[0]))
		$posX = $this->width-$origWSize[0]-$posX;
		if($invertido===true || (is_array($invertido)&&$invertido[1]))
		$posY = $this->height-$origWSize[1]-$posY;

		($opacity != 100)?
		imagecopymerge($this->image, $imW, $posX, $posY, 0, 0, $origWSize[0], $origWSize[1], $opacity):
		imagecopy($this->image, $imW, $posX, $posY, 0, 0, $origWSize[0], $origWSize[1]);

		imagedestroy($imW);
		return true;
	}

	function addWaterMarkCenter($filename, $alpha = 100, $moveX = 0, $moveY = 0){
		$origWSize = @getimagesize($filename);
		switch($origWSize[2]){
			case 1  /*gif*/ : $imW = imagecreatefromgif ($filename); break;
			case 2  /*jpg*/ : $imW = imagecreatefromjpeg($filename); break;
			case 3  /*png*/ : $imW = imagecreatefrompng ($filename); break;
			case 6  /*bmp*/ : $imW = imagecreatefrombmp ($filename); break;
			case 15 /*wbmp*/: $imW = imagecreatefromwbmp($filename); break;
			default:
				return "A marca dagua precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		$x = ($this->width - $origWSize[0])/2 + $moveX;
		$y = ($this->height - $origWSize[1])/2 + $moveY;
		if($alpha != 100){
			imagecopymerge($this->image, $imW, $x, $y, 0, 0, $origWSize[0], $origWSize[1], $alpha);
		}else{
			imagecopy($this->image, $imW, $x, $y, 0, 0, $origWSize[0], $origWSize[1]);
		}

		imagedestroy($imW);
	}

	function makeCaricature($colors=32, $opacity=70){
		$newim = imagecreatetruecolor($this->width, $this->height);
		imagecopy($newim, $this->image, 0, 0, 0, 0, $this->width, $this->height);
		imagefilter($newim, IMG_FILTER_SMOOTH, 0);
		imagefilter($newim, IMG_FILTER_GAUSSIAN_BLUR);
		imagetruecolortopalette($newim, false, $colors);
		imagecopymerge($this->image, $newim, 0, 0, 0, 0, $this->width, $this->height, $opacity);
		imagedestroy($newim);

		return true;
	}

	function createCrop($nome, $nomeArquivo){
		$campo = str_replace('_principal', '', $nome);
		$this->crop(pega($campo.'-x'), pega($campo.'-y'), pega($campo.'-w')+pega($campo.'-x'), pega($campo.'-h')+pega($campo.'-y'));
		$this->build(WPath::arquivoRoot('crop_'.$nomeArquivo),"jpeg");
	}

	function createBackup(){
		if($this->backup)	imagedestroy($this->backup->image);
		$this->backup = new stdClass();
		$this->backup->width = $this->width;
		$this->backup->height = $this->height;
		$this->backup->image = imagecreatetruecolor($this->width, $this->height);
		imagecopy($this->backup->image, $this->image, 0, 0, 0, 0, $this->width, $this->height);
	}

	function restoreBackup(){
		imagedestroy($this->image);
		$this->width = $this->backup->width;
		$this->height = $this->backup->height;
		$this->image = imagecreatetruecolor($this->width, $this->height);
		imagecopy($this->image, $this->backup->image, 0, 0, 0, 0, $this->width, $this->height);
	}

	function build($outputFilename = false, $fileType = false, $quality = 100){
		if($outputFilename === false){
			// Output filename wasn't found, let's overwrite original file.
			$outputFilename = $this->name;
		}

		// Try to auto-determine output format
		if(!$fileType)	$fileType = substr($outputFilename, strrpos($outputFilename, '.')+1);

		switch($fileType){
			case 'gif':	return imagegif($this->image, $outputFilename);
			case 'png':	return imagepng($this->image, $outputFilename);
			case 'wbmp':	return imagewbmp($this->image, $outputFilename);
		}
		return imagejpeg($this->image, $outputFilename, $quality);
	}
}

if(!function_exists('imagecreatefrombmp')){
	/*********************************************/
	/*    --- Adquirida no Manual do PHP ---     */
	/* Fonction: ImageCreateFromBMP              */
	/* Author:   DHKold                          */
	/* Contact:  admin@dhkold.com                */
	/* Date:     The 15th of June 2005           */
	/* Version:  2.0B                            */
	/*********************************************/
	function imagecreatefrombmp($filename){
		if(!($f1 = fopen($filename, "rb")))
		return false;

		//1 : Chargement des ent�tes FICHIER
		$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
		if($FILE['file_type'] != 19778)
		return false;

		//2 : Chargement des ent�tes BMP
		$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
		'/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
		'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
		$BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
		if($BMP['size_bitmap'] == 0)
		$BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];

		$BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
		$BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
		$BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
		$BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
		$BMP['decal'] = 4-(4*$BMP['decal']);
		if ($BMP['decal'] == 4)
		$BMP['decal'] = 0;

		//3 : Chargement des couleurs de la palette
		$PALETTE = array();
		if ($BMP['colors'] < 16777216)
		$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));

		//4 : Cr�ation de l'image
		$IMG = fread($f1,$BMP['size_bitmap']);
		$VIDE = chr(0);

		$res = imagecreatetruecolor($BMP['width'],$BMP['height']);
		$P = 0;
		$Y = $BMP['height']-1;
		while ($Y >= 0){
			$X=0;
			while ($X < $BMP['width']){
				if ($BMP['bits_per_pixel'] == 24)
				$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
				elseif ($BMP['bits_per_pixel'] == 16){
					$COLOR = unpack("n",substr($IMG,$P,2));
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				elseif ($BMP['bits_per_pixel'] == 8){
					$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				elseif ($BMP['bits_per_pixel'] == 4){
					$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
					if (($P*2)%2 == 0)
					$COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				elseif ($BMP['bits_per_pixel'] == 1){
					$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
					if (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
					elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
					elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
					elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
					elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8 )>>3;
					elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4 )>>2;
					elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2 )>>1;
					elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1 );
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				else
				return false;
				imagesetpixel($res,$X,$Y,$COLOR[1]);
				$X++;
				$P += $BMP['bytes_per_pixel'];
			}
			$Y--;
			$P+=$BMP['decal'];
		}
		//Fermeture du fichier
		fclose($f1);
		return $res;
	}
}
?>