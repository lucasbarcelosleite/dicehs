<?php

$pathClasses = ROOT."/classes/";

$vDir = WFile::lsRecursivo($pathClasses);

foreach ($vDir as $arq) {
	require $arq;
}

?>