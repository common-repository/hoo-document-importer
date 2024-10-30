<?php
namespace HooDocImporter;

class ImporterButton {

	public static function register() {
		$i = new ImporterButton();
		add_action("init", array($i, "register_script"));
		add_action("admin_enqueue_scripts", array($i, "admin_enqueue_scripts"));
		add_action('media_buttons', array($i, 'add_importer_button'));
		add_action( 'enqueue_block_editor_assets', array($i, 'block_editor_button') );
	}

	function register_script() {
		wp_register_script(
			"hoodoc_words_import_meta_box_script",
			plugins_url("assets/js/importer.js", HOO_DOC_IMPORTER_PLUGIN_FILE),
			array(
				"jquery"
			),
			get_file_data(HOO_DOC_IMPORTER_PLUGIN_FILE, array("Version" => "Version"), "plugin")["Version"]
		);
	}

	function admin_enqueue_scripts() {
		wp_enqueue_media();
		wp_enqueue_script("hoodoc_words_import_meta_box_script");
		$l10n = $this->get_string_translation();

		wp_localize_script( 'hoodoc_words_import_meta_box_script', 'hoodoc', array(
			'ajaxurl'    => admin_url('admin-ajax.php'),
			'l10n'   => $l10n,
		));
	}

	function block_editor_button() {

		$ver = get_file_data(HOO_DOC_IMPORTER_PLUGIN_FILE, array("Version" => "Version"), "plugin")["Version"];
		$l10n = $this->get_string_translation();

		wp_enqueue_script(
			'hoodoc-block-editor',
			HOO_DOC_IMPORTER_URL.'assets/js/block-editor.js',
			array( 'wp-element', 'wp-editor', 'wp-components', 'wp-block-editor' ),
			$ver,
			true
		);

		wp_enqueue_style('hoodoc-block-editor', HOO_DOC_IMPORTER_URL.'assets/css/block-editor.css', '', $ver, false );

		wp_localize_script(
			'hoodoc-block-editor',
			'HDIBlockEditorL10n',
			array(
				'ajaxurl'    => admin_url('admin-ajax.php'),
				'l10n'   => $l10n,
			)
		);

		wp_localize_script(
			'hoodoc-block-editor',
			'HDIBlockEditorConfig',
			array( 
				'url' => HOO_DOC_IMPORTER_URL,
			)
		);

	}

	function get_string_translation(){
		return [
			'l01' => __( 'Hoo Doc Importer', 'hoo-document-importer' ),
			't01'=> __('Select a Word file to import', 'hoo-document-importer'),
			't02'=> __('Import to Current Editor', 'hoo-document-importer'),
			't03'=> __('An error occurred. Please try again.', 'hoo-document-importer'),
			't04'=> __('Please select a docx file.', 'hoo-document-importer'),
		];
	}
	function add_importer_button($content) {
		include_once dirname(HOO_DOC_IMPORTER_PLUGIN_FILE) . "/templates/import-metabox.php";
	}
}
