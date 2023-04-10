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
    hide($content['field_children']);
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
  <div class="children clearfix">
    <?php 
      if($node->field_layout['und'][0]['value'] == 'list') $block = module_invoke('views', 'block_view', '0de3c4cf43f04a23cc116391e26e71a8');
      if($node->field_layout['und'][0]['value'] == 'grid') $block = module_invoke('views', 'block_view', 'd9ea18023c376a5bbe137a5967c26a59');
      if($node->field_layout['und'][0]['value'] == 'table') $block = module_invoke('views', 'block_view', 'f85937253ffcad8bdf8e7e3e80582488');
      echo render($block['content']); ?>
    <?php if(count ($node->field_children)): ?>
      <div class="reference view">
        <?php if($node->field_layout['und'][0]['value'] == 'grid'): ?>
          <div class="view-display-id-block_3">
            <div class="view-content">
              <?php foreach ($node->field_children['und'] as $id => $item): ?>
                <?php if($item['entity']->status): ?>
                  <div class="views-row">
                    <div class="flex flex-1 flex-column">
                      <div class="flex flex-column image">
                        <a href="<?php print url('node/' . $item["entity"]->nid) ?>">
                          <img class="img-responsive" src="<?php print image_style_url('300x300_face', $item["entity"]->field_image['und'][0]['uri']) ?>" alt="<?php print $item["entity"]->title; ?>">
                        </a>
                      </div>
                      <div class="flex flex-1 flex-column">
                        <div class="title"><a href="<?php print url('node/' . $item["entity"]->nid) ?>"><?php print $item["entity"]->title; ?></a></div>
                        <div class="field_lead"><?php print $item["entity"]->field_lead['und'][0]['value']; ?></div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>

        <?php if($node->field_layout['und'][0]['value'] == 'list'): ?>
          <div class="view-content">
            <?php foreach ($node->field_children['und'] as $id => $item): ?>
              <div class="views-row">
                <div class="title"><a href="<?php print url('node/' . $item["entity"]->nid) ?>"><?php print $item["entity"]->title; ?></a></div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if($node->field_layout['und'][0]['value'] == 'table'): ?>
          <table class="views-table cols-4 table table-hover table-striped">
            <thead>
              <tr>
                <th class="views-field views-field-counter">№</th>
                <th class="views-field views-field-created"><?php print t('Date'); ?></th>
                <th class="views-field views-field-nothing"></th>
                <th class="views-field views-field-field-files"><?php print t('Download'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($node->field_children['und'] as $id => $item): ?>
                <tr class="views-row">
                  <td class="views-field views-field-counter"><?php print $id + 1; ?></td>
                  <td class="views-field views-field-created"><?php print date('d.m.Y', $item["entity"]->created); ?></td>
                  <td class="views-field views-field-nothing">
                    <div class="title"><a href="<?php print url('node/' . $item["entity"]->nid) ?>"><?php print $item["entity"]->title; ?></a></div>
                  </td>
                  <td class="views-field views-field-field-files">
                    <?php if(isset($item["entity"]->field_files) && count($item["entity"]->field_files)): ?>
                      <div class="files">
                        <?php foreach ($item["entity"]->field_files['und'] as $n => $file): ?>
                          <a href="<?php print file_create_url($file['uri']) ?>" download class="files-link"><?php print ($file['description']) ? $file['description'] : $file['filename'] ?></a>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</article>