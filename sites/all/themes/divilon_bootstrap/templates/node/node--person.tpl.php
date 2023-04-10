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
    hide($content['field_phone']);
    hide($content['field_email']);
    hide($content['field_facebook']);
    hide($content['field_twitter']);
  ?>

  <?php if ($page): ?>
    <div class="row">
      <div class="col-sm-4 text-center">
        <?php print render($content['field_image']); ?>
        <?php print render($content['field_lead']); ?>
        <?php if(count($node->field_phone)): ?>
          <div class="field-name-field-phone clearfix"><strong><?php print t('Phone') ?>:&nbsp;</strong><a href="tel:<?php print $node->field_phone['und'][0]['value']; ?>"><?php print $node->field_phone['und'][0]['value']; ?></a></div>
        <?php endif; ?>
        <?php if(count($node->field_email)): ?>
          <div class="field-name-field-email clearfix"><strong><?php print t('E-mail') ?>:&nbsp;</strong><a href="mailto:<?php print $node->field_email['und'][0]['value']; ?>"><?php print $node->field_email['und'][0]['value']; ?></a></div>
        <?php endif; ?>
        <div class="socials flex flex-1 flex-aic flex-jcc">
          <?php if(count($node->field_facebook)): ?>
            <div class="field-name-field-facebook clearfix"><a href="<?php print $node->field_facebook['und'][0]['value']; ?>"><i class="fab fa-facebook-f"></i></a></div>
          <?php endif; ?>
          <?php if(count($node->field_twitter)): ?>
            <div class="field-name-field-twitter clearfix"><a href="<?php print $node->field_twitter['und'][0]['value']; ?>"><i class="fab fa-twitter"></i></a></div>
          <?php endif; ?>
        </div>
        <div class="text-center">
          <p>&nbsp;</p>
          <?php if($node->field_appointment['und'][0]['value']) print l(t('Appointment'), 'appointment', array('query' => array('receiver' => $node->nid), 'attributes' => array('class' => array('btn', 'btn-primary')))); ?>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="row">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#biography" aria-controls="biography" role="tab" data-toggle="tab"><?php print t('Biography'); ?></a></li>
            <li role="presentation"><a href="#responsibilities" aria-controls="responsibilities" role="tab" data-toggle="tab"><?php print t('Division of responsibilities'); ?></a></li>
          </ul>
          <p>&nbsp;</p>
        </div>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="biography">
            <?php print render($content['body']); ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="responsibilities">
            <?php print render($content['field_body']); ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

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
        if(count ($node->field_gallery)) print ('<div class="views-field-title"><div class="node-photo">' . l(t("See gallery"), "node/" . ($node->field_gallery["und"][0]["target_id"])) . '</div></div>');
        if(count ($node->field_video)) print ('<div class="views-field-title"><div class="node-photo">' . l(t("See video"), "node/" . ($node->field_video["und"][0]["target_id"])) . '</div></div>');
        // $block = module_invoke('views', 'block_view', '12d90cdcdbb714688b60d208ea769322');
        // echo render($block['content']); ?>
    </div>
  <?php endif; ?>
  <?php if ($type == 'chronology'): ?>
    <div class="children">
      <?php 
        if(count ($node->field_gallery)) print ('<div class="views-field-title"><div class="node-photo">' . l(t("See gallery"), "node/" . ($node->field_gallery["und"][0]["target_id"])) . '</div></div>');
      ?>
    </div>
  <?php endif; ?>
</article>