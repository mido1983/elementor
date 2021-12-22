<?php
    include_once 'inc/connections.php';
    include_once 'core/class-disable-admin-bar.php';
    include_once 'core/class-custom-post-type.php';
    
    
    /**
     * Disable Admin Bar for specific users
     **/
    
    $data = new DisableAdminBar;
    $usersDisableAdminBarList = ['wptest@elementor.com', 'test@test.com', 'test1@gmail.com'];
    if ($data->mido_check_user_email($usersDisableAdminBarList))
        add_filter('show_admin_bar', '__return_false');
    
    /**
     * Create custom post-type
     **/
    
    $product = new CustomPostType(
        array(
            'post_type_name'        => 'product',
            'name'                  => 'Products',
            'singular_name'         => 'Product',
            'add_new'               => 'Add New Product',
            'add_new_item'          => 'Add New Product',
            'edit_item'             => 'Edit Product',
            'new_item'              => 'New Product',
            'all_items'             => 'All Products',
            'view_item'             => 'View Product',
            'search_items'          => 'Search Products',
            'not_found'             => 'No Products Found',
            'not_found_in_trash'    => 'No Products found in Trash',
            'parent_item_colon'     => '',
            'menu_name'             => 'Products',
            'slug'                  => 'product',
            'plural'                => 'Products',
            'menu_icon'             => 'dashicons-randomize',
            'supports' => array(
                'title',
                'editor',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'thumbnail',
                'author',
                'page-attributes',
            ),
        )
    );
    
    $product->register_taxonomy(
        array(
            'taxonomy_name' => 'products',
            'singular'      => 'product category',
            'plural'        => 'Products',
            'slug'          => 'product',
        )
    );
    
    
    $product->columns(
        array(
            'cb'            => '<input type="checkbox" />',
            'title'         => __('Title'),
            'products'      => __('Category'),
            'price'         => __('Price'),
            'sale-price'    => __('Sale price'),
            'date'          => __('Date'),
        )
    );
    
    /**
     *  Change image size
     */
    function wpse_setup_theme()
    {
        add_theme_support('mido-post-thumbnails');
        add_image_size('small-thumb', 230, 230, true);
    }
    
    add_action('after_setup_theme', 'wpse_setup_theme');
