<?php
    
    
    class DisableAdminBar
    {
       
       public function mido_check_user_email()
       {
           $usersDisableAdminBarList = ['wptest@eleme1ntor.com', 'test@test.com', 'test1@gmail.com' ];
           /*@ Check user logged-in */
            if ( is_user_logged_in() ) :
                /*@ Get current logged-in user data */
                $user = wp_get_current_user();
                /*@ Fetch only roles */
                $userEmail = $user->data->user_email;
                /*@ Intersect both array to check any matching value */
                $isMatching = in_array( $userEmail, $usersDisableAdminBarList);
                $response = false;
                /*@ If any role matched then return true */
                if ( !empty($isMatching) ) :
                    $response = true;
                endif;
                return $response;
            endif;
        }
    }
