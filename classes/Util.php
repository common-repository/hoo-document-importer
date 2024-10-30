<?php

namespace HooDocImporter;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Util
{

    private static $twig;

    public static function getTwig() {
        if (!isset(self::$twig)) {
            $loader = new FilesystemLoader(dirname(HOO_DOC_IMPORTER_PLUGIN_FILE) . "/templates");
            self::$twig = new Environment($loader, [
                "debug" => defined("WP_DEBUG") && WP_DEBUG
            ]);

            if (self::$twig->isDebug()) {
                self::$twig->addExtension(new DebugExtension());
            }
        }

        return self::$twig;
    }

    public static function data_to_img($match) {
        list(, $img, $type, $base64, $end) = $match;
        $upload_dir = wp_upload_dir();
        $file_path = apply_filters('hoodoc_image_path', $upload_dir['path']);
        $file_url = apply_filters('hoodoc_image_url', $upload_dir['url']);

        $bin = base64_decode(self::str_trim($base64));
        $filename = apply_filters('hoodoc_image_filename', md5($bin));

        $img_url = $file_url.'/'.$filename.'.'.$type;
        $fn = $file_path.'/'.$filename.'.'.$type;
        
        if (!file_exists($fn)){
            file_put_contents($fn, $bin);
            $filetype = wp_check_filetype( basename( $fn ), null );
            $attachment = array(
                'guid'           => $img_url, 
                'post_mime_type' => $filetype['type'],
                'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $fn ) ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );
            
            $attach_id = wp_insert_attachment( $attachment, $fn );
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            
            $attach_data = wp_generate_attachment_metadata( $attach_id, $fn );
            wp_update_attachment_metadata( $attach_id, $attach_data );
        }
        
        return "$img$img_url$end";
    }

    public static function str_trim($str) {
        $search = array(" ","　","\n","\r","\t");
        $replace = array("","","","","");
        return str_replace($search, $replace, $str);
    }
}
