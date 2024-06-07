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
        $video_url = get_field('video')['url'];
        $copy = get_field('body_text');
        ?>

        <main id="primary" class="site-main">
            <section class="mt-36">
                <div class="container">
                    <div class="back-to-home-link w-full text-right">
                        <a href="<?= home_url(); ?>"><i class="fa-solid fa-x p-4 text-4xl"></i></a>
                    </div>
                    <video src="<?php echo esc_url($video_url); ?>" playsinline controls></video>
                    <h1 class="my-10"><?php the_title(); ?></h1>
                    <div><?php echo wp_kses_post($copy); ?></div>
                </div>
            </section>
        </main><!-- #main -->

        <?php
    endwhile;
endif;

get_footer();
?>

