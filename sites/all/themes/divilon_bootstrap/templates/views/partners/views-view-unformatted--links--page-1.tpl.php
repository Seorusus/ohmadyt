<?php $bid = rand(0, 999999); ?>

<div class="panel panel-default">
  <?php if (!empty($title)): ?>
    <div class="panel-heading" role="tab" id="heading-<?php print $bid; ?>">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php print $bid; ?>" aria-expanded="true" aria-controls="collapse-<?php print $bid; ?>">
          <?php print $title; ?>
        </a>
      </h4>
    </div>
  <?php endif; ?>
  <div id="collapse-<?php print $bid; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php print $bid; ?>">
    <div class="panel-body">
      <?php foreach ($rows as $id => $row): ?>
        <div<?php if ($classes_array[$id]): ?> class="<?php print $classes_array[$id]; ?>"<?php endif; ?>>
          <?php print $row; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>