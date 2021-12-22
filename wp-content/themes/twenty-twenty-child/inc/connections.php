<?php

//Styles
    
    add_action('wp_enqueue_scripts', 'child_styles');
    add_action('admin_enqueue_scripts', 'admin_style');
    
    function child_styles()
    {
        wp_enqueue_style('bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css');
        wp_enqueue_style('animate', '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css');
        wp_enqueue_style('owl-carousel', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css');
        wp_enqueue_style('owl-theme-default', '//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css');
        wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array(), null);
    }
    
    function admin_style()
    {
        wp_enqueue_style('admin-style', get_stylesheet_directory_uri() . '/admin-style.css');
    }
    
    //Scripts
    
    add_action( 'wp_enqueue_scripts', 'custom_scripts' );
    
    function custom_scripts() {
        //wp_enqueue_script( 'responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );
        wp_enqueue_script('bootstrap-bundle-min', get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js', array( 'jquery' ));
        wp_enqueue_script('bootstrap-min-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ));
        wp_enqueue_script('owl-carousel', "//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js", array( 'jquery' ));
        wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom_script.js', array( 'jquery' ));
    }
