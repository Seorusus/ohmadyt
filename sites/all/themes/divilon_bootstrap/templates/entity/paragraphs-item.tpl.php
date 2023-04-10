<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="content"<?php print $content_attributes; ?>>
    <?php if(isset($content['field_photos']) && count($content['field_photos'])): ?>
      <div class="connected-carousels">
        <div class="stage">
          <div class="carousel carousel-stage">
            <ul>
              <?php foreach($content['field_photos']['#items'] as $item): ?>
                <li><img src="<?php print image_style_url('600x400_back', $item['uri']); ?>" width="100%" height="auto" alt=""></li>
              <?php endforeach; ?>
            </ul>
          </div>
          <a href="#" class="prev prev-stage"><span>&lsaquo;</span></a>
          <a href="#" class="next next-stage"><span>&rsaquo;</span></a>
        </div>

        <div class="navigation">
          <a href="#" class="prev prev-navigation">&lsaquo;</a>
          <a href="#" class="next next-navigation">&rsaquo;</a>
          <div class="carousel carousel-navigation">
            <ul>
              <?php foreach($content['field_photos']['#items'] as $item): ?>
                <li><img src="<?php print image_style_url('100x100_crop', $item['uri']); ?>" width="100%" height="auto" alt=""></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <?php hide($content['field_photos']); ?>
      </div>
    <?php endif; ?>
    <?php print render($content); ?>
  </div>
</div>
