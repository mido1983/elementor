<?php
    
    
    class DisableAdminBar
    {
        public function mido_check_user_email($usersDisableAdminBarList)
        {
            if (is_user_logged_in()) :
                $user = wp_get_current_user();
                $userEmail = $user->data->user_email;
                $isMatching = in_array($userEmail, $usersDisableAdminBarList);
                $response = false;
                if (!empty($isMatching)) :
                    $response = true;
                endif;
                return $response;
            endif;
        }
    }
