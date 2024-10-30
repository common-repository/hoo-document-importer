<?php

if (!defined("WP_UNINSTALL_PLUGIN")) {
    die();
}

delete_option("hoodoc_importer_image_type");