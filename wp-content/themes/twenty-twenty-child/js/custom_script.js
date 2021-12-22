"use strict";
jQuery(document).ready(function($) {

//    owl-carousel
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        dots:false,
        nav:true,
        mouseDrag:false,
        autoplay:false,
        animateOut: 'slideOutUp',
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });

    function add_image(obj) {
        console.log('kuku')
        var parent=jQuery(obj).parent().parent('div.field_row');
        var inputField = jQuery(parent).find("input.meta_image_url");

        tb_show('', 'media-upload.php?TB_iframe=true');

        window.send_to_editor = function(html) {
            var url = jQuery(html).find('img').attr('src');
            inputField.val(url);
            jQuery(parent)
                .find("div.image_wrap")
                .html('<img src="'+url+'" height="48" width="48" />');

            // inputField.closest('p').prev('.awdMetaImage').html('<img height=120 width=120 src="'+url+'"/><p>URL: '+ url + '</p>');

            tb_remove();
        };

        return false;
    }

    function remove_field(obj) {
        var parent=jQuery(obj).parent().parent();
        //console.log(parent)
        parent.remove();
    }

});
