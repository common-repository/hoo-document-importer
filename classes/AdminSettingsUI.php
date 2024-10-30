<?php
namespace HooDocImporter;

class AdminSettingsUI {

    public static function register() {
        $i = new AdminSettingsUI();
        add_action("admin_init", array($i, "registerAdminSettings"));
        add_action('admin_menu', array($i, "adminMenu"));

        add_filter(
                "plugin_action_links_" . plugin_basename(HOO_DOC_IMPORTER_PLUGIN_FILE),
                array($i, "pluginActionLinks")
        );
    }

    public function adminMenu() {
        add_options_page(
                get_plugin_data(HOO_DOC_IMPORTER_PLUGIN_FILE)["Name"] . " " . __('Settings', 'hoo-document-importer'),
                get_plugin_data(HOO_DOC_IMPORTER_PLUGIN_FILE)["Name"],
                "manage_options",
                dirname(plugin_basename(HOO_DOC_IMPORTER_PLUGIN_FILE)),
                array($this, "settingsPage")
        );
    }

    public function pluginActionLinks($default_links) {
        $links = array(
            sprintf("<a href=\"%s\">%s</a>",
                    admin_url("options-general.php?page=" . dirname(plugin_basename(HOO_DOC_IMPORTER_PLUGIN_FILE))),
                    __('Settings', 'hoo-document-importer')
            )
        );
        return array_merge($links, $default_links);
    }

    public function registerAdminSettings() {
        register_setting('hoodoc_importer_options', 'hoodoc_importer_image_type');
    }

    public function settingsPage() {
        $args = array(
            'public' => true,
        );

        $l10n = [
            's01' => __('Settings', 'hoo-document-importer'),
            's02' => __('Feedback and Review', 'hoo-document-importer'),
            's03' => sprintf(__('Please feel free to add your reviews on <a href="%s" target="_blank">WordPress Plugin Directory</a>.', 'hoo-document-importer'), esc_url('https://wordpress.org/support/plugin/hoo-document-importer/reviews/')),
            's04' => __('Type of imported images', 'hoo-document-importer'),
            's05' => __('Upload images to Media Library and using the image url in src tag', 'hoo-document-importer'),
            's06' => __('Use the base64 string in the src tag of an img, for example: <img src="data:image/jpg;base64,iVBORw0KGgo ...  " />', 'hoo-document-importer'),
            's07' => __('Save Changes', 'hoo-document-importer')
        ];
        echo Util::getTwig()->render("settings.twig", [
            "settings_fields" => (function() {
                        ob_start();
                        settings_fields('hoodoc_importer_options');
                        $ob = ob_get_contents();
                        ob_end_clean();
                        return $ob;
                    })(),
            "plugin_data" => get_plugin_data(HOO_DOC_IMPORTER_PLUGIN_FILE),
            "options" => wp_load_alloptions(),
            "l10n" => $l10n
        ]);
    }

}
