<?php
    add_action( 'wp_enqueue_scripts', 'custom_scripts' );
    
    function custom_scripts() {
        //wp_enqueue_script( 'responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
        
        wp_enqueue_script('bootstrap-bundle-min', get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js', array( 'jquery' ));
        //wp_enqueue_script('bootstrap-bundle-min-js-map', get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js.map', array( 'jquery' ));
        wp_enqueue_script('bootstrap-min-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ));
        wp_enqueue_script('owl-carousel', "//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js", array( 'jquery' ));
        wp_enqueue_script('baguetteBox', "//cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js", array( 'jquery' ));
        wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom_script.js', array( 'jquery' ));
  
    }
