<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php $nodes = []; ?>

<?php foreach ($rows as $id => $row) $nodes[$id] = node_load(str_replace(' ', '', $row)); ?>


<div class="vertical-tabs mob-block">

  <ul class="nav nav-tabs vertical" role="tablist">
    <?php foreach ($nodes as $id => $node): ?>
      <li role="presentation" class="<?php print ($id == 0)? 'active' : ''; ?>"><a href="#nid-<?php print $node->nid; ?>" aria-controls="nid-<?php print $node->nid; ?>" role="tab" data-toggle="tab"><?php print $node->title; ?></a></li>  
    <?php endforeach; ?>
  </ul>

  <div class="tab-content">
    <?php foreach ($nodes as $id => $node): ?>
      <div role="tabpanel" class="tab-pane<?php print ($id == 0)? ' active' : ''; ?>" id="nid-<?php print $node->nid; ?>">
        <?php print drupal_render(node_view($node)); ?>
      </div>
    <?php endforeach; ?>
  </div>

</div>


