<?php
require_once HOO_DOC_IMPORTER_DIR_PATH.'/vendor/autoload.php';
require_once HOO_DOC_IMPORTER_INCLUDE_DIR . '/autoloader.php';

\HooDocImporter\Autoloader::run();
\HooDocImporter\AdminSettingsUI::register();
\HooDocImporter\Doc2HtmlAjax::register();
\HooDocImporter\ImporterButton::register();