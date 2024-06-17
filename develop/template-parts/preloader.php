<div id="preloader">

    <div class="preloader-icon h-24 w-auto">
    <?php
        $svg_file = get_template_directory() . '/assets/img/logo.svg';
        if (file_exists($svg_file)) {
            echo file_get_contents($svg_file);
        } else {
            echo '<!-- SVG file not found -->';
        }
    ?>
    </div>
</div>
