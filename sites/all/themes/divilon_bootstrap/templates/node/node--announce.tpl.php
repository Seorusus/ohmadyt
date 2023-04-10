<?php 
  $timezoneOfset = date_offset_get(new DateTime($node->field_date_interval['und'][0]['value'], new DateTimeZone('Europe/Kiev')));
  $date1 = strtotime($node->field_date_interval['und'][0]['value']) + $timezoneOfset;
  $date2 = strtotime($node->field_date_interval['und'][0]['value2']) + $timezoneOfset;
  $endaccreditation = strtotime($node->field_acreditation_date['und'][0]['value']) + $timezoneOfset;
  // dpm($timezoneOfset);
?>

<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if ((!$page && !empty($title)) || !empty($title_prefix) || !empty($title_suffix) || $display_submitted): ?>
  <header>
    <?php print render($title_prefix); ?>
    <?php if (!$page && !empty($title)): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>
  </header>
  <?php endif; ?>

  <?php if ($page): ?>
    <div class="flex flex-1 flex-row mob-block announce-header">
      <div class="flex flex-1 flex-column date">
        <div class="flex flex-1 flex-row flex-aife">
          <div class="flex flex-column">
            <div class="day"><?php print date('d', $date1); ?></div>
          </div>
          <div class="flex flex-1 flex-column">
            <div class="week"><?php print t(date('l', $date1)); ?></div>
            <div class="month"><?php print format_date($date1, $type = 'month'); ?></div>
            <div class="year"><?php print date('Y', $date1); ?></div>
          </div>
        </div>
      </div>
      <div class="flex flex-1 flex-column flex-aic time">
        <?php if($date1 == $date2): ?>
          <div class="hour">
            <?php print date('H', $date1); ?><sup class="min"><?php print date('i', $date1); ?></sup>
          </div>
        <?php else: ?>
          <div class="duration">
            <?php 
              print t('Duration') . ' ';
              $H = round((($date2 - $date1) / 3600), $precision = 0, $mode = PHP_ROUND_HALF_DOWN);
              print($H);
              print ' ' . t('hr.') . ' ';
              $m = (($date2 - $date1) % 3600) / 60;
              print($m);
              print ' ' . t('min.');
            ?>
          </div>
          <div class="flex flex-1 flex-row flex-aic">
            <div class="flex flex-column">
              <div class="hour">
                <?php print date('H', $date1); ?><sup class="min"><?php print date('i', $date1); ?></sup>
              </div>
            </div>
            <div class="flex flex-column dash">&ndash;</div>
            <div class="flex flex-column">
              <div class="hour">
                <?php print date('H', $date2); ?><sup class="min"><?php print date('i', $date2); ?></sup>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="flex flex-1 flex-column flex-aic online">
        <?php if($endaccreditation > date()): ?>
          <a href="/accreditation?event=<?php print $nid; ?>" target="_blank" class="btn btn-lg btn-primary"><?php print t('Online accreditation'); ?></a>
        <?php endif; ?>
      </div>
    </div>

    <div class="calendar dropdown">
      <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-default"><i class="fas fa-calendar-alt"></i> &nbsp;<?php print t('Add to calendar'); ?></button>
      <ul class="dropdown-menu" aria-labelledby="dLabel">
        <li><a class="google" target="_blank" href="https://calendar.google.com/calendar/render?action=TEMPLATE&dates=<?php print date('Ymd', $date1); ?>T<?php print date('Hi', strtotime($node->field_date_interval['und'][0]['value'])); ?>00Z%2F<?php print date('Ymd', $date2); ?>T<?php print date('Hi', strtotime($node->field_date_interval['und'][0]['value2'])); ?>00Z<?php if(count($node->field_address)) print ('&location=' . $node->field_address['und'][0]['value']) ?>&text=<?php print $title; ?>">Google Calendar</a></li>
        <li><a class="outlook" target="_blank" href="https://outlook.live.com/calendar/0/deeplink/compose?enddt=<?php print date('Y-m-d', $date2); ?>T<?php print date('H', strtotime($node->field_date_interval['und'][0]['value'])); ?>%3A<?php print date('i', strtotime($node->field_date_interval['und'][0]['value'])); ?>%3A00%2B00%3A00<?php if(count($node->field_address)) print ('&location=' . $node->field_address['und'][0]['value']) ?>&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt=<?php print date('Y-m-d', $date1); ?>T<?php print date('H', strtotime($node->field_date_interval['und'][0]['value2'])); ?>%3A<?php print date('i', strtotime($node->field_date_interval['und'][0]['value2'])); ?>%3A00%2B00%3A00&subject=<?php print $title; ?>">Microsoft Outlook</a></li>
        <li><a class="office365" target="_blank" href="https://outlook.office.com/calendar/0/deeplink/compose?enddt=<?php print date('Y-m-d', $date2); ?>T<?php print date('H', strtotime($node->field_date_interval['und'][0]['value'])); ?>%3A<?php print date('i', strtotime($node->field_date_interval['und'][0]['value'])); ?>%3A00%2B00%3A00<?php if(count($node->field_address)) print ('&location=' . $node->field_address['und'][0]['value']) ?>&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt=<?php print date('Y-m-d', $date1); ?>T<?php print date('H', strtotime($node->field_date_interval['und'][0]['value2'])); ?>%3A<?php print date('i', strtotime($node->field_date_interval['und'][0]['value2'])); ?>%3A00%2B00%3A00&subject=<?php print $title; ?>">Office 365</a></li>
        <li><a class="yahoo" target="_blank" href="https://calendar.yahoo.com/?et=<?php print date('Ymd', $date2); ?>T<?php print date('Hi', strtotime($node->field_date_interval['und'][0]['value2'])); ?>00Z<?php if(count($node->field_address)) print ('&in_loc=' . $node->field_address['und'][0]['value']) ?>&st=<?php print date('Ymd', $date1); ?>T<?php print date('Hi', strtotime($node->field_date_interval['und'][0]['value'])); ?>00Z&title=<?php print $title; ?>&v=60">Yahoo Calendar</a></li>
      </ul>
    </div>

    
    <?php if(count($content['field_address'])): ?>
      <div class="geo">
        <i class="fas fa-map-marker-alt"></i>
        <div class="field-name-field-address">
          <a href="https://maps.google.com/?q=<?php print $node->field_address['und'][0]['value']; ?>" target="_blank">
            <?php print $node->field_address['und'][0]['value']; ?><?php if(count($content['field_address2'])) print (', ' . $node->field_address2['und'][0]['value']); ?>
          </a>
        </div>
      </div>
      <?php
        hide($content['field_address']);
        hide($content['field_address2']);
      ?>
    <?php endif; ?>
  <?php endif; ?>

  <?php
    // Hide comments, tags, and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_tags']);
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
</article>