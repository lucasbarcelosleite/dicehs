<?
include_once "../../configuration.php";
include_once "../thumbnail.class.php";

if(isset($_REQUEST["salvar"]))
$salvar = ($_REQUEST["salvar"]=="true")?"attachment":"inline";
else
$salvar = "inline";

$arquivo = $mosConfig_absolute_path."arquivos/".$_REQUEST["arq"];

header('Content-type: '.mime_content_type($arquivo));
header('Content-Disposition: '.$salvar.'; filename="'.basename($arquivo).'"');

$th = new dThumbMaker($arquivo);

if(isset($_REQUEST["tipo"])){
	$func = "resize".$_REQUEST["tipo"];
}
else{
	$func = "resizeMinSize";
}

if ($th->getHeight() > $th->getWidth()) {
	if ((isset($_REQUEST["forcaHeight"]))and($_REQUEST["forcaHeight"])) {
		unset($_REQUEST["width"]);
	}
	else {
		$auxW = $_REQUEST["width"];
		$_REQUEST["width"] = $_REQUEST["height"];
		$_REQUEST["height"] = $auxW;
	}
}

if((isset($_REQUEST["width"]))&&(isset($_REQUEST["height"]))){
	$th->$func($_REQUEST["width"],$_REQUEST["height"]);
	if((isset($_REQUEST["crop"]))&&$_REQUEST["crop"]){
		$th->cropCenter($_REQUEST["width"],$_REQUEST["height"]);
	}
}
elseif (isset($_REQUEST["width"])){
	$th->$func($_REQUEST["width"]);
	if((isset($_REQUEST["crop"]))&&$_REQUEST["crop"]){
		$th->cropCenter($_REQUEST["width"],$th->getHeight());
	}
}
elseif (isset($_REQUEST["height"])){
	$th->$func(false,$_REQUEST["height"]);
	if((isset($_REQUEST["crop"]))&&$_REQUEST["crop"]){
		$th->cropCenter($th->getWidth(), $_REQUEST["height"]);
	}
}
echo $th->build("inline");

?>