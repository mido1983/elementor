<?php
    include_once 'inc/connections.php';
    include_once 'core/class-disable-admin-bar.php';
    
    
    //Disable Admin Bar for specific users
    $data = new DisableAdminBar;
    $usersDisableAdminBarList = ['wptest@elementor.com', 'test@test.com', 'test1@gmail.com'];
    if ($data->mido_check_user_email($usersDisableAdminBarList))
        add_filter('show_admin_bar', '__return_false');
