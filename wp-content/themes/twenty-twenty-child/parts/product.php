<?php
    get_template_part('parts/header');
    the_title();
    $args = array('post_type' => 'product', 'posts_per_page' => 10);
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) { ?>
        <div class="container">
            <div class="row">
                <?php
                    while ($the_query->have_posts()) {
                        $the_query->the_post(); ?>
                        <div class="col">
                            <div class="card">
                                <a href="<?php echo get_permalink($post->ID); ?>">
                                    <img class="card-img-top" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                        wp_reset_postdata();
                    }
                ?>
            </div>
        </div>
        <?php
    }
    
    get_template_part('parts/footer');
