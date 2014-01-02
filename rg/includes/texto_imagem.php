<?php

/*
 VARIAVEIS:
 text
 Fsize
 Color
 Background
 Font
 transparente
 Howie_s_Funhouse
 */
$text = $_GET['text'] ;
$font_size  = $_GET['fsize'];
$font_color  = str_replace("#","",$_GET['color']);

if(isset($_GET['Background'])){
	$background_color  = $_GET['Background'];
}else{
	$background_color = "FFFFFF";
}

if($_GET['transparente'] == "sim"){
	$transparent_background  = true ;
}else{
	$transparent_background  = false ;
}

$font_file  = $_GET['font'];

$font_file .= '.ttf' ;

//if($font_file != "AVANGMI_"){
//	$font_file .= '.ttf' ;
//}

//if($font_file == "AVANGMI_"){
//	$font_file .= '.PFM' ;
//}


$mime_type = 'image/png' ;
$extension = '.png' ;
$send_buffer_size = 4096 ;

// verifica o suporte GD
if(!function_exists('ImageCreate'))
fatal_error('Erro: O servidor não possui a biblioteca gd habilitada.') ;

// limpa o texto
if(empty($_GET['text']))
fatal_error('Erro: Especifique um texto.') ;

if(get_magic_quotes_gpc())
$text = stripslashes($text) ;
$text = javascript_para_html($text) ;

// verifica a existência da fonte
$font_found = is_readable($font_file) ;
if(!$font_found)
{
	fatal_error('Erro: O servidor não encontrou a fonte especificada.') ;
}

// cria a imagem
$background_rgb = hex_para_rgb($background_color) ;
$font_rgb = hex_para_rgb($font_color) ;
$dip = get_dip($font_file,$font_size) ;
$box = @ImageTTFBBox($font_size,0,$font_file,$text) ;
$image = @ImageCreate(abs($box[2]-$box[0]),abs($box[5]-$dip)) ;
if(!$image || !$box)
{
	fatal_error('Erro: O servidor não pode criar a imagem.') ;
}

// aloca as cores e desenha o texto
$background_color = @ImageColorAllocate($image,$background_rgb['red'],
$background_rgb['green'],$background_rgb['blue']) ;
$font_color = ImageColorAllocate($image,$font_rgb['red'],
$font_rgb['green'],$font_rgb['blue']) ;
ImageTTFText($image,$font_size,0,-$box[0],abs($box[5]-$box[3])-$box[1],
$font_color,$font_file,$text) ;

// define a transparência
if($transparent_background)
ImageColorTransparent($image,$background_color) ;

header('Content-type: ' . $mime_type) ;
ImagePNG($image) ;

function get_dip($font,$size)
{
	$test_chars = 'abcdefghijklmnopqrstuvwxyz' .
			      'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
				  '1234567890' .
				  '!@#$%^&*()\'"\\/;.,`~<>[]{}-+_-=' ;
	$box = @ImageTTFBBox($size,0,$font,$test_chars) ;
	return $box[3] ;
}

function fatal_error($message)
{
	// envia uma imagem
	if(function_exists('ImageCreate'))
	{
		$width = ImageFontWidth(5) * strlen($message) + 10 ;
		$height = ImageFontHeight(5) + 10 ;
		if($image = ImageCreate($width,$height))
		{
			$background = ImageColorAllocate($image,255,255,255) ;
			$text_color = ImageColorAllocate($image,0,0,0) ;
			ImageString($image,5,5,5,$message,$text_color) ;
			header('Content-type: image/png') ;
			ImagePNG($image) ;
			ImageDestroy($image) ;
			exit ;
		}
	}

	// envia código 500
	header("HTTP/1.0 500 Internal Server Error") ;
	print($message) ;
	exit ;
}

/*
 decodifica o codigo hexa do HTML em um array de valores R,G, e B.
 aceita os formatos: (case insensitive) #ffffff, ffffff, #fff, fff
 */
function hex_para_rgb($hex)
{
	// remove '#'
	if(substr($hex,0,1) == '#')
	$hex = substr($hex,1) ;

	// expande o formato reduzido ('fff')
	if(strlen($hex) == 3)
	{
		$hex = substr($hex,0,1) . substr($hex,0,1) .
		substr($hex,1,1) . substr($hex,1,1) .
		substr($hex,2,1) . substr($hex,2,1) ;
	}

	if(strlen($hex) != 6)
	fatal_error('Error: Invalid color "'.$hex.'"') ;

	// converte
	$rgb['red'] = hexdec(substr($hex,0,2)) ;
	$rgb['green'] = hexdec(substr($hex,2,2)) ;
	$rgb['blue'] = hexdec(substr($hex,4,2)) ;

	return $rgb ;
}

function javascript_para_html($text)
{
	$matches = null ;
	preg_match_all('/%u([0-9A-F]{4})/i',$text,$matches) ;
	if(!empty($matches)) for($i=0;$i<sizeof($matches[0]);$i++)
	$text = str_replace($matches[0][$i],
                            '&#'.hexdec($matches[1][$i]).';',$text) ;
	return $text ;
}
?>
