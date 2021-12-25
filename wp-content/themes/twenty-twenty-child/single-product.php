<?php
    /**
     * Template Name: productMD
     * Template Post Type: post
     */
    get_template_part('parts/header');
?>
<?php echo do_shortcode('[kklk]'); ?>
<main id="mido-site-content" class="mido-single-1" role="main">
    <?php
        $id = the_ID();
        $args = array('post_type' => 'product');
        $the_query = new WP_Query($args);
        $post = get_post($id);
        $postID = $post->ID;
        $customPostMeta = get_post_meta($postID, '', true);
        $photos_query = $customPostMeta['gallery_data'][0];
        $photos_array = unserialize($photos_query);
        $url_array = $photos_array['image_url'];
        $count = sizeof($url_array);
        if (!empty($customPostMeta['product_video_link']))
            $youtubeDataArray = explode('=', $customPostMeta['product_video_link'][0]);
    ?>
    <!--Photos-->
    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
        <div class="container">
            <div class="row mido-mb-3 ">
                <div class="col-md-6 col-lg-6 col">
                    <img class="img-fluid" src="<?php echo get_the_post_thumbnail_url($postID); ?>" alt="">
                    <div class="photos">
                        <div class="details-left">
                            <div class="container">
                                <div class="row gallery">
                                    <?php
                                        for ($i = 0; $i < $count; $i++) {
                                            ?>

                                            <div class="col-sm-6 col-md-4 col-lg-3">
                                                <a href="<?php echo $url_array[$i]; ?>">
                                                    <img class="img-fluid" src="<?php echo $url_array[$i]; ?>">
                                                </a>
                                            </div>
                                            
                                            <?php
                                            if ($i == 0) {
                                                $i = 0;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col">

                    <h3 class="title mb-3"><?php the_title(); ?></h3>

                    <p class="price-detail-wrap">
                        <?php
                            if (!empty($customPostMeta['product_is_on_sale'][0]) && $customPostMeta['product_is_on_sale'][0] != 1) {
                                ?>
                                <span class="price h3 text-warning">
		                             <span class="currency">US $</span><span class="num"><?php echo $customPostMeta['product_price'][0] ?></span>
	                            </span>
                            <?php } else {
                                ?>
                                <span class="price h4 text-muted">
		                             <span class="currency">US $</span><span class="num"> <s><?php echo $customPostMeta['product_price'][0] ?></s> </span>
	                             </span>
                                <span class="price h3 text-success">
		                             <span>Sale Price: </span> <span class="currency">US $</span><span class="num"><?php echo $customPostMeta['product_sale_price'][0] ?></span>
                                </span>
                            <?php } ?>
                    </p>
                    <dl class="item-property">
                        <dt>Description:</dt>
                        <dd><p><?php echo $customPostMeta['acf_product_description'][0] ?> </p></dd>
                    </dl>
                    <dl class="param param-feature">
                        <dt>Product ID#</dt>
                        <dd><?php echo $post->ID ?></dd>
                    </dl>
                    <hr>
                    <a href="#" class="btn btn-lg btn-primary text-uppercase"> Buy now </a>
                    <a href="#" class="btn btn-lg btn-outline-primary text-uppercase"> <i class="fas fa-shopping-cart"></i> Add to cart </a>

                </div>
                <?php
                    if (!empty($customPostMeta['product_video_link'])) {
                        ?>
                        <div class="col-md-12 has-text-align-center mido-mb-2">
                            <h2>Video</h2>
                        </div>

                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $youtubeDataArray[1]; ?>" allowfullscreen></iframe>
                        </div>
                    
                    <?php } ?>

            </div>
        </div>
    </article>
    
    <?php
        //Get array of terms
        $terms = get_the_terms($post->ID, 'products', 'string');
        if ($terms) {
            $term_ids = wp_list_pluck($terms, 'term_id');
            $second_query = new WP_Query(
                array(
                    'post_type' => 'product',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'products',
                            'field' => 'id',
                            'terms' => $term_ids,
                            'operator' => 'IN' //Or 'AND' or 'NOT IN'
                        )),
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'rand',
                    'post__not_in' => array($post->ID),
                )
            );
            ?>

            <div class="container">
                <h1 class="display-4">Related products</h1>
            </div>

            <div class="card-group mido-mb-3">
            <?php
            if ($second_query->have_posts()) {
                while ($second_query->have_posts()) : $second_query->the_post(); ?>
                    <div class="card">
                        <a href="<?php the_permalink() ?>">
                            <img class="card-img-top img-fluid" src="<?php the_post_thumbnail('small'); ?>
                        <div class=" card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show
                                that equal height action.</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                    </a>
                    </div>
                <?php endwhile;
                wp_reset_query(); ?>
                </div>
                <?php
            }
        }else
        {
            ?>
            <p>no related products found</p>
    <?php
        }
    ?>

</main><!-- #site-content -->


<?php get_template_part('parts/footer'); ?>

