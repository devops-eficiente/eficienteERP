/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/*CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};
*/
		
CKEDITOR.editorConfig = function( config )
	{
	   // Define changes to default configuration here. For example:
	   CKEDITOR.config.language = 'es';
	   // config.skin = 'office2003';
	   //config.removePlugins =  'elementspath,enterkey,entities,forms,pastefromword,htmldataprocessor,specialchar' ;
	   CKEDITOR.config.removePlugins =  'elementspath,enterkey,entities,htmldataprocessor,specialchar,wsc';
	   CKEDITOR.config.removeDialogTabs = 'link:advanced;image:advanced;flash:advanced;creatediv:advanced;editdiv:advanced';
	   config.extraPlugins = 'codemirror';

	   //config.skin = 'v2';
	   //config.toolbar = 'Basic';
		
    	CKEDITOR.config.allowedContent = true; // don't filter my data
		CKEDITOR.config.linkShowAdvancedTab = false; 
   		CKEDITOR.config.linkShowTargetTab = false; 
		CKEDITOR.config.inkJavaScriptLinksAllowed = true;
		
		CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
		CKEDITOR.config.forcePasteAsPlainText = true; // default so content won't be manipulated on load
		CKEDITOR.config.basicEntities = true;
		CKEDITOR.config.entities = true;
		CKEDITOR.config.entities_latin = false;
		CKEDITOR.config.entities_greek = false;
		CKEDITOR.config.entities_processNumerical = false;
		CKEDITOR.config.protectedSource.push( /<\?[\s\S]*?\?>/g ); // PHP code
		CKEDITOR.config.protectedSource.push( /<%[\s\S]*?%>/g ); // ASP code
		CKEDITOR.config.protectedSource.push( /(<asp:[^\>]+>[\s|\S]*?<\/asp:[^\>]+>)|(<asp:[^\>]+\/>)/gi ); // ASP.Net code
		CKEDITOR.config.protectedSource.push(/<i[^>]*><\/i>/g);
		CKEDITOR.dtd.$removeEmpty['i'] = false;
		
		CKEDITOR.config.filebrowserImageUploadUrl = 'php/upload_img.php';
		
		CKEDITOR.config.resize_enabled = false;
	   CKEDITOR.config.toolbar = [
	   ['Source', 'NewPage', 'Preview'],
	   ['Undo','Redo','-','Cut','Copy','Paste'],
	   ['Find','Replace', '-', 'SelectAll', '-', 'Scayt' ],
	   ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
	   '/',
	   ['NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	   ['Image','Table','Link', 'HorizontalRule', 'SpecialChar', 'Iframe'],
	   ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	   '/',
	   ['Styles', 'Format', 'Font', 'FontSize'],
	   ['TextColor', 'BGColor']
	];
	
		config.codemirror = {

			// Set this to the theme you wish to use (codemirror themes)
			theme: 'default',
			// Whether or not you want to show line numbers
			lineNumbers: true,
			// Whether or not you want to use line wrapping
			lineWrapping: true,
			// Whether or not you want to highlight matching braces
			matchBrackets: true,
			// Whether or not you want tags to automatically close themselves
			autoCloseTags: true,
			// Whether or not you want Brackets to automatically close themselves
			autoCloseBrackets: true,
			// Whether or not to enable search tools, CTRL+F (Find), CTRL+SHIFT+F (Replace), CTRL+SHIFT+R (Replace All), CTRL+G (Find Next), CTRL+SHIFT+G (Find Previous)
			enableSearchTools: true,
			// Whether or not you wish to enable code folding (requires 'lineNumbers' to be set to 'true')
			enableCodeFolding: true,
			// Whether or not to enable code formatting
			enableCodeFormatting: true,
			// Whether or not to automatically format code should be done when the editor is loaded
			autoFormatOnStart: true,
			// Whether or not to automatically format code should be done every time the source view is opened
			autoFormatOnModeChange: true,
			// Whether or not to automatically format code which has just been uncommented
			autoFormatOnUncomment: true,
			// Whether or not to highlight the currently active line
			highlightActiveLine: true,
			// Define the language specific mode 'htmlmixed' for html including (css, xml, javascript), 'application/x-httpd-php' for php mode including html, or 'text/javascript' for using java script only
			mode: 'htmlmixed',
			// Whether or not to show the search Code button on the toolbar
			showSearchButton: true,
			// Whether or not to show Trailing Spaces
			showTrailingSpace: true,
			// Whether or not to highlight all matches of current word/selection
			highlightMatches: true,
			// Whether or not to show the format button on the toolbar
			showFormatButton: true,
			// Whether or not to show the comment button on the toolbar
			showCommentButton: true,
			// Whether or not to show the uncomment button on the toolbar
			showUncommentButton: true,
			// Whether or not to show the showAutoCompleteButton button on the toolbar
			showAutoCompleteButton: true
		};
	};
	