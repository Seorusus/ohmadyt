<section id="<?php print $block_html_id; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
      <h2 class="block-title"><?php print $title; ?></h2>
    <?php endif;?>
    <?php print render($title_suffix); ?>

    <div class="block-content"><?php print $content ?></div>
  
</section>
