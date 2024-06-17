<?php
/**
 * Breadcrumbs plugin Yoast SEO
 */
?>


<div class="d-inline-flex">
    <span class="icon-home me-1 text-primary" style="margin-top: 2px;"></span>
    <?php if (function_exists('yoast_breadcrumb')) {
        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
    } ?>
</div>