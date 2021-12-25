"use strict";
jQuery(document).ready(function ($) {
    function add_image(obj) {
        console.log('kuku')
        var parent = jQuery(obj).parent().parent('div.field_row');
        var inputField = jQuery(parent).find("input.meta_image_url");
        tb_show('', 'media-upload.php?TB_iframe=true');
        window.send_to_editor = function (html) {
            var url = jQuery(html).find('img').attr('src');
            inputField.val(url);
            jQuery(parent)
                .find("div.image_wrap")
                .html('<img src="' + url + '" height="48" width="48" />');
            // inputField.closest('p').prev('.awdMetaImage').html('<img height=120 width=120 src="'+url+'"/><p>URL: '+ url + '</p>');
            tb_remove();
        };
        return false;
    }

    function remove_field(obj) {
        var parent = jQuery(obj).parent().parent();
        //console.log(parent)
        parent.remove();
    }

    function kuku() {
        var row = jQuery('#master-row').html();
        jQuery(row).appendTo('#field_wrap');
    }

    /**/
    const height = (elem) => {
        return elem.getBoundingClientRect().height
    }
    const distance = (elemA, elemB, prop) => {
        const sizeA = elemA.getBoundingClientRect()[prop]
        const sizeB = elemB.getBoundingClientRect()[prop]
        return sizeB - sizeA
    }
//    owl-carousel
    jQuery('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        nav: true,
        mouseDrag: false,
        autoplay: false,
        animateOut: 'slideOutUp',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });
    /**
     * All Types Meta Box Class JS
     *
     * JS used for the custom metaboxes and other form items.
     *
     * Copyright 2011 - 2013 Ohad Raz (admin@bainternet.info)
     * @since 1.0
     */
    var $ = jQuery.noConflict();
    var e_d_count = 0;
    var Ed_array = Array;
//fix editor on window resize
    jQuery(document).ready(function ($) {
        //editor rezise fix
        jQuery(window).resize(function () {
            $.each(Ed_array, function () {
                var ee = this;
                jQuery(ee.getScrollerElement()).width(100); // set this low enough
                width = jQuery(ee.getScrollerElement()).parent().width();
                jQuery(ee.getScrollerElement()).width(width); // set it to
                ee.refresh();
            });
        });
    });

    function update_repeater_fields() {
        _metabox_fields.init();
    }

//metabox fields object
    var _metabox_fields = {
        oncefancySelect: false,
        init: function () {
            if (!this.oncefancySelect) {
                this.fancySelect();
                this.oncefancySelect = true;
            }
            this.load_code_editor();
            this.load_conditinal();
            this.load_time_picker();
            this.load_date_picker();
            this.load_color_picker();
            // repater Field
            jQuery(".at-re-toggle").on('click', function () {
                jQuery(this).parent().find('.repeater-table').toggle('slow');
            });
            // repeater sortable
            jQuery('.repeater-sortable').sortable({
                opacity: 0.6,
                revert: true,
                cursor: 'move',
                handle: '.at_re_sort_handle',
                placeholder: 'at_re_sort_highlight'
            });
            //jQuery('.repeater-sortable').sortable( "option", "handle", ".at_re_sort_handle" );
        },
        fancySelect: function () {
            if (jQuery().select2) {
                jQuery(".at-select, .at-posts-select, .at-tax-select").each(function () {
                    if (!jQuery(this).hasClass('no-fancy'))
                        jQuery(this).select2();
                });
            }
        },
        get_query_var: function (name) {
            var match = RegExp('[?&]' + name + '=([^&#]*)').exec(location.href);
            return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
        },
        load_code_editor: function () {
            jQuery(".code_text").each(function () {
                // if a code editor is already present, do nothing... #94
                if (jQuery(this).next('.CodeMirror').length) return;
                var lang = jQuery(this).attr("data-lang");
                //php application/x-httpd-php
                //css text/css
                //html text/html
                //javascript text/javascript
                switch (lang) {
                    case 'php':
                        lang = 'application/x-httpd-php';
                        break;
                    case 'css':
                        lang = 'text/css';
                        break;
                    case 'html':
                        lang = 'text/html';
                        break;
                    case 'javascript':
                        lang = 'text/javascript';
                        break;
                    default:
                        lang = 'application/x-httpd-php';
                }
                var theme = jQuery(this).attr("data-theme");
                switch (theme) {
                    case 'default':
                        theme = 'default';
                        break;
                    case 'light':
                        theme = 'solarizedLight';
                        break;
                    case 'dark':
                        theme = 'solarizedDark';
                        break;
                    default:
                        theme = 'default';
                }
                var editor = CodeMirror.fromTextArea(document.getElementById(jQuery(this).attr('id')), {
                    lineNumbers: true,
                    matchBrackets: true,
                    mode: lang,
                    indentUnit: 4,
                    indentWithTabs: true,
                    enterMode: "keep",
                    tabMode: "shift"
                });
                editor.setOption("theme", theme);
                jQuery(editor.getScrollerElement()).width(100); // set this low enough
                width = jQuery(editor.getScrollerElement()).parent().width();
                jQuery(editor.getScrollerElement()).width(width); // set it to
                editor.refresh();
                Ed_array[e_d_count] = editor;
                e_d_count++;
            });
        },
        load_conditinal: function () {
            jQuery(".conditinal_control").click(function () {
                if (jQuery(this).is(':checked')) {
                    jQuery(this).next().show('fast');
                } else {
                    jQuery(this).next().hide('fast');
                }
            });
        },
        load_time_picker: function () {
            jQuery('.at-time').each(function () {
                var $this = jQuery(this),
                    format = $this.attr('rel'),
                    aampm = $this.attr('data-ampm');
                if ('true' == aampm)
                    aampm = true;
                else
                    aampm = false;
                $this.timepicker({showSecond: true, timeFormat: format, ampm: aampm});
            });
        },
        load_date_picker: function () {
            jQuery('.at-date').each(function () {
                var $this = jQuery(this),
                    format = $this.attr('rel');
                $this.datepicker({showButtonPanel: true, dateFormat: format});
            });
        },
        load_color_picker: function () {
            if (jQuery('.at-color-iris').length > 0)
                jQuery('.at-color-iris').wpColorPicker();
        },
    };
//call object init in delay
    window.setTimeout('_metabox_fields.init();', 2000);
//upload fields handler
    var simplePanelmedia;
    jQuery(document).ready(function ($) {
        var simplePanelupload = (function () {
            var inited;
            var file_id;
            var file_url;
            var file_type;

            function init() {
                return {
                    image_frame: [],
                    file_frame: [],
                    hooks: function () {
                        jQuery(document).on('click', '.simplePanelimageUpload,.simplePanelfileUpload', function (event) {
                            event.preventDefault();
                            if (jQuery(this).hasClass('simplePanelfileUpload'))
                                inited.upload(jQuery(this), 'file');
                            else
                                inited.upload(jQuery(this), 'image');
                        });
                        jQuery('.simplePanelimageUploadclear,.simplePanelfileUploadclear').on('click', function (event) {
                            event.preventDefault();
                            inited.set_fields(jQuery(this));
                            jQuery(inited.file_url).val("");
                            jQuery(inited.file_id).val("");
                            if (jQuery(this).hasClass('simplePanelimageUploadclear')) {
                                inited.set_preview('image', false);
                                inited.replaceImageUploadClass(jQuery(this));
                            } else {
                                inited.set_preview('file', false);
                                inited.replaceFileUploadClass(jQuery(this));
                            }
                        });
                    },
                    set_fields: function (el) {
                        inited.file_url = jQuery(el).prev();
                        inited.file_id = jQuery(inited.file_url).prev();
                    },
                    upload: function (el, utype) {
                        inited.set_fields(el)
                        if (utype == 'image')
                            inited.upload_Image(jQuery(el));
                        else
                            inited.upload_File(jQuery(el));
                    },
                    upload_File: function (el) {
                        // If the media frame already exists, reopen it.
                        var mime = jQuery(el).attr('data-mime_type') || '';
                        var ext = jQuery(el).attr("data-ext") || false;
                        var name = jQuery(el).attr('id');
                        var multi = (jQuery(el).hasClass("multiFile") ? true : false);
                        if (typeof inited.file_frame[name] !== "undefined") {
                            if (ext) {
                                inited.file_frame[name].uploader.uploader.param('uploadeType', ext);
                                inited.file_frame[name].uploader.uploader.param('uploadeTypecaller', 'my_meta_box');
                            }
                            inited.file_frame[name].open();
                            return;
                        }
                        // Create the media frame.
                        inited.file_frame[name] = wp.media({
                            library: {
                                type: mime
                            },
                            title: jQuery(this).data('uploader_title'),
                            button: {
                                text: jQuery(this).data('uploader_button_text'),
                            },
                            multiple: multi  // Set to true to allow multiple files to be selected
                        });
                        // When an image is selected, run a callback.
                        inited.file_frame[name].on('select', function () {
                            // We set multiple to false so only get one image from the uploader
                            attachment = inited.file_frame[name].state().get('selection').first().toJSON();
                            // Do something with attachment.id and/or attachment.url here
                            jQuery(inited.file_id).val(attachment.id);
                            jQuery(inited.file_url).val(attachment.url);
                            inited.replaceFileUploadClass(el);
                            inited.set_preview('file', true);
                        });
                        // Finally, open the modal
                        inited.file_frame[name].open();
                        if (ext) {
                            inited.file_frame[name].uploader.uploader.param('uploadeType', ext);
                            inited.file_frame[name].uploader.uploader.param('uploadeTypecaller', 'my_meta_box');
                        }
                    },
                    upload_Image: function (el) {
                        var name = jQuery(el).attr('id');
                        var multi = (jQuery(el).hasClass("multiFile") ? true : false);
                        // If the media frame already exists, reopen it.
                        if (typeof inited.image_frame[name] !== "undefined") {
                            inited.image_frame[name].open();
                            return;
                        }
                        // Create the media frame.
                        inited.image_frame[name] = wp.media({
                            library: {
                                type: 'image'
                            },
                            title: jQuery(this).data('uploader_title'),
                            button: {
                                text: jQuery(this).data('uploader_button_text'),
                            },
                            multiple: multi  // Set to true to allow multiple files to be selected
                        });
                        // When an image is selected, run a callback.
                        inited.image_frame[name].on('select', function () {
                            // We set multiple to false so only get one image from the uploader
                            attachment = inited.image_frame[name].state().get('selection').first().toJSON();
                            // Do something with attachment.id and/or attachment.url here
                            jQuery(inited.file_id).val(attachment.id);
                            jQuery(inited.file_url).val(attachment.url);
                            inited.replaceImageUploadClass(el);
                            inited.set_preview('image', true);
                        });
                        // Finally, open the modal
                        inited.image_frame[name].open();
                    },
                    replaceImageUploadClass: function (el) {
                        if (jQuery(el).hasClass("simplePanelimageUpload")) {
                            jQuery(el).removeClass("simplePanelimageUpload").addClass('simplePanelimageUploadclear').val('Remove Image');
                        } else {
                            jQuery(el).removeClass("simplePanelimageUploadclear").addClass('simplePanelimageUpload').val('Upload Image');
                        }
                    },
                    replaceFileUploadClass: function (el) {
                        if (jQuery(el).hasClass("simplePanelfileUpload")) {
                            jQuery(el).removeClass("simplePanelfileUpload").addClass('simplePanelfileUploadclear').val('Remove File');
                        } else {
                            jQuery(el).removeClass("simplePanelfileUploadclear").addClass('simplePanelfileUpload').val('Upload File');
                        }
                    },
                    set_preview: function (stype, ShowFlag) {
                        ShowFlag = ShowFlag || false;
                        var fileuri = jQuery(inited.file_url).val();
                        if (stype == 'image') {
                            if (ShowFlag)
                                jQuery(inited.file_id).prev().find('img').attr('src', fileuri).show();
                            else
                                jQuery(inited.file_id).prev().find('img').attr('src', '').hide();
                        } else {
                            if (ShowFlag)
                                jQuery(inited.file_id).prev().find('ul').append('<li><a href="' + fileuri + '" target="_blank">' + fileuri + '</a></li>');
                            else
                                jQuery(inited.file_id).prev().find('ul').children().remove();
                        }
                    }
                }
            }

            return {
                getInstance: function () {
                    if (!inited) {
                        inited = init();
                    }
                    return inited;
                }
            }
        })()
        simplePanelmedia = simplePanelupload.getInstance();
        simplePanelmedia.hooks();
    });
});
/**
 * All Types Meta Box Class JS
 */
var $ = jQuery.noConflict();
var e_d_count = 0;
var Ed_array = Array;
//fix editor on window resize
jQuery(document).ready(function ($) {
    //editor rezise fix
    jQuery(window).resize(function () {
        $.each(Ed_array, function () {
            var ee = this;
            jQuery(ee.getScrollerElement()).width(100); // set this low enough
            width = jQuery(ee.getScrollerElement()).parent().width();
            jQuery(ee.getScrollerElement()).width(width); // set it to
            ee.refresh();
        });
    });
});

function update_repeater_fields() {
    _metabox_fields.init();
}

//metabox fields object
var _metabox_fields = {
    oncefancySelect: false,
    init: function () {
        if (!this.oncefancySelect) {
            this.fancySelect();
            this.oncefancySelect = true;
        }
        this.load_code_editor();
        this.load_conditinal();
        this.load_time_picker();
        this.load_date_picker();
        this.load_color_picker();
        // repater Field
        // jQuery(".at-re-toggle").on('click', function() {
        //     jQuery(this).parent().find('.repeater-table').toggle('slow');
        // });
        // // repeater sortable
        // jQuery('.repeater-sortable').sortable({
        //     opacity: 0.6,
        //     revert: true,
        //     cursor: 'move',
        //     handle: '.at_re_sort_handle',
        //     placeholder: 'at_re_sort_highlight'
        // });
        //jQuery('.repeater-sortable').sortable( "option", "handle", ".at_re_sort_handle" );
    },
    fancySelect: function () {
        if (jQuery().select2) {
            jQuery(".at-select, .at-posts-select, .at-tax-select").each(function () {
                if (!jQuery(this).hasClass('no-fancy'))
                    jQuery(this).select2();
            });
        }
    },
    get_query_var: function (name) {
        var match = RegExp('[?&]' + name + '=([^&#]*)').exec(location.href);
        return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    },
    load_code_editor: function () {
        jQuery(".code_text").each(function () {
            // if a code editor is already present, do nothing... #94
            if (jQuery(this).next('.CodeMirror').length) return;
            var lang = jQuery(this).attr("data-lang");
            //php application/x-httpd-php
            //css text/css
            //html text/html
            //javascript text/javascript
            switch (lang) {
                case 'php':
                    lang = 'application/x-httpd-php';
                    break;
                case 'css':
                    lang = 'text/css';
                    break;
                case 'html':
                    lang = 'text/html';
                    break;
                case 'javascript':
                    lang = 'text/javascript';
                    break;
                default:
                    lang = 'application/x-httpd-php';
            }
            var theme = jQuery(this).attr("data-theme");
            switch (theme) {
                case 'default':
                    theme = 'default';
                    break;
                case 'light':
                    theme = 'solarizedLight';
                    break;
                case 'dark':
                    theme = 'solarizedDark';

                    break;
                default:
                    theme = 'default';
            }
            var editor = CodeMirror.fromTextArea(document.getElementById(jQuery(this).attr('id')), {
                lineNumbers: true,
                matchBrackets: true,
                mode: lang,
                indentUnit: 4,
                indentWithTabs: true,
                enterMode: "keep",
                tabMode: "shift"
            });
            editor.setOption("theme", theme);
            jQuery(editor.getScrollerElement()).width(100); // set this low enough
            width = jQuery(editor.getScrollerElement()).parent().width();
            jQuery(editor.getScrollerElement()).width(width); // set it to
            editor.refresh();
            Ed_array[e_d_count] = editor;
            e_d_count++;
        });
    },
    load_conditinal: function () {
        jQuery(".conditinal_control").click(function () {
            if (jQuery(this).is(':checked')) {
                jQuery(this).next().show('fast');
            } else {
                jQuery(this).next().hide('fast');
            }
        });
    },
    load_time_picker: function () {
        jQuery('.at-time').each(function () {
            var $this = jQuery(this),
                format = $this.attr('rel'),
                aampm = $this.attr('data-ampm');
            if ('true' == aampm)
                aampm = true;
            else
                aampm = false;
            $this.timepicker({showSecond: true, timeFormat: format, ampm: aampm});
        });
    },
    load_date_picker: function () {
        jQuery('.at-date').each(function () {
            var $this = jQuery(this),
                format = $this.attr('rel');
            $this.datepicker({showButtonPanel: true, dateFormat: format});
        });
    },
    load_color_picker: function () {
        if (jQuery('.at-color-iris').length > 0)
            jQuery('.at-color-iris').wpColorPicker();
    },
};
//call object init in delay
window.setTimeout('_metabox_fields.init();', 2000);
//upload fields handler
var simplePanelmedia;
jQuery(document).ready(function ($) {
    var simplePanelupload = (function () {
        var inited;
        var file_id;
        var file_url;
        var file_type;

        function init() {
            return {
                image_frame: [],
                file_frame: [],
                hooks: function () {
                    jQuery(document).on('click', '.simplePanelimageUpload,.simplePanelfileUpload', function (event) {
                        event.preventDefault();
                        if (jQuery(this).hasClass('simplePanelfileUpload'))
                            inited.upload(jQuery(this), 'file');
                        else
                            inited.upload(jQuery(this), 'image');
                    });
                    jQuery('.simplePanelimageUploadclear,.simplePanelfileUploadclear').on('click', function (event) {
                        event.preventDefault();
                        inited.set_fields(jQuery(this));
                        jQuery(inited.file_url).val("");
                        jQuery(inited.file_id).val("");
                        if (jQuery(this).hasClass('simplePanelimageUploadclear')) {
                            inited.set_preview('image', false);
                            inited.replaceImageUploadClass(jQuery(this));
                        } else {
                            inited.set_preview('file', false);
                            inited.replaceFileUploadClass(jQuery(this));
                        }
                    });
                },
                set_fields: function (el) {
                    inited.file_url = jQuery(el).prev();
                    inited.file_id = jQuery(inited.file_url).prev();
                },
                upload: function (el, utype) {
                    inited.set_fields(el)
                    if (utype == 'image')
                        inited.upload_Image(jQuery(el));
                    else
                        inited.upload_File(jQuery(el));
                },
                upload_File: function (el) {
                    // If the media frame already exists, reopen it.
                    var mime = jQuery(el).attr('data-mime_type') || '';
                    var ext = jQuery(el).attr("data-ext") || false;
                    var name = jQuery(el).attr('id');
                    var multi = (jQuery(el).hasClass("multiFile") ? true : false);
                    if (typeof inited.file_frame[name] !== "undefined") {
                        if (ext) {
                            inited.file_frame[name].uploader.uploader.param('uploadeType', ext);
                            inited.file_frame[name].uploader.uploader.param('uploadeTypecaller', 'my_meta_box');
                        }
                        inited.file_frame[name].open();
                        return;
                    }
                    // Create the media frame.
                    inited.file_frame[name] = wp.media({
                        library: {
                            type: mime
                        },
                        title: jQuery(this).data('uploader_title'),
                        button: {
                            text: jQuery(this).data('uploader_button_text'),
                        },
                        multiple: multi  // Set to true to allow multiple files to be selected
                    });
                    // When an image is selected, run a callback.
                    inited.file_frame[name].on('select', function () {
                        // We set multiple to false so only get one image from the uploader
                        attachment = inited.file_frame[name].state().get('selection').first().toJSON();
                        // Do something with attachment.id and/or attachment.url here
                        jQuery(inited.file_id).val(attachment.id);
                        jQuery(inited.file_url).val(attachment.url);
                        inited.replaceFileUploadClass(el);
                        inited.set_preview('file', true);
                    });
                    // Finally, open the modal
                    inited.file_frame[name].open();
                    if (ext) {
                        inited.file_frame[name].uploader.uploader.param('uploadeType', ext);
                        inited.file_frame[name].uploader.uploader.param('uploadeTypecaller', 'my_meta_box');
                    }
                },
                upload_Image: function (el) {
                    var name = jQuery(el).attr('id');
                    var multi = (jQuery(el).hasClass("multiFile") ? true : false);
                    // If the media frame already exists, reopen it.
                    if (typeof inited.image_frame[name] !== "undefined") {
                        inited.image_frame[name].open();
                        return;
                    }
                    // Create the media frame.
                    inited.image_frame[name] = wp.media({
                        library: {
                            type: 'image'
                        },
                        title: jQuery(this).data('uploader_title'),
                        button: {
                            text: jQuery(this).data('uploader_button_text'),
                        },
                        multiple: multi  // Set to true to allow multiple files to be selected
                    });
                    // When an image is selected, run a callback.
                    inited.image_frame[name].on('select', function () {
                        // We set multiple to false so only get one image from the uploader
                        attachment = inited.image_frame[name].state().get('selection').first().toJSON();
                        // Do something with attachment.id and/or attachment.url here
                        jQuery(inited.file_id).val(attachment.id);
                        jQuery(inited.file_url).val(attachment.url);
                        inited.replaceImageUploadClass(el);
                        inited.set_preview('image', true);
                    });
                    // Finally, open the modal
                    inited.image_frame[name].open();
                },
                replaceImageUploadClass: function (el) {
                    if (jQuery(el).hasClass("simplePanelimageUpload")) {
                        jQuery(el).removeClass("simplePanelimageUpload").addClass('simplePanelimageUploadclear').val('Remove Image');
                    } else {
                        jQuery(el).removeClass("simplePanelimageUploadclear").addClass('simplePanelimageUpload').val('Upload Image');
                    }
                },
                replaceFileUploadClass: function (el) {
                    if (jQuery(el).hasClass("simplePanelfileUpload")) {
                        jQuery(el).removeClass("simplePanelfileUpload").addClass('simplePanelfileUploadclear').val('Remove File');
                    } else {
                        jQuery(el).removeClass("simplePanelfileUploadclear").addClass('simplePanelfileUpload').val('Upload File');
                    }
                },
                set_preview: function (stype, ShowFlag) {
                    ShowFlag = ShowFlag || false;
                    var fileuri = jQuery(inited.file_url).val();
                    if (stype == 'image') {
                        if (ShowFlag)
                            jQuery(inited.file_id).prev().find('img').attr('src', fileuri).show();
                        else
                            jQuery(inited.file_id).prev().find('img').attr('src', '').hide();
                    } else {
                        if (ShowFlag)
                            jQuery(inited.file_id).prev().find('ul').append('<li><a href="' + fileuri + '" target="_blank">' + fileuri + '</a></li>');
                        else
                            jQuery(inited.file_id).prev().find('ul').children().remove();
                    }
                }
            }
        }

        return {
            getInstance: function () {
                if (!inited) {
                    inited = init();
                }
                return inited;
            }
        }
    })()
    simplePanelmedia = simplePanelupload.getInstance();
    simplePanelmedia.hooks();
    baguetteBox.run(".gallery", {
        animation: "slideIn"
    });
});
