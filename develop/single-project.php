<?php
/**
 * The main template file for displaying single projects
 *
 * This template is used to display individual project posts.
 *
 * @package clap
 */

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        $post_id = get_the_ID();
        $video_url = get_field('video')['url'];
        $video_thumbnail = get_field('video_thumbnail');
        $caption = get_field('project_caption');
        $copy = get_field('body_text');
        $like_number = get_field('number_of_likes'); 
        $post_url = get_permalink();
        $logo = get_field('project_logo');
        $show_title = get_field('show_title');
        ?>

        <main id="primary" class="site-main min-h-screen relative" data-post-id="<?php echo esc_attr($post_id); ?>" data-post-url="<?php echo esc_url($post_url); ?>">
            <section>
                <div class="container">
                    <div class="back-to-home-link w-full text-right">
                        <a href="<?= home_url(); ?>/#slide-<?= $post_id; ?>"><i class="fa-solid fa-x p-4 text-2xl sm:text-4xl"></i></a>
                    </div>
                    <video
                        class="w-full max-w-6xl mx-auto"
                        src="<?php echo esc_url($video_url); ?>"
                        playsinline
                        controls
                        <?php if (!empty($video_thumbnail)): ?>
                             poster="<?php echo esc_url($video_thumbnail['url']); ?>"
                        <?php endif; ?>
                        >
                    </video> 
                </div>
            </section>
            <section>
                <div class="container !pt-0 flex flex-col md:flex-row items-end justify-between gap-x-12 gap-y-4 !pb-20">
                    <div class="info w-full">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 mb-10">
                                <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" class="h-16 w-auto">
                                <?php if($show_title) : ?>
                                    <h2><?= the_title(); ?></h2>
                                <?php endif; ?>
                            </div>
                        <p class="text-lg md:text-2xl font-medium mb-6"><?= $caption; ?></p>    
                        <div class="wysiwyg"><?php echo wp_kses_post($copy); ?></div>
                        <?php if (have_rows('person')) : ?>
                            <div id="credits" class="lg:columns-2 my-6 font-medium">
                                <?php
                                while (have_rows('person')) : the_row() ;
                                    $position = get_sub_field('position');
                                    $name = get_sub_field('name');
                                    $link = get_sub_field('link');
                                ?>
                                    <div class="flex items-center gap-x-2 mb-2">
                                        <p class=""w-max><?= $position; ?>:</p>
                                        <p>
                                            <?php 
                                            if ($link) echo '<a href="' . $link['url'] . '" target="_blank">'; 
                                            echo $name;
                                            if ($link) echo '</a>'; 
                                            ?>
                                        </p>
                                    </div>    
                                <?php
                                endwhile; ?>
                            </div>
                        <?php
                         endif; ?>
                    </div>
                    <div class="side-bar">
                        <div class="side-icon like-btn" data-liked="false">
                            <i class="fa fa-heart-o like-icon"></i>
                            <p class="like-number"><?php echo esc_html($like_number); ?></p>
                        </div>
                        <div class="side-icon share-btn">
                            <i class="fa fa-share share-icon"></i>
                        </div>
                    </div>
                </div>
            </section>
           
            <div class="share-options ">
                <button class="share-option" data-share-type="facebook"><i class="fa fa-facebook"></i></button>
                <button class="share-option" data-share-type="twitter"><i class="fa-brands fa-x-twitter"></i></button>
                <button class="share-option" data-share-type="email"><i class="fa fa-envelope"></i></button>
                <button class="share-option" data-share-type="copy"><i class="fa fa-link"></i></button>
            </div>
            
        </main><!-- #main -->

       

        <?php
    endwhile;
endif;

get_footer();
?>

