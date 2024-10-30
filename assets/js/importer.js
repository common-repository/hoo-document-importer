(function ($) {
    $.extend({

        'hoodoc_words_import_meta_box_popup':function(){
            var frame = wp.media({
                title: hoodoc.l10n.t01,
                button: {
                    text: hoodoc.l10n.t02
                },
               // library: {type: ['application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-word.document.macroEnabled.12','application/vnd.ms-word.template.macroEnabled.12','application/vnd.oasis.opendocument.text','application/vnd.apple.pages','application/pdf','application/vnd.ms-xpsdocument','application/oxps','application/rtf','application/wordperfect','application/octet-stream']},
                multiple: false
            });

            frame.on("select", function () {
                
                var attachment = frame.state().get("selection").first().toJSON();
                var filename = attachment.filename;
                var file_ext = filename.split('.').pop();

                if ( 'docx' !== file_ext ){
                    alert(hoodoc.l10n.t04);
                    return false;
                }

                $("#hoodoc_words_import_meta_box_popup").hide();
                $("#hoodoc_words_import_meta_box_in_progress").show();

                var data = {
                    "action": "hoodoc_to_html",
                    "post_id": attachment.id
                };

                $.post(ajaxurl, data)
                    .done(function (text) {
                        
                        if (document.body.classList.contains( 'block-editor-page' )) {
                            var b = wp.blocks.createBlock("core/freeform", {
                                content: text,
                            });
                            wp.data.dispatch("core/block-editor").insertBlock(b);
                        } else {
                            send_to_editor(text);
                        }

                        $("#hoodoc_words_import_meta_box_in_progress").hide();
                        $("#hoodoc_words_import_meta_box_popup").show();
                    })
                    .fail(function (details) {

                        console.error(details);
                        alert( hoodoc.l10n.t03 );

                        $("#hoodoc_words_import_meta_box_in_progress").hide();
                        $("#hoodoc_words_import_meta_box_popup").show();

                    })
                ;
            });

            frame.open();
        }
    });

    $(document).ready(function () {

        $("#hoodoc_words_import_meta_box_in_progress").hide();
        $("#hoodoc_words_import_meta_box_popup").show();

        var hoodoc_words_import_meta_box_popup = function() {
            
        }

        $(document).on("click", "#hoodoc_words_import_meta_box_popup", function (e) {
            e.preventDefault();
            $.hoodoc_words_import_meta_box_popup();
        })
    });
})(jQuery);