<div class="d-flex gap-2">
    
    <?php if (!empty(get_option('options_rs_1'))) : ?>
    <a href="<?= get_option('options_rs_1'); ?>" title="Facebook" class="btn-sociais" target="_blank" rel="noopener noreferrer">
        <span class="icon-facebook"></span>
    </a>
    <?php endif; ?>
    
    <?php if (!empty(get_option('options_rs_2'))) : ?>
    <a href="<?= get_option('options_rs_2'); ?>" title="Instagram" class="btn-sociais" target="_blank" rel="noopener noreferrer">
        <span class="icon-instagram"></span>
    </a>
    <?php endif; ?>

    <?php if (!empty(get_option('options_rs_3'))) : ?>
    <a href="<?= get_option('options_rs_3'); ?>" title="Youtube" class="btn-sociais" target="_blank" rel="noopener noreferrer">
        <span class="icon-youtube-play"></span>
    </a>
    <?php endif; ?>

    <?php if (!empty(get_option('options_rs_4'))) : ?>
    <a href="<?= get_option('options_rs_4'); ?>" title="Linkedin" class="btn-sociais" target="_blank" rel="noopener noreferrer">
        <span class="icon-linkedin"></span>
    </a>
    <?php endif; ?>

    <?php if (!empty(get_option('options_rs_5'))) : ?>
    <a href="<?= get_option('options_rs_5'); ?>" title="X" class="btn-sociais" target="_blank" rel="noopener noreferrer">
        <span class="icon-x"></span>
    </a>
    <?php endif; ?>

</div>

