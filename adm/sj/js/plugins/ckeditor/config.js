/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
  config.filebrowserBrowseUrl      = 'js/plugins/kcfinder/browse.php?type=files';
  config.filebrowserImageBrowseUrl = 'js/plugins/kcfinder/browse.php?type=image';
  config.filebrowserFlashBrowseUrl = 'js/plugins/kcfinder/browse.php?type=flash';
  config.filebrowserUploadUrl      = 'js/plugins/kcfinder/upload.php?type=files';
  config.filebrowserImageUploadUrl = 'js/plugins/kcfinder/upload.php?type=image';
  config.filebrowserFlashUploadUrl = 'js/plugins/kcfinder/upload.php?type=flash';
  config.allowedContent = true;
  config.htmlEncodeOutput = false;
  config.entities = false;
  config.contentsCss = ['http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic',
  			'/adm/sj/css/bootstrap.min.css', 
  			'/adm/sj/css/layout.css'];
  config.font_names = 
                  'Roboto;'+
                  'Shebrew;' +
                  'Symbol;' +
                  'WingdingsRegular';
};
