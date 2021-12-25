<?php
    add_action( 'wp_enqueue_scripts', 'child_styles' );
    add_action( 'admin_enqueue_scripts', 'admin_style');
    

    
    function child_styles() {
        wp_enqueue_style( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
        wp_enqueue_style( 'animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css' );
        wp_enqueue_style( 'owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' );
        wp_enqueue_style( 'owl-theme-default', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css' );
        wp_enqueue_style( 'baguetteBox', 'https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css' );
      
        
            wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array(), null  );
        
    }
    function admin_style() {
        wp_enqueue_style( 'bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' );
        wp_enqueue_style( 'animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css' );
        wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/admin-style.css' );
    }
