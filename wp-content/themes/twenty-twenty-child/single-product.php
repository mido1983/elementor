<?php
    /**
     * Template Name: productMD
     * Template Post Type: post
     */
   ?>
<?php get_template_part('parts/header'); ?>
<main id="mido-site-content" class="mido-single-1" role="main">
    <?php
        if ( have_posts() )
        {
            while ( have_posts() )
            {
                the_post();
                get_template_part( 'parts/content-cover' );
            }
        }
    ?>
</main><!-- #site-content -->
<?php    get_template_part('parts/footer'); ?>

