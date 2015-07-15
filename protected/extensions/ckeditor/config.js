/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'ru';
	config.height	= 600;
	// config.stylesSet = false;
		// можно указать свой стиль для содержимого, по умолчанию используется <CKEditor folder>/contents.css'
	config.contentsCss = '../../../css/page/page.css';
		//Если установлено true то редактируемая область будет содержать полноценный html документ, если false - только контент (без скриптов и стилей).
	//config.fullPage = true;
	config.skin = 'office2013';
		// какой тег ставить по Enter: _BR, _P, _DIV
	config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P;

	config.startupFocus = true; //При открытии стр. где есть радактор - брать фокус на себя

	// config.uiColor = '#f00';
		// Выключаем подсказки названия тэга в строке состояния редактора
	// config.removePlugins = 'elementspath';

 	//config.toolbar = 'Full';
	config.removePlugins = 'save, smiley, maximize, preview, spellchecker, about, newpage, print, templates, scayt, flash, horizontalrule, pagebreak, blockquote';
		// добавляем плугин
	config.extraPlugins = 'mediaembed';

		// кодирование кавычек
	config.entities = false;
		// не рабоает почему -то
	//config.extraCss = 'body{background:#F0F;text-align:left;font-size:0.8em;}';



	config.colorButton_enableMore = true,
  	config.bodyId = 'e_content',
	// config.forceSimpleAmpersand = false,
	// config.fontSize_defaultLabel = '12px',
	// config.font_defaultLabel = 'Arial',
	// config.emailProtection = 'encode',
	// config.contentsLangDirection = 'ltr',
	config.toolbarLocation = 'top',
	config.browserContextMenuOnCtrl = false,
	//config.image_previewText = CKEDITOR.tools.repeat('Vitebskgas is the capital of other gas', 50 )

		// включает "показывать блоки" при загрузке редактора
	config.startupOutlineBlocks = true;

		// путь к контроллеру/экшену который грузит файлы на сервер
	//config.filebrowserUploadUrl = '../../../editor/upload';

		// настройка просмотра и загрузки файлов с помощью KCFinder
	var kc_path = window.location.protocol+'//'+window.location.host;

	config.filebrowserBrowseUrl 		= kc_path+'/kcfinder/browse.php?type=files';
  	config.filebrowserImageBrowseUrl	= kc_path+'/kcfinder/browse.php?type=images';
  	config.filebrowserFlashBrowseUrl	= kc_path+'/kcfinder/browse.php?type=flash';
  	config.filebrowserUploadUrl 		= kc_path+'/kcfinder/upload.php?type=files';
  	config.filebrowserImageUploadUrl 	= kc_path+'/kcfinder/upload.php?type=images';
  	config.filebrowserFlashUploadUrl	= kc_path+'/kcfinder/upload.php?type=flash';

};

/*------------------------------------------------------------*/

CKEDITOR.on( 'instanceReady', function( ev ) {
	ev.editor.dataProcessor.writer.selfClosingEnd = '>';
});

/*------------------------------------------------------------*/

CKEDITOR.on( 'instanceReady', function( ev ) {
    // Output paragraphs as <p>Text</p>.
    ev.editor.dataProcessor.writer.setRules( '*', {
      indent: false,
      breakBeforeOpen: true,
      breakAfterOpen: false,
      breakBeforeClose: false,
      breakAfterClose: true
    });
 });

/*-----------------------------------------------------------*/

CKEDITOR.on('change', function(event) {
    alert('ckvalue');
});

/*----------------------------------------------------------*/
