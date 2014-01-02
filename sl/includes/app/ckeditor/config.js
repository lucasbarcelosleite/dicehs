/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.scayt_autoStartup = false;
	config.disableNativeSpellChecker = false;
	
	config.toolbar = 'Nova';

	config.toolbar_Nova =
	[
	    ['Source'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    ['Image','Table','HorizontalRule','SpecialChar','PageBreak'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
	    ['JustifyLeft','JustifyCenter','JustifyRight'],
	    ['Link','Unlink','Anchor'],
	    ['Styles'],
	    ['Maximize', 'ShowBlocks']
	];	
	
	config.filebrowserBrowseUrl = '/includes/app/ckeditor/ckfinder/ckfinder.html',
    config.filebrowserImageBrowseUrl = '/includes/app/ckeditor/ckfinder/ckfinder.html?type=Images',
    config.filebrowserFlashBrowseUrl = '/includes/app/ckeditor/ckfinder/ckfinder.html?type=Flash',
    config.filebrowserUploadUrl = '/includes/app/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Files',
    config.filebrowserImageUploadUrl = '/includes/app/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Images',
    config.filebrowserFlashUploadUrl = '/includes/app/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Flash'	
	
};
