<?php
    
    $id = the_ID();
    $args = array('post_type' => 'product');
    $the_query = new WP_Query($args);
    $post = get_post($id);
    $postID = $post->ID;
    $customPostMeta = get_post_meta($postID, '', true);
    
    if (!empty($customPostMeta['product_video_link']))
        $youtubeDataArray = explode('=', $customPostMeta['product_video_link'][0]);
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title-product"><h1><?php the_title(); ?></h1></div>
            </div>
        </div>
        <div class="row mido-mb-3 ">
            <div class="col-md-6 col-lg-6 col">
                <img class="img-fluid" src="<?php echo get_the_post_thumbnail_url($postID); ?>" alt="">
            </div>
            <div class="col-md-6 col">
                <ul>
                    <li>lorem</li>
                    <li>lorem</li>
                    <li>lorem</li>
                    <li>lorem</li>
                    <li>lorem</li>
                </ul>
            </div>
            <?php
                if (!empty($customPostMeta['product_video_link']))
                {
                    ?>
                    <div class="col-md-12 has-text-align-center mido-mb-2">
                        <h2>Video</h2>
                    </div>
                    <div class="col-">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $youtubeDataArray[1]; ?>" title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
          <?php } ?>
        </div>
    </div>
</article>
