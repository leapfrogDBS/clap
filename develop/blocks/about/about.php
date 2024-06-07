<?php
/**
 * About Block template.
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$tp_code = get_field('trustpilot_code');
$copy = get_acf('about_copy');


// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'about';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}
?>

<section <?= esc_attr( $anchor ); ?> class="<?= esc_attr( $class_name ); ?> relative">
    <div class="container py-6"> 
        <div class="flex flex-col items-center justify-center h-full">  
            <?php if ($tp_code): ?>
                <div class="trustpilot-widget-container mb-6">
                    <?= ($tp_code); ?>
                </div>
            <?php endif; ?>
            <div class="heading-three text-center text-charcoal z-10 relative">
                <?php if ($copy): ?>
                    <?= ($copy); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container p-0">
    <div id="health-badges-slider" class="splide mt-6" aria-label="Health Badges Logos Slider" data-splide='{"type": "loop", "perPage": 6, "perMove": 1, "pagination": false, "gap": "20px", "arrows": false, "pauseOnHover": true, "autoScroll": {"speed": 0.5, "pauseOnHover": false}, "breakpoints": {"520": {"perPage": 3}, "768": {"perPage": 4}, "1024": {"perPage": 5}} }'>
                <div class="splide__track w-[98%] mx-auto">
                    <ul class="splide__list">
                        <?php if( have_rows('feature_badges') ): ?>
                            <?php while( have_rows('feature_badges') ): the_row(); 
                                $image = get_sub_field('feature_badge');

                                if( $image ): ?>
                                    <li class="splide__slide flex justify-center items-center">
                                        <img src="<?= esc_url($image['url']); ?>" alt="<?= esc_attr($image['alt']); ?>" class="h-24 w-24"/>
                                    </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
    </div>
</section>




