<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div class="clearfix">
  <?php if (!empty($title)): ?>
    <h3 class="col-sm-3"><?php print $title; ?></h3>
  <?php endif; ?>
  <div class="col-sm-9"><div class="row">
    <?php foreach ($rows as $id => $row): ?>
      <div<?php if ($classes_array[$id]): ?> class="<?php print $classes_array[$id]; ?>"<?php endif; ?>>
        <?php print $row; ?>
      </div>
    <?php endforeach; ?>
    </div></div>
</div>