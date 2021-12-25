<?php
    
    class Custom_shortcode {
       
        public $tag;
        
        public function __construct()
        {
           add_shortcode('kklk', array($this, 'shortcode'));
        }
        
        public function shortcode($atts, $content = null)
        {
           
//            $data = get_post_meta($atts['id']);
//            $img  = get_the_post_thumbnail_url($atts['id']);
//            $data1 = get_post($atts['id']);
//            $title = $data1->post_title;
//            $arr = [];
//            $arr['title'] = @$title;
//            $arr['image'] = @$img;
//            $arr['name'] = @$atts['name'];
//            $arr['bg-color'] = @$atts['bg-color'];
//            $arr['price'] = @$data['product_price'];
//
//
//            $atts = shortcode_atts($arr , $atts, 'kklk' );
//
//           return implode(",", $atts);
        }
    }
    
