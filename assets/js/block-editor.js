!function c(i, l, u) {
    function a(t, e) {
        if (!l[t]) {
            if (!i[t]) {
                var r = "function" == typeof require && require;
                if (!e && r) return r(t, !0);
                if (s) return s(t, !0);
                var n = new Error("Cannot find module '" + t + "'");
                throw n.code = "MODULE_NOT_FOUND",
                n
            }
            var o = l[t] = {
                exports: {}
            };
            i[t][0].call(o.exports,
            function(e) {
                return a(i[t][1][e] || e)
            },
            o, o.exports, c, i, l, u)
        }
        return l[t].exports
    }
    for (var s = "function" == typeof require && require,
    e = 0; e < u.length; e++) a(u[e]);
    return a
} ({
    1 : [function(e, t, r) {
        "use strict";
        var n = wp.element.Fragment,
        o = wp.editor.BlockControls,
        c = wp.components,
        i = c.SVG,
        l = c.Path;
        wp.hooks.addFilter("editor.BlockEdit", "hoodoc-importer/with-doc-importer-button",
        function(t) {
            return function(e) {
                return React.createElement(n, null, React.createElement(t, e), React.createElement(o, {
                    controls: [{
                        icon: React.createElement(i, {
                            viewBox: "0 0 20 20",
                            xmlns: "http://www.w3.org/2000/svg"
                        },
                        React.createElement(l, {
                            d: "M 14 3 L 2 5 L 2 19 L 14 21 L 14 19 L 21 19 C 21.552 19 22 18.552 22 18 L 22 6 C 22 5.448 21.552 5 21 5 L 14 5 L 14 3 z M 12 5.3613281 L 12 18.638672 L 4 17.306641 L 4 6.6933594 L 12 5.3613281 z M 14 7 L 20 7 L 20 9 L 14 9 L 14 7 z M 4.5 8.5 L 5.7988281 15.5 L 7.0917969 15.5 L 7.9394531 11.757812 C 7.9804531 11.550813 8.0122969 11.289609 8.0292969 10.974609 L 8.046875 10.974609 C 8.054875 11.262609 8.0781406 11.523813 8.1191406 11.757812 L 8.9492188 15.5 L 10.191406 15.5 L 11.5 8.5 L 10.134766 8.5 L 9.6835938 11.722656 C 9.6505937 11.992656 9.6251875 12.253859 9.6171875 12.505859 L 9.6015625 12.505859 C 9.5775625 12.181859 9.5525312 11.928812 9.5195312 11.757812 L 8.9667969 8.5 L 7.2011719 8.5 L 6.6074219 11.767578 C 6.5494219 12.065578 6.5158125 12.344891 6.5078125 12.587891 L 6.4824219 12.587891 C 6.4744219 12.254891 6.4509688 11.983156 6.4179688 11.785156 L 5.9511719 8.5 L 4.5 8.5 z M 14 11 L 20 11 L 20 13 L 14 13 L 14 11 z M 14 15 L 20 15 L 20 17 L 14 17 L 14 15 z"
                        })),
                        title: HDIBlockEditorL10n.l10n.l01,
                        onClick: function() {
                           
                            var frame = wp.media({
                                title: HDIBlockEditorL10n.l10n.t01,
                                button: {
                                    text: HDIBlockEditorL10n.l10n.t02
                                },
                                //library: {type: ['application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-word.document.macroEnabled.12','application/vnd.ms-word.template.macroEnabled.12','application/vnd.oasis.opendocument.text','application/vnd.apple.pages','application/pdf','application/vnd.ms-xpsdocument','application/oxps','application/rtf','application/wordperfect','application/octet-stream']},
                                multiple: false
                            });

                            frame.on("select", function () {

                                var attachment = frame.state().get("selection").first().toJSON();
                                var filename = attachment.filename;
                                var file_ext = filename.split('.').pop();

                                if ( 'docx' !== file_ext ){
                                    alert(HDIBlockEditorL10n.l10n.t04);
                                    return false;
                                }

                                jQuery("#hoodoc_words_import_meta_box_popup").hide();
                                jQuery('body').append('<div id="import-loading"><img src="'+HDIBlockEditorConfig.url+'assets/img/loading.gif"></div>');

                                var data = {
                                    "action": "hoodoc_to_html",
                                    "post_id": attachment.id
                                };
                
                                jQuery.post(ajaxurl, data)
                                    .done(function (text) {
                                        
                                        var b = wp.blocks.createBlock("core/freeform", {
                                            content: text,
                                        });
                                        wp.data.dispatch("core/block-editor").insertBlock(b);
 
                                        jQuery('body').find("#import-loading").remove();
                                        jQuery("#hoodoc_words_import_meta_box_popup").show();
                                    })
                                    .fail(function (details) {
                
                                        console.error(details);
                                        alert( HDIBlockEditorL10n.l10n.t03 );
                                        jQuery('body').find("#import-loading").remove();
                                        jQuery("#hoodoc_words_import_meta_box_popup").show();
                
                                    })
                                ;
                            });
                
                            frame.open();
                        }
                    }]
                }))
            }
        })
    },
    {}]
},
{},
[1]);