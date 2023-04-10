<?php

/**
 * @file
 * Default theme implementation for entities.
 *
 * Available variables:
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $title: The (sanitized) entity label.
 * - $url: Direct url of the current entity if specified.
 * - $page: Flag for the full page state.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. By default the following classes are available, where
 *   the parts enclosed by {} are replaced by the appropriate values:
 *   - entity-{ENTITY_TYPE}
 *   - {ENTITY_TYPE}-{BUNDLE}
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_entity()
 * @see template_process()
 */
  if(isset($content['field_title']) && (count($content['field_title'])) && ($content['field_title'][0]["#markup"] != '')) {
    $title = $content['field_title'][0]["#markup"];
    if (!$page) hide($content['field_title']);
  }
?>
<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

  <?php if (!$page): ?>
    <span<?php print $title_attributes; ?>>
      <?php if ($url): ?>
        <a href="<?php print $url; ?>">
          <?php print $title; ?>
        </a>
      <?php else: ?>
        <?php print $title; ?>
      <?php endif; ?>
    </span>
  <?php endif; ?>

  <div class="content"<?php print $content_attributes; ?>>
    <?php if ($page): ?>
      <div class="doc-header text-center">
        <div class="gerb gerb-wb"></div>
        <div class="author head"><?php print render($content['field_docauthor']); ?></div>
        <hr />
        <div class="type head"><?php print render($content['field_doctype']); ?></div>
        <div class="row sub-head">
          <div class="col-sm-6 text-center"><?php print render($content['field_date_iso']); ?></div>
          <div class="col-sm-6 text-center">№ <?php print render($content['field_number']); ?></div>
        </div>
        <!-- <div class="city"><?php //print t('Kyiv'); ?></div> -->
        <div class="country"><?php print render($content['field_country']); ?></div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php print render($content['field_title']); ?></div>
        </div>
      </div>
    <?php endif; ?>
    <?php 
      hide($content['field_tags']);
      print render($content); 
    ?>
    <div class="field-name-field-tags">
      <?php foreach($content['field_tags']['#items'] as $t => $term) print l($term['taxonomy_term']->name, 'documents/' . $term['tid']); ?>
    </div>
  </div>
  <?php if ($page): ?>
    <div class="print">
      <button class="btn print-btn"><span class="glyphicon glyphicon-print"></span> &nbsp; <?php print t('Print version'); ?></button>
    </div>
  <?php endif; ?>
</div>
