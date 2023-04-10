<?php 
  $node = node_load($fields['nid']->content);
  // dpm($node);
?>
<div class="flex flex-1 mob-block">
  <div class="flex flex-1 flex-row flex-aic mob-block">
    <div class="flex flex-2 flex-column img-column mob-block">
      <?php print $fields['field_image']->content; ?>
      <?php if(count($node->nodehierarchy_menu_links) > 0) print ('<div class="videoicon"></div>') ?>
    </div>
    <div class="flex flex-1 flex-column text-column mob-block">
      <?php unset ($fields['field_image']); ?>
      <?php unset ($fields['nid']); ?>
      <?php foreach ($fields as $id => $field): ?>
        <?php if (!empty($field->separator)): ?>
          <?php print $field->separator; ?>
        <?php endif; ?>

        <?php print $field->wrapper_prefix; ?>
          <?php print $field->label_html; ?>
          <?php print $field->content; ?>
        <?php print $field->wrapper_suffix; ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>
