<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
$title = explode(' | ', $title);
?>
<?php if (!empty($title)): ?>
  <h3 class="views-row"><span class="views-field"></span><span class="views-field views-field-nothing"><?php print $title[0]; ?><span class="block"><?php print $title[1]; ?></span></span></h3>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div<?php if ($classes_array[$id]): ?> class="<?php print $classes_array[$id]; ?>"<?php endif; ?>>
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
