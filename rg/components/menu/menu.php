<?
header('Content-type: text/xml');
$dom = new DOMDocument('1.0', 'utf-8');

$menu = new Menu();
$lista = $menu->select('WHERE publicado = 1 AND parent = 1');
$raiz = $dom->appendChild(new DOMElement('menu'));
foreach($lista as $item){
	$element = $raiz->appendChild( new DOMElement('itemMenu') );
	$titulo = $element->appendChild( new DOMElement('titulo', utf8_encode($item->titulo)));
	$link = $element->appendChild( new DOMElement('link', $menu->getLinkRow($item, true, true)));
	$cor = $element->appendChild( new DOMElement('cor', $item->id_menu == 11 ? 1 : 0));
}

echo $dom->saveXML();
?>