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
    <section class="mt-32">
        <div class="container">
            <?php if ($about) : ?>
                <div class="about wysiwyg">
                    <h1>About Us</h1>
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
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
