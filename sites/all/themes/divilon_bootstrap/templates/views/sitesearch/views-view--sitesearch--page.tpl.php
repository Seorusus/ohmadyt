<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($header): ?>
    <div class="row">
      <div class="col-sm-3">  
        <!-- <div class="view-header">
          <?php //print $header; ?>
        </div> -->
        <div class="search_counts block">
          <?php 
            $block = module_invoke('divilon_theme', 'block_view', 'search_counts');
            print '<h4 class="block-title text-uppercase">' . t('By type of Node') . '</h4>';
            echo render($block['content']); 
          ?>
        </div>
      </div>
      <div class="col-sm-9">
  <?php endif; ?>

  <?php //if ($exposed): ?>
    <div class="view-filters">
      <?php //print $exposed; ?>
      <?php 
          $block = module_invoke('views', 'block_view', '-exp-sitesearch-page');
          echo render($block['content']); 
        ?>
    </div>
  <?php //endif; ?>

  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

  <?php if ($header): ?>
      </div>
    </div>
  <?php endif; ?>

</div>
