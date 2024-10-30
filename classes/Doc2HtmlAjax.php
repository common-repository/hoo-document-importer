<?php
namespace HooDocImporter;

class Doc2HtmlAjax
{
    public static function register()
    {
        $i = new Doc2HtmlAjax();
        add_action("wp_ajax_hoodoc_to_html", array($i, "callback"));
        add_filter("hoodoc_converted_html", array($i, "data_filter"));
    }

    public function callback()
    {
        $post = get_post($_POST["post_id"]);
        $path_to_file = get_attached_file($post->ID);
        $upload_dir = wp_upload_dir();
        $filename = basename($path_to_file);
        $tmp_file = $upload_dir['path'].'/hoodoc-'.$filename.'.html';
        $inputFileType = apply_filters('hoodoc_input_file_type', 'Word2007');

        \PhpOffice\PhpWord\IOFactory::createReader($inputFileType);
        $phpWord = \PhpOffice\PhpWord\IOFactory::load( $path_to_file );
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, "HTML");
        $xmlWriter -> save($tmp_file);

        $html = file_get_contents($tmp_file);

        preg_match("/<body[^>]*?>(.*\s*?)<\/body>/is",$html,$match1);
        if(isset($match1[1])){
            $html = $match1[1];
        }

        $html = apply_filters('hoodoc_converted_html', $html);

        file_put_contents($tmp_file, $html );
        unlink($tmp_file);
        echo $html;
        exit();
    }

    public function data_filter($html){
        $image_type = get_option('hoodoc_importer_image_type', true);
        if (2 != $image_type){
            $html = preg_replace_callback('#(<img\s(?>(?!src=)[^>])*?src=")data:image/(gif|png|jpeg|jpg|bmp);base64,([\w=+/\r\n]++)("[^>]*>)#', array('\HooDocImporter\Util', 'data_to_img'), $html);
        }
        return $html;
    }
}
