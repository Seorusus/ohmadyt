<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if ((!$page && !empty($title)) || !empty($title_prefix) || !empty($title_suffix) || $display_submitted): ?>
  <header>
    <?php print render($title_prefix); ?>
    <?php if (!$page && !empty($title)): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
    <?php if ($display_submitted): ?>
    <span class="submitted">
      <?php print $user_picture; ?>
      <?php print $submitted; ?>
    </span>
    <?php endif; ?>
  </header>
  <?php endif; ?>
  <?php
    // Hide comments, tags, and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_tags']);
    print render($content);
  ?>
  <?php
    // Only display the wrapper div if there are tags or links.
    $field_tags = render($content['field_tags']);
    $links = render($content['links']);
    if ($field_tags || $links):
  ?>
   <footer>
     <?php print $field_tags; ?>
     <?php print $links; ?>
  </footer>
    <?php endif; ?>
  <?php print render($content['comments']); ?>
  <?php if ($type == 'rubric'): ?>
    <div class="children clearfix">
      <?php 
        if($node->field_layout['und'][0]['value'] == 'list') $block = module_invoke('views', 'block_view', '0de3c4cf43f04a23cc116391e26e71a8');
        if($node->field_layout['und'][0]['value'] == 'grid') $block = module_invoke('views', 'block_view', 'd9ea18023c376a5bbe137a5967c26a59');
        if($node->field_layout['und'][0]['value'] == 'table') $block = module_invoke('views', 'block_view', 'f85937253ffcad8bdf8e7e3e80582488');
        echo render($block['content']); ?>
    </div>
  <?php endif; ?>
  <?php if ($type == 'news'): ?>
    <div class="children">
      <?php 
        if(count ($node->field_gallery)) print ('<div class="views-field-title"><div class="node-photo">' . l(t("See photo"), "node/" . ($node->field_gallery["und"][0]["target_id"])) . '</div></div>');
        if(count ($node->field_video)) print ('<div class="views-field-title"><div class="node-photo">' . l(t("See video"), "node/" . ($node->field_video["und"][0]["target_id"])) . '</div></div>');
        // $block = module_invoke('views', 'block_view', '12d90cdcdbb714688b60d208ea769322');
        // echo render($block['content']); ?>
    </div>
  <?php endif; ?>
  <?php if ($type == 'chronology'): ?>
    <div class="children">
      <?php 
        if(count ($node->field_gallery)) print ('<div class="views-field-title"><div class="node-photo">' . l(t("See photo"), "node/" . ($node->field_gallery["und"][0]["target_id"])) . '</div></div>');
      ?>
    </div>
  <?php endif; ?>
</article>