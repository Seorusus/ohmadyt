<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>


<div id="carousel-topnews" class="carousel-slide" data-ride="no-carousel">
  <!-- 
  <ol class="carousel-indicators">
    <?php //foreach ($rows as $id => $row): ?>
      <li data-target="#carousel-topnews" data-slide-to="<?php //print $id; ?>"<?php //if ($id == 0) print (' class="active"'); ?>></li>
    <?php //endforeach; ?>
  </ol>
  -->

  <!-- Wrapper for slides -->
  <div class="no-carousel-inner" role="listbox">
    <?php foreach ($rows as $id => $row): ?>
      <div class="item<?php if ($id == 0) print (' active'); ?>">
        <div class="item-inner"><?php print $row; ?></div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
