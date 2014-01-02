<?php
defined( '_VALID_MOS' ) or die( 'Restricted access' );

class WMenuBar {

	/**
	 * Writes the start of the button bar table
	 */
	function startTable() {
		echo '<ul id="toolbar">';
	}

	/**
	 * Writes the end of the menu bar table
	 */
	function endTable() {
		echo '</ul>';
	}

	/**
	 * Returns the image of one toolbar button
	 */
	function image($icon, $alt, $task) {
		return '<img name="'.$task.'" src="'.WPath::img($icon).'" alt="'.$alt.'" title="'.$alt.'" />';
	}

	/**
	 * Returns one toolbar button
	 */
	function showButton($icon, $alt, $task, $href="", $extra="") {
		return '<li>
      				<a class="toolbar" href="'.$href.'" '.$extra.'>
      					'.WMenuBar::image($icon, $alt, $task).'
      					<br />'.$alt.'</a>
      			</li>';
	}

	/**
	 * Writes a custom option and task button for the button bar
	 * @param string The task to perform (picked up by the switch($task) blocks
	 * @param string The image to display
	 * @param string The image to display when moused over
	 * @param string The alt text for the icon image
	 * @param boolean True if required to check that a standard list item is checked
	 */
	function custom( $task='', $icon='', $iconOver='', $alt='', $listSelect=true, $isFlag=true ) {

		if ($listSelect) {
			$listSelect = "";
		} else {
			if (!$isFlag) {
				$listSelect = ' lang="noFlag" ';
			} else {
				$listSelect = ' lang="noList" ';
			}
		}

		$href = $task;

		echo WMenuBar::showButton($icon, $alt, $task, $href, $listSelect);
	}

	/**
	 * Writes a custom option and task button for the button bar.
	 * Extended version of custom() calling hideMainMenu() before submitbutton().
	 * @param string The task to perform (picked up by the switch($task) blocks
	 * @param string The image to display
	 * @param string The image to display when moused over
	 * @param string The alt text for the icon image
	 * @param boolean True if required to check that a standard list item is checked
	 */
	function customX( $task='', $icon='', $iconOver='', $alt='', $listSelect=true ) {

		if ($listSelect) {
			$href = "javascript:if (document.adminForm.boxchecked.value == 0){ alert(\'Por favor, selecione um item da lista para $alt');}else{hideMainMenu();submitbutton('$task')}";
		} else {
			$href = "javascript:hideMainMenu();submitbutton('$task')";
		}

		echo WMenuBar::showButton($icon, $alt, $task, $href);
	}

	/**
	 * Writes the common 'new' icon for the button bar
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function addNew( $task='new', $alt='Novo' ) {
		echo WMenuBar::showButton('bt-novo.png', $alt, $task, "javascript:submitbutton('".$task."');");
	}

	/**
	 * Writes a common 'publish' button for a list of records
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function publishList( $task='publish', $alt='Publicar' ) {

		$href = "javascript: if (document.adminForm.boxchecked.value == 0){ alert('Por favor, selecione um item da lista para publicar'); } else {submitbutton('".$task."', '');}";

		echo WMenuBar::showButton('bt-publicado.png', $alt, $task, $href);
	}

	/**
	 * Writes a common 'unpublish' button for a list of records
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function unpublishList( $task='unpublish', $alt='Despublicar' ) {
		echo '
		<li>
			<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert(\'Por favor, selecione um item da lista para despublicar\'); } else {submitbutton(\''.$task.'\', \'\');}">
				'.WMenuBar::image('bt-despublicado.png', $alt, $task).'
				<br />'.$alt.'</a>
		</li>';
	}

	/**
	 * Writes a common 'edit' button for a list of records
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function editList( $task='edit', $alt='Editar' ) {
		echo '
		<li>
			<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert(\'Por favor, selecione um item da lista para editar\'); } else {submitbutton(\''.$task.'\', \'\');}">
				'.WMenuBar::image('bt-editar.png', $alt, $task).'
				<br />'.$alt.'</a>
		</li>';
	}

	/**
	 * Writes a common 'delete' button for a list of records
	 * @param string  Postscript for the 'are you sure' message
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function deleteList( $msg='', $task='remove', $alt='Deletar' ) {
		echo '
		<li>
			<a class="toolbar" href="javascript:if (document.adminForm.boxchecked.value == 0){ alert(\'Por favor, selecione um item da lista para deletar\'); } else if (confirm(\'Você tem certeza que deseja deletar o item selecionado? '.$msg.'\')){ submitbutton(\''.$task.'\');}">
				'.WMenuBar::image('bt-excluir.png', $alt, $task).'
				<br />'.$alt.'</a>
		</li>';
	}

	/**
	 * Writes a save button for a given option
	 * Save operation leads to a save and then close action
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function save( $task='save', $alt='Salvar' ) {
		echo '
		<li>
			<a class="toolbar" href="javascript:submitbutton(\''.$task.'\');">
				'.WMenuBar::image('bt-salvar.png', $alt, $task).'
				<br />'.$alt.'</a>
		</li>';
	}

	/**
	 * Writes a cancel button and invokes a cancel operation (eg a checkin)
	 * @param string An override for the task
	 * @param string An override for the alt text
	 */
	function cancel( $task='cancel', $alt='Cancelar' ) {
		echo '
		<li>
			<a class="toolbar" href="javascript:submitbutton(\''.$task.'\');">
				'.WMenuBar::image('bt-cancelar.png', $alt, $task).'
				<br />'.$alt.'</a>
		</li>';
	}

	/**
	 * Writes a cancel button that will go back to the previous page without doing
	 * any other operation
	 */
	function back( $alt='Voltar', $href='' ) {
		if ( $href ) {
			$link = $href;
		} else {
			$link = 'javascript:window.history.back();';
		}

		echo '
		<li>
			<a class="toolbar" href="'.$link.'">
				'.WMenuBar::image('bt-voltar.png', $alt, "cancel").'
				<br />'.$alt.'</a>
		</li>';
	}

}
?>