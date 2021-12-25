<?php
    /*
    Template Name: Shop
    Template Post Type: page
    */
    get_template_part('parts/header');
    $args = array('post_type' => 'product', 'posts_per_page' => 10);
    $the_query = new WP_Query($args);
    $userId = get_current_user_id();
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $bgimage = get_the_post_thumbnail_url($post->ID);
            $lable = implode(get_post_meta($post->ID, 'product_is_on_sale'));
            ?>
            <div class="col home-page-col">
                <a href="<?php echo get_permalink($post->ID); ?>" class="card">
                    <div class="card__head">
                        <div class="card__image" style="background-image: url(<?php echo $bgimage ?>)"></div>
                        <?php
                            if (!empty($lable) && $lable != 0) {
                                ?>
                                <div class="on_sale">
                                    <span class="on_sale_text">On Sale!</span>
                                </div>
                            <?php } ?>
                        <div class="card__author">
                            <div class="author">
                                <img src="<?php echo get_avatar_url($userId); ?>" alt="<?php the_title(); ?>" class="author__image">
                            </div>
                        </div>
                    </div>
                    <div class="card__body">
                        <h2 class="card__headline"><?php the_title(); ?></h2>
                        <p class="card__text"><?php the_excerpt(); ?></p>
                    </div>
                    <div class="card__foot">
                        <span class="card__link">Read more</span>
                    </div>
                    <div class="card__border"></div>
                </a>
            </div>
            <?php
            wp_reset_postdata();
        }
        ?>
        </div>
        <?php get_template_part('parts/footer'); ?>
        </div>
        <?php
    }
    
   
