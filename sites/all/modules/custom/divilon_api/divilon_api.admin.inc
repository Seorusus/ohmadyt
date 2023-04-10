<?php

// API URL
define('CAREER_URL', 'https://career.gov.ua/api/vacantions/all?');
// Items count for one cron iteration
define('VACANCY_PAGE_SIZE', 1000);
// ID for vacancy filtering
define('ORG_ID', '22157');

/**
 * @file
 * Used to settings forms.
 */

/**
 * Implements divilon_api_main().
 */
function divilon_api_main($form, $form_state) {

  $form['apikey'] = [
    '#title' => t('Opendata API Key'),
    '#type' => 'textfield',
    '#default_value' => variable_get('apikey', '')
  ];

  $form['apiurl'] = [
    '#title' => t('Opendata API URL'),
    '#type' => 'textfield',
    '#default_value' => variable_get('apiurl', '')
  ];

  foreach([ 'reestr', 'vidstoronennya', 'info', 'perelik' ] as $node_type) {
    $type = "reestr_" . $node_type;
    $form[$type] = [
      '#title' => "ID for " . $node_type,
      '#type' => 'textfield',
      '#default_value' => variable_get($type, '')
    ];
  }
  
  return system_settings_form($form);
}


function divilon_api_opendata() {
  $items = [];
  foreach([ 'reestr', 'vidstoronennya', 'info', 'perelik' ] as $type) {
    $nodetype = node_type_get_type($type);
    $items[] = l( $nodetype->name, 'admin/opendata/' . $type );
  }

  return theme('item_list', ['items' => $items, 'title' => t('Select set to publish')]);
}

function divilon_api_opendata_publish($type) {

  $views = array(
    "vidstoronennya" => "release",
    "info" => "disciplinary",
    "reestr" => "intervention",
    "perelik" => "offense"
  );
  if ($views[$type]) {
    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=> false,
            "verify_peer_name"=> false,
        ),
    );
//     var_dump($arrContextOptions); exit;
    $result = file_get_contents( url($views[$type] . '/json', ['absolute' => true] ), false, stream_context_create($arrContextOptions));
    if ($json = json_decode($result)) {
      $file = 'public://opendata/' . $views[$type] . '.json';
      if ($json->nodes && count($json->nodes)) {
        $data = [];
        foreach($json->nodes as $node) {
          $data[] = (array) $node->node;
        }
        $fileObj = file_save_data(json_encode($data, JSON_UNESCAPED_UNICODE), $file, FILE_EXISTS_REPLACE);
        // var_dump($fileObj); exit;
        // $postfields = array(
        //   'upload' => '@' . drupal_realpath($fileObj->uri),// . ';type=application/json',
        //   'id' => variable_get('reestr_' . $type, '')
        // );

        // $command = 'curl -X POST https://data.gov.ua/api/3/action/resource_update -H "Authorization:
        // ' . variable_get('apikey', '') . '" -F "id=' . variable_get('reestr_' . $type, '') . '" -F "upload=@' . drupal_realpath($fileObj->uri) . '"';


        $command = "curl -H 'Authorization: " . variable_get('apikey', '') . "' 'https://data.gov.ua/api/3/action/resource_create' --form name=" . $type . " --form package_id=" . variable_get('reestr_' . $type, '') . " --form upload=@" . drupal_realpath($fileObj->uri);

        // dpm($command);
        $result = exec($command, $output, $r);
        dpm($output);
        dpm($r);
        return 'processed';
        

        $postfields = array(
          'name' => $views[$type],
          'package_id' => variable_get('reestr_' . $type, ''),
          'upload' => '@' . file_create_url($fileObj->uri) . ';type=application/json',
          'format' => 'JSON'
        );
        // dpm(variable_get('apiurl', '111'));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, variable_get('apiurl', ''));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . variable_get('apikey', ''),
            'Content-Type: multipart/form-data',
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        // curl_setopt($ch, CURLOPT_UPLOAD, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);

        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        $server_output = curl_exec($ch);
        // dpm($server_output);

        if ($server_output === FALSE || true) {
          printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
                 htmlspecialchars(curl_error($ch)));
          // exit();
        }
      
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
      
        // dpm($verboseLog);
        // dpm($server_output);
        curl_close ($ch);
        return 'processed';
      }
    }
  }
  return t('No data');
  
  // var_dump( views_get_view_result($views[$type], 'json') ); exit;


  if ($view = views_get_view($views[$type])) {

    $view->execute();
  var_dump($view->result); exit;

    $result = file_get_contents();
return '1231231';
    if ($result && $result->nodes) {
      foreach($result->nodes as $row) {
        dpm($row);
        return '123123';
  
      }
    }
    // http://vrp.div.co.ua/admin/opendata/reestr
    // $json =  $view->render('json');
  }

  return  $type;
}

// Publish vacancies from career.gov.ua
function divilon_api_vacancy() {
  return divilon_api_vacancy_fetch_next_page();
}

function divilon_api_vacancy_fetch_next_page($status = 3) {

  $param = [
    'id'      => variable_get('vacancy_last_id', 0),
    'limit'   => VACANCY_PAGE_SIZE,
    'status'  => $status,
  ];

  try {
    
    $c = curl_init(CAREER_URL . http_build_query($param));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    $all = json_decode(curl_exec($c));
    curl_close($c);

    // Filter MINRE vacancies
    $vacancies = array_filter($all, function ($item) {
      return $item->agency->id == ORG_ID; 
    });

    if ($vacancies && count($vacancies)) {
      foreach($vacancies as $item) {
        _save_new_vacancy($item);
      }
      watchdog(
        'vacancy_updater',
        'Added %count vacancies, last id = %id', 
        [
          '%count' => count($vacancies),
          '%id' => $param['id']
        ], WATCHDOG_INFO
      );
    }

    if ($all && count($all)) {
      if (!$vacancies || count($vacancies) === 0) {
        watchdog(
          'vacancy_updater',
          'No vacancies in page from id = %id and size = %size', 
          [
            '%size' => VACANCY_PAGE_SIZE,
            '%id' => $param['id']
          ], WATCHDOG_INFO
        );
      }
      variable_set('vacancy_last_id', $all[ count($all) - 1 ]->id + 1);
    } else {
      watchdog('vacancy_updater', "No vacancies after id = %id", ['%id' => $param['id']], WATCHDOG_INFO);
    }
  
  } catch (Exception $e) {
    watchdog_exception('vacancy_updater', $e);
  }

  return '$query';
}

function _save_new_vacancy($item) {

  $node = new stdClass();

  $node->title = $item->name;
  $node->type = "vacancy";

  node_object_prepare($node); 
  $node->language = 'uk'; 
  $node->status = 1; 

  $fieldMap = [
    'field_vacancy_id'                  => 'id',
    'field_vacancy_code'                => 'code',
    'field_vacancy_adress'              => 'adress',
    'field_vacancy_responsibilities'    => 'responsibilities',
    'field_vacancy_salary_min'          => 'salary_min',
    'field_vacancy_salary_max'          => 'salary_max',
    'field_vacancy_wage_conditions'     => 'wage_conditions',
    'field_vacancy_term_of_appointmen'  => 'term_of_appointment',
    'field_vacancy_start_date'          => 'start_date',
    'field_vacancy_end_date'            => 'end_date',
    'field_vacancy_competition_date'    => 'competition_date',
    'field_vacancy_contact_lname'       => 'contact_lname',
    'field_vacancy_contact_name'        => 'contact_name',
    'field_vacancy_contact_midname'     => 'contact_midname',
    'field_vacancy_contact_phone'       => 'contact_phone',
    'field_vacancy_contact_email'       => 'contact_email',
    'field_vacancy_general_competenci'  => 'general_competencies',
    'field_vacancy_special_competenci'  => 'special_competencies',
    'field_vacancy_date'                => 'date',
    'field_vacancy_created_at'          => 'created_at',
    'field_vacancy_updated_at'          => 'updated_at',
    'field_vacancy_cancel_reason'       => 'cancel_reason',
  ];

  $node->field_vacancy_status[LANGUAGE_NONE][]['value'] = $item->status->id;
  $node->field_vacantion_category[LANGUAGE_NONE][]['value'] = $item->vacantion_category->id;

  foreach($fieldMap as $dest => $source) {
    if (in_array($dest, ['field_vacancy_start_date', 'field_vacancy_end_date', 'field_vacancy_created_at', 'field_vacancy_updated_at'])) {
      $node->{$dest}[LANGUAGE_NONE][] = [
        'value' => substr(date('c', strtotime($item->{$source})), 0, 19),
      ];
    } else {
      $node->{$dest}[LANGUAGE_NONE][]['value'] = $item->{$source};
    }
    // $node->{$dest}[LANGUAGE_NONE][]['value'] = $item->{$source};
  }
  $node = node_submit($node);

  node_save($node);
}
