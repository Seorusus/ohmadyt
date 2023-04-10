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
    // print render($content);
    if($page):
  ?>
    <div class="content row">
      <div class="col-sm-6 left-col">
        <?php print render($content['field_vacancy_general_competenci']); ?>
        <?php print render($content['field_vacancy_responsibilities']); ?>
        <?php print render($content['field_vacancy_term_of_appointmen']); ?>
        <?php print render($content['field_vacancy_wage_conditions']); ?>
      </div>
      <div class="col-sm-6 right-col">
        <div class="well">
          <div class="field field-salary">
            <div class="field-label"><?php print t('Wage level'); ?></div>
            <div class="fields-inline">
              <?php print render($content['field_vacancy_salary_min']); ?>
              <?php print render($content['field_vacancy_salary_max']); ?>
              <div class="field"><?php print t('uah'); ?>.</div>
            </div>
          </div>
          <?php print render($content['field_vacantion_category']); ?>
          <?php print render($content['field_vacancy_status']); ?>
        </div>

        <div class="well">
          <?php print render($content['field_vacancy_adress']); ?>
          <div class="field field-contacts">
            <div class="field-label"><?php print t('Contacts of the responsible person'); ?>:</div>
            <div class="fields-inline">
              <?php print render($content['field_vacancy_contact_lname']); ?>
              <?php print render($content['field_vacancy_contact_name']); ?>
              <?php print render($content['field_vacancy_contact_midname']); ?>
            </div>
            <?php print render($content['field_vacancy_contact_phone']); ?>
            <?php print render($content['field_vacancy_contact_email']); ?>
          </div>
          <?php print render($content['field_vacancy_start_date']); ?>
          <?php print render($content['field_vacancy_end_date']); ?>
          <?php print render($content['field_vacancy_created_at']); ?>
        </div>

        <?php if(date('d.m.Y') > date('d.m.Y', strtotime($node->field_vacancy_end_date['und'][0]['value']))) print('<span class="btn btn-warning disabled">' . t('Acceptance of documents is completed') . '</span>'); ?>

        <?php print l(t('On career.gov.ua'), 'https://career.gov.ua/site/view-vacantion?id=' . $node->field_vacancy_id['und'][0]['value'], array('attributes' => array('class' => array('btn', 'btn-primary'), 'target' => '_blank'))); ?>
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
  <!-- <div class="share text-right pull-right">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php print url('/', array('absolute' => TRUE)) . 'node/' . $nid; ?>" class="share-link"><i class="fab fa-facebook-f"></i></a>
    <a href="https://twitter.com/intent/tweet?url=<?php print url('/', array('absolute' => TRUE)) . 'node/' . $nid; ?>" class="share-link"><i class="fab fa-twitter"></i></a>
    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php print url('/', array('absolute' => TRUE)) . 'node/' . $nid; ?>" class="share-link"><i class="fab fa-linkedin-in"></i></a>
    <a href="https://t.me/share/url?url=<?php print url('/', array('absolute' => TRUE)) . 'node/' . $nid; ?>" class="share-link mob-only"><i class="fab fa-telegram-plane"></i></a>
    <a href="viber://forward?text=<?php print url('/', array('absolute' => TRUE)) . 'node/' . $nid; ?>" class="share-link mob-only"><i class="fab fa-viber"></i></a>
    <a href="whatsapp://send?text=<?php print url('/', array('absolute' => TRUE)) . 'node/' . $nid; ?>" class="share-link mob-only"><i class="fab fa-whatsapp"></i></a>
  </div> -->
</article>