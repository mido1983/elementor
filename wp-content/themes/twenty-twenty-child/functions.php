<?php
    include_once 'includes/custom-styles-connections.php';
    include_once 'includes/custom-scripts-connections.php';
    include_once 'core/class-disable-admin-bar.php';
    include_once 'core/class-custom-post-type.php';
    include_once 'core/class-admin-custom-fields.php';
    include_once 'core/class-create-shortcode.php';
    
    $data = new DisableAdminBar;
    if ($data->mido_check_user_email())
        add_filter('show_admin_bar', '__return_false');
    
    function wpse_setup_theme()
    {
        add_theme_support('mido-post-thumbnails');
        add_image_size('small-thumb', 230, 230, true);
    }
    add_action('after_setup_theme', 'wpse_setup_theme');
    
    $product = new CustomPostType(
        array(
            'post_type_name' => 'product',
            'name' => 'Products',
            'singular_name' => 'Product',
            'add_new' => 'Add New Product',
            'add_new_item' => 'Add New Product',
            'edit_item' => 'Edit Product',
            'new_item' => 'New Product',
            'all_items' => 'All Products',
            'view_item' => 'View Product',
            'search_items' => 'Search Products',
            'not_found' => 'No Products Found',
            'not_found_in_trash' => 'No Products found in Trash',
            'parent_item_colon' => '',
            'menu_name' => 'Products',
            'slug' => 'product',
            'plural' => 'Products',
            'menu_icon' => 'dashicons-randomize',
            'public'       => true,
            'show_in_rest' => true,
            
        )
    );
    
    $product->register_post_type(
        array(
            'title',
            'thumbnail',
            'excerpt',
            'comments',
            'revisions',
            'author',
            'page-attributes',
        ),
    );
    
    $product->register_taxonomy(
        array(
            'taxonomy_name' => 'products',
            'singular' => 'product category',
            'plural' => 'Products',
            'slug' => 'product',
        )
    );
    
    $product->columns(
        array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title'),
            'products' => __('Category'),
            'price' => __('Price'),
            'sale-price' => __('Sale price'),
            'date' => __('Date'),
        )
    );
    
    $ACF = new ACF();
    $custom_shortcode = new Custom_shortcode();
    
    /**
     * change mobile address bar color
     */
    function color_mobile_address_bar() {
        $color = "#008509";
        //this is for Chrome, Firefox OS, Opera and Vivaldi
        echo '<meta name="theme-color" content="'.$color.'">';
        //Windows Phone **
        echo '<meta name="msapplication-navbutton-color" content="'.$color.'">';
        // iOS Safari
        echo '<meta name="apple-mobile-web-app-capable" content="yes">';
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
        
        
    }
    add_action( 'wp_head', 'color_mobile_address_bar' );
