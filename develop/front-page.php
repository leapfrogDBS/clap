<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package clap
 */

 get_header(); ?>

 <div id="primary" class="content-area">
     <main id="main" class="site-main">
 
         <?php
         // Custom query to get all projects
         $args = array(
             'post_type' => 'project',
             'posts_per_page' => -1,
         );
         $projects_query = new WP_Query($args);
 
         if ($projects_query->have_posts()) :
             echo '<div class="slide-container">';
             while ($projects_query->have_posts()) :
                 $projects_query->the_post();
 
                 // Get ACF fields
                 $video_url = get_field('video')['url'];
                 $video_preview_url = get_field('video_preview')['url'];
                 $like_number = get_field('number_of_likes'); 
                 $logo = get_field('project_logo');
                 $caption = get_field('project_caption');
                 
                 ?>
 
                 <div class="slide" id="slide-<?php the_ID(); ?>"  data-post-id="<?php the_ID(); ?>">
                    <video src="<?php echo esc_url($video_preview_url); ?>" loop muted playsinline class="default-video"></video>
                    

                    <div class="slide-info flex items-end justify-between container text-white">
                    
                        <div class="project-details max-w-96 flex flex-col items-start gap-y-6">
                            <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>" class="h-14 w-auto">
                            <p><?= $caption; ?></p>
                            <div>
                                <a href="<?= the_permalink(); ?>" class="uppercase text-black bg-white p-4 inline-block">Watch</a>
                            </div>
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

                     <div class="share-options">
                        <button class="share-option" data-share-type="facebook"><i class="fa fa-facebook"></i></button>
                        <button class="share-option" data-share-type="twitter"><i class="fa fa-twitter"></i></button>
                        <button class="share-option" data-share-type="email"><i class="fa fa-envelope"></i></button>
                        <button class="share-option" data-share-type="copy"><i class="fa fa-link"></i></button>
                    </div>

                    <div class="scroll-down absolute bottom-10 w-full flex justify-center">
                        <i class="fa-solid fa-chevron-down text-4xl text-white p-6 scroll-icon cursor-pointer"></i>
                    </div>
                 </div>
 
             <?php
             endwhile;
             echo '</div>';
         else :
             echo '<p>No projects found.</p>';
         endif;
 
         // Restore original Post Data
         wp_reset_postdata();
         ?>

      
     </main><!-- #main -->
 </div><!-- #primary -->
 
 <?php
  get_footer();
 