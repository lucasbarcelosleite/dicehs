<?php

$retorno = "";

if (pega("email")) {	
	if (!WValidate::email(pega("email"))) {
		$retorno = "E-Mail Inv�lido!"; 
	} else {		
		$newsletter = new Newsletter();
		$newsletter->loadBy("email",pega("email"));
		if ($newsletter->id_newsletter) {
			$retorno = "Voc� j� est� cadastrado em nossa base de Newsletters! Obrigado!";
		} else {			
			$newsletter->email = pega("email");
			$newsletter->store();			
			$retorno = "Obrigado por seu cadastro em nossa Newsletter!";
		}		
	}	
	echo $retorno;	
}

?>