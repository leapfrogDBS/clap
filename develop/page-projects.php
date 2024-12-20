<?php
/**
 * Template Name: Projects by Custom Category
 * Description: A template to display projects filtered by a selected custom category.
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php
    // Get the selected custom category from the ACF field
    $selected_category = get_field('selected_category'); // Replace with your ACF field name

    if ($selected_category) {
        // Custom query to get projects in the selected custom category
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'project_category', // Use the custom taxonomy
                    'field' => 'term_id',            // Match by term ID
                    'terms' => $selected_category,   // The selected category from ACF
                ),
            ),
        );

        $projects_query = new WP_Query($args);

        if ($projects_query->have_posts()) :
            echo '<div id="fullpage">';
            $iteration = 1;

            while ($projects_query->have_posts()) :
                $projects_query->the_post();

                // Get ACF fields
                $video_url = get_field('video')['url'];
                $video_preview_url = get_field('video_preview')['url'];
                $like_number = get_field('number_of_likes'); 
                $logo = get_field('project_logo');
                $caption = get_field('project_caption');
                $show_title = get_field('show_title');
                $post_url = get_permalink();

                $autoplay = $iteration === 1 ? "autoplay" : "";

                ?>    
                <div class="section slide" data-anchor="slide-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" data-post-url="<?php echo esc_url($post_url); ?>">

                    <div class="slide-info flex items-end justify-between gap-x-6 container text-white z-50">
                        <div class="project-details max-w-2xl flex flex-col items-start gap-y-6">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                                <img src="<?= esc_url($logo['url']); ?>" alt="<?= esc_attr($logo['alt']); ?>" class="h-16 w-auto">
                                <?php if ($show_title) : ?>
                                    <h2><?= the_title(); ?></h2>
                                <?php endif; ?>
                            </div>
                            <p class="text-lg md:text-2xl font-medium"><?= esc_html($caption); ?></p>
                            <div>
                                <a href="<?= esc_url(get_permalink()); ?>" class="uppercase text-black leading-none font-semibold bg-white py-4 px-6 rounded-full inline-block hover:text-white hover:bg-black transition-all ease-in-out duration-500">Watch</a>
                            </div>
                        </div>
                        <div class="side-bar z-50">
                            <div class="side-icon like-btn" data-liked="false">
                                <i class="fa fa-heart-o like-icon"></i>
                                <p class="like-number"><?php echo esc_html($like_number); ?></p>
                            </div>
                            <div class="side-icon share-btn">
                                <i class="fa fa-share share-icon"></i>
                            </div>
                        </div>
                    </div>

                    <div class="share-options z-50">
                        <button class="share-option" data-share-type="facebook"><i class="fa fa-facebook"></i></button>
                        <button class="share-option" data-share-type="twitter"><i class="fa-brands fa-x-twitter"></i></button>
                        <button class="share-option" data-share-type="email"><i class="fa fa-envelope"></i></button>
                        <button class="share-option" data-share-type="copy"><i class="fa fa-link"></i></button>
                    </div>

                    <div class="scroll-down absolute bottom-0 w-full flex justify-center z-50">
                        <i class="fa-solid fa-chevron-down text-4xl text-white p-6 scroll-icon cursor-pointer"></i>
                    </div>

                    <video src="<?php echo esc_url($video_preview_url); ?>" loop muted playsinline <?= $autoplay ?> class="default-video h-full w-full object-cover z-40 absolute"></video>

                </div>

                <?php
                $iteration++;
            endwhile;
            echo '</div>';
        else :
            echo '<p>No projects found in this category.</p>';
        endif;

        // Restore original Post Data
        wp_reset_postdata();
    } else {
        echo '<p>Please select a category in the page settings.</p>';
    }
    ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
