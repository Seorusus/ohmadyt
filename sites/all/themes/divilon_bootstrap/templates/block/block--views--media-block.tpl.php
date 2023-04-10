<section id="<?php print $block_html_id; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  
    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
      <div class="block-header flex flex-row flex-jcsb flex-aife mob-block">
        <h2 class="block-title"><?php print $title; ?></h2>
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#media" aria-controls="media" role="tab" data-toggle="tab"><?php print t('All media') ?></a></li>
          <li role="presentation"><a href="#photo" aria-controls="photo" role="tab" data-toggle="tab"><?php print t('Only photo') ?></a></li>
          <li role="presentation"><a href="#video" aria-controls="video" role="tab" data-toggle="tab"><?php print t('Only video') ?></a></li>
        </ul>
      </div>
    <?php endif;?>
    <?php print render($title_suffix); ?>

    <div class="tab-content">
      <div role="tabpanel" class="tab-pane block-content active" id="media"><?php print $content ?></div>
      <div role="tabpanel" class="tab-pane block-content" id="photo">
        <?php $block = module_invoke('views', 'block_view', 'media-block_2');
          echo render($block['content']); ?>
      </div>
      <div role="tabpanel" class="tab-pane block-content" id="video">
        <?php $block = module_invoke('views', 'block_view', 'media-block_3');
          echo render($block['content']); ?>
      </div>
    </div>
  
</section>
