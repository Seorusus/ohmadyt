
<?php global $user; ?>
<!-- <header id="navbar" role="banner" class="<?php print $container_class; ?>">
  <div class="row">
    <div class="col-md-1">
      <nav class="navbar-default navbar-left">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </nav>
    </div>
    <div class="col-md-10">
      <a href="/">
        <img src="/<?php print $directory ?>/img/_logo_uk.png" />
        <?php print $site_name ?>
      </a>    
    </div>
    <div class="col-md-1 text-right"></div>
  </div>
</header> -->

<div class="main-container flex">
  <div class="main-nav">
    <a class="logo" href="/"></a>
    <?php print render($primary_nav); ?>
  </div>
  <div class="main-content main-container <?php print $container_class; ?>">
    <div class="row">
      <div class="col-12 text-right top-nav">
        <?php $user->uid && print l($user->name, 'user', ['attributes' => ['class' => ['personal']]]);  ?>
      </div>

    </div>
  
    <?php if ($clock && false): ?>
    <div class="frontPageClock">
      <div class="dateContainer"><?php print format_date(time(), 'custom', 'l, d F') ?></div>
      <div class="timeContainer"></div>
    </div>
    <?php endif; ?>
    <?php
      print theme('links', array('links' => menu_navigation_links('main-menu', 1)));
    ?>
    <a id="main-content"></a>
    <?php if (!empty($title)): ?>
      <h1 class="page-header"><?php print $title; ?></h1>
    <?php endif; ?>
    <?php print $messages; ?>
    <?php if (!empty($page['highlighted'])): ?>
      <div class="highlighted"><?php print render($page['highlighted']); ?></div>
    <?php endif; ?>
    <div class="row">
      <section class="content-bar <?php print (empty($page['sidebar']))? 'col-md-12' : 'col-md-8'; ?>">
        <?php if (!empty($title) && $is_front && false): ?>
          <h1 class="page-header"><?php print $title; ?></h1>
        <?php endif; ?>
        <?php if (!empty($tabs)): ?>
          <?php print render($tabs); ?>
        <?php endif; ?>
        <?php if (!empty($page['help'])): ?>
          <?php print render($page['help']); ?>
        <?php endif; ?>
        <?php if (!empty($action_links)): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
      </section>
      <?php if (!empty($page['sidebar'])): ?>
      <section class="side-bar col-md-4">
      <?php print render($page['sidebar'])?>
      </section>
      <?php endif; ?>
    </div>
    <?php if (!empty($page['highlighted_bottom'])): ?>
      <div class="highlighted_bottom"><?php print render($page['highlighted_bottom']); ?></div>
    <?php endif; ?>

    <?php print render($page['footer_right']); ?>
    
  </div>
</div>

<!-- <footer id="footer" <?php if ($is_front) print ('class="front-page"') ?>>
  <div class="<?php print $container_class; ?>">
    <?php print render($page['footer']); ?>
    <div class="row">
      <div class="col-md-6">
        <?php print render($page['footer_left']); ?>
      </div>
      <div class="col-md-6">
        <?php print render($page['footer_right']); ?>
      </div>
    </div>
  </div>
</footer> -->
