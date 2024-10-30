<?php

/**
 * Plugin Name:         Hoo Docx Document File Importer
 * Plugin URI:          https://www.hoosoft.com/plugins/hoo-document-importer/
 * Version:		        1.0.2
 * Description:         Hoo Docx Document File Importer converts the content of the docx file into HTML and inserts it into the posts and pages editor. It includes text, text font size, images and layout, etc.
 * Requires at least:   5.3
 * Requires PHP:        7.0
 * Author:              Hoosoft
 * Author URI:          http://www.hoosoft.com
 * Text Domain:         hoo-document-importer
 * Domain Path:         /languages
 * License:             GPLv2 or later
 */

define( 'HOO_DOC_IMPORTER_DIR_PATH',  plugin_dir_path( __FILE__ ));
define( 'HOO_DOC_IMPORTER_INCLUDE_DIR', HOO_DOC_IMPORTER_DIR_PATH.'includes' );
define( 'HOO_DOC_IMPORTER_CLASSES_DIR', HOO_DOC_IMPORTER_DIR_PATH.'classes' );
define( 'HOO_DOC_IMPORTER_URL', plugin_dir_url( __FILE__ ));
define( 'HOO_DOC_IMPORTER_PLUGIN_FILE', __FILE__);

require_once HOO_DOC_IMPORTER_INCLUDE_DIR . '/plugin.php';