<?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];

	if (is_uploaded_file($_FILES["Filedata"]["tmp_name"])) {
		print_r($_FILES["Filedata"]);
	}
	else {
		echo "Erro";
	}
}
?>
