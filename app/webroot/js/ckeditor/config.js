﻿/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.enterMode = CKEDITOR.ENTER_BR;
	config.toolbarCanCollapse = false;
	config.tabSpaces = 5;
	config.tabShow = true;
	
	//config.toolbar = 'basic';
	
	config.toolbar_basic =
	[
		['Source'],
		['Copy','Paste','PasteText','-','SpellChecker'],
		['Undo','Redo'],
		['Bold','TextColor','BGColor','FontSize'],
		['NumberedList','BulletedList'],
		['Link','Unlink','HorizontalRule','Smiley','SpecialChar','Maximize']
	];
	
	config.toolbar = 'arcadetracker';
 
	config.toolbar_arcadetracker =
	[
		['Source'],
		['Copy','Paste','PasteText','PasteFromWord','-','SpellChecker'],
		['Undo','Redo','Find','Replace','RemoveFormat'],
		['Outdent','Indent','NumberedList','BulletedList'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Table']
	];
};
