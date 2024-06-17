<?php
/**
 * Template Name: Contact Page
 * The main template file for displaying the contact page
 *
 * @package clap
 */

get_header();

$about = get_field('about_us');
$address = get_field('address');
$email = get_field('email');
$phone = get_field('contact_number');
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<main id="primary" class="site-main">
    <section>
        <div class="container">
            <?php if ($about) : ?>
                <div class="about wysiwyg">
                    <h1 class="mb-6" >About Us</h1>
                    <p><?= wp_kses_post($about); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($address) : ?>
                <div class="address">
                    <p><?= nl2br(esc_html($address)); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($email) : ?>
                <div class="email">
                    <a href="mailto:<?= sanitize_email($email); ?>"><?= esc_html($email); ?></a>
                </div>
            <?php endif; ?>
            <?php if ($phone) : ?>
                <div class="phone">
                    <?php
                    // Remove spaces from phone number for the tel link
                    $phone_link = str_replace(' ', '', $phone);
                    ?>
                    <a href="tel:<?= esc_html($phone_link); ?>"><?= esc_html($phone); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section>
        <div class="container !pt-0">
            <?php get_template_part('template-parts/map'); ?>
        </div>
    </section>

    <section class="social-media-links">
        <div class="container flex items-center gap-x-12 space-y-0 text-3xl">
            <?php
                $fb = get_field('facebook', 'option');
                $x = get_field('x', 'option');
                $insta = get_field('instagram', 'option');
            ?>

            <?php 
                if($fb) :
                    echo '<a href="' .$fb['url'] .'" target="_blank"><i class="fa-brands fa-facebook-f"></i></i></a>';
                endif; 
                if($x) :
                    echo '<a href="' .$x['url'] .'" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>';
                endif; 
                if($insta) :
                    echo '<a href="' .$insta['url'] .'" target="_blank"><i class="fa-brands fa-instagram"></i></i></a>';
                endif; 
            ?>

        </div>
    </section>
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
