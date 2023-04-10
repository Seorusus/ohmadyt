<?php

function divilon_bootstrap_preprocess_page(&$vars) {
  // $vars['instagram'] = theme_get_setting('instagram');
  $vars['twitter'] = theme_get_setting('twitter');
  $vars['facebook'] = theme_get_setting('facebook');
  // $vars['linkedin'] = theme_get_setting('linkedin');
  $vars['youtube'] = theme_get_setting('youtube');
  // $vars['telegram'] = theme_get_setting('telegram');
  if(arg(0) == 'search' && arg(1) == 'node' && arg(2) != '') {
    header("Location: /find/" . arg(2)); 
  }
  if(arg(0) == 'taxonomy' && arg(1) == 'term' && arg(2) != '') {
    header("Location: /timeline?theme=" . arg(2)); 
  }
  
}

function divilon_bootstrap_form_alter(&$form, &$form_state, $form_id) {
  
  if($form_id == 'simplenews_block_form_1') {
    $form["mail"]["#title"] = '';//t('Your E-mail');
    $form["mail"]['#attributes']['placeholder'] = t('Enter your email');
  }

  if($form_id == 'search_block_form') {
    // $form['#action'] = 'find';
    // $form_state['rebuild'] = true;
    // $form['rebuild'] = true;
    // $form_state['redirect'] = url('find');
    // dpm($form);
    $form['search_block_form']['#attributes']['placeholder'] = '';
    $form['actions']['submit']['#attributes']['class'][0] = 'btn';
    $form['actions']['submit']["#value"] = t('<i class="fas fa-search"></i> Search');
  }

  if($form_id == 'views_exposed_form' && arg(0) == 'offense') {
    $form['field_date_iso_value']['min']['#attributes']['placeholder'] = $form['field_date_iso_value']['min']['#title'];
    $form['field_date_iso_value']['min']['#title'] = '';
    $form['field_date_iso_value']['max']['#attributes']['placeholder'] = $form['field_date_iso_value']['max']['#title'];
    $form['field_date_iso_value']['max']['#title'] = '';
  }
  
  if($form_id == 'views_exposed_form' && arg(0) == 'purification') {
    $form['date_filter']['value']['#attributes']['placeholder'] = t('from');
    $form['date_filter_1']['value']['#attributes']['placeholder'] = t('to');
  }

  if($form_id == 'views_exposed_form' && $form['#id'] == 'views-exposed-form-acts-page') {
    $form['date_from']['value']['#attributes']['placeholder'] = t('from');
    $form['date_to']['value']['#attributes']['placeholder'] = t('to');
    $form['title']['#attributes']['placeholder'] = t('Keyword in title');

    // $form['doctype']['#prefix'] = '<div class="flex-row">';
    // $form['doctype']['#suffix'] = '</div>';

    // dpm($form);
  }

  if ($form_id == 'views_exposed_form' && in_array($form['#id'], ['views-exposed-form-news-page-0'])) {
    $form['date_from']['value']['#attributes']['placeholder'] = $form['date_from']['value']['#title'];
    $form['date_to']['value']['#attributes']['placeholder'] = $form['date_to']['value']['#title'];
    $form['word']['#attributes']['placeholder'] = $form['#info']['filter-body_value']['label'];
    
    unset(
      $form['#info']['filter-body_value']['label'],
      $form['#info']['filter-date_filter']['label'],
      $form['#info']['filter-date_filter_1']['label']
    );
  }

  if ($form_id == 'views_exposed_form' && in_array($form['#id'], ['views-exposed-form-media-page-1', 'views-exposed-form-media-page-2'])) {
    $form['date']['value']['#attributes']['placeholder'] = $form['date']['value']['#title'];
    $form['title']['#attributes']['placeholder'] = $form['#info']['filter-title']['label'];
    
    unset(
      $form['#info']['filter-title']['label'],
      $form['#info']['filter-date_filter']['label']
    );
  }

  if ($form_id === "views_exposed_form" && $form['#id'] === 'views-exposed-form-news-page-2') {

    $form['date_from']['value']['#attributes']['placeholder'] = $form['date_from']['value']['#title'];
    $form['date_to']['value']['#attributes']['placeholder'] = $form['date_to']['value']['#title'];
    
    unset(
      $form['#info']['filter-type']['label'],
      $form['#info']['filter-tid_i18n']['label'],
      $form['#info']['filter-date_filter']['label'],
      $form['#info']['filter-date_filter_1']['label']
    );
    
    $form['theme']['#attributes']['placeholder'] = "!23";
  }
}

function divilon_bootstrap_menu_link__main_menu($variables) {
  $element = $variables['element'];
  $sub_menu = '';
  
  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    } elseif ((!empty($element['#original_link']['depth'])) && $element['#original_link']['depth'] > 1) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown-submenu';
      $element['#localized_options']['html'] = TRUE;
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      // $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    } else {
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function divilon_bootstrap_html_head_alter(&$head_elements) {
  // Remove Drupal generator meta tag.
  if (isset($head_elements['system_meta_generator'])) {
    unset($head_elements['system_meta_generator']);
  }
}


function divilon_bootstrap_breadcrumb(array $variables) {
  // Use the Path Breadcrumbs theme function if it should be used instead.
  if (_bootstrap_use_path_breadcrumbs()) {
    return path_breadcrumbs_breadcrumb($variables);
  }

  $output = '';
  $breadcrumb = $variables['breadcrumb'];
  $menu_breadcrumbs = menu_get_active_breadcrumb();

  $last_breadcrumb = $breadcrumb[count($breadcrumb) - 1];

  // menu breadcrums adding
  if(count($menu_breadcrumbs)) foreach ($menu_breadcrumbs as $c => $crumb) {
    $breadcrumb[$c] = $crumb;
  }
  if($breadcrumb[count($breadcrumb) - 1] != $last_breadcrumb) array_push($breadcrumb, $last_breadcrumb);

  // adding breadcrums for nodes not in menu
  if(arg(0) == 'node' && arg(1) != '') {
    $node = node_load(arg(1));
    // news nodes
    if($node->type == 'news' && count($breadcrumb == 2)) {
      $breadcrumb[1] = l(t('News'), 'news');
      array_push($breadcrumb, $last_breadcrumb);
    }
    // announces nodes
    if($node->type == 'announce' && count($breadcrumb == 2)) {
      $breadcrumb[1] = l(t('Announces'), 'announces');
      array_push($breadcrumb, $last_breadcrumb);
    }
    // interview nodes
    if($node->type == 'interview' && count($breadcrumb == 2)) {
      $breadcrumb[1] = l(t('Interview'), 'interview');
      array_push($breadcrumb, $last_breadcrumb);
    }
    // company nodes
    if($node->type == 'company' && count($breadcrumb == 2)) {
      $breadcrumb[1] = l(t('Info companies'), 'infocompany');
      array_push($breadcrumb, $last_breadcrumb);
    }
    // vacancy nodes
    if($node->type == 'vacancy' && count($breadcrumb == 2)) {
      $breadcrumb[1] = l(t('Vacancies'), 'vacancy');
      array_push($breadcrumb, $last_breadcrumb);
    }
  }

  // Determine if we are to display the breadcrumb.
  $bootstrap_breadcrumb = bootstrap_setting('breadcrumb');
  if (($bootstrap_breadcrumb == 1 || ($bootstrap_breadcrumb == 2 && arg(0) == 'admin')) && !empty($breadcrumb)) {
    $build = array(
      '#theme' => 'item_list__breadcrumb',
      '#attributes' => array(
        'class' => array('breadcrumb'),
      ),
      '#items' => $breadcrumb,
      '#type' => 'ul',
    );
    $output = drupal_render($build);
  }
  return $output;
}


function divilon_bootstrap_preprocess_node(&$variables) {
  if ($variables['submitted']) {
    $variables['submitted'] = t('Submitted on !datetime', array('!datetime' => $variables['date']));
  }
}