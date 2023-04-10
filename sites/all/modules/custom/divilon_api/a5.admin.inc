<?php

function normaliseJson($json, $fields_to_use = false) {

    $fields     = $json->fields;
    $raw_data   = $json->data;

    if (!$fields_to_use) {
        $fields_to_use = $fields;
    }

    $data = [];

    foreach($raw_data as $row) {
        $full_row = array_combine($fields, $row);
        // var_dump(array_intersect_key($full_row, array_flip($fields_to_use)));exit;
        $data[] = array_intersect_key($full_row, array_flip($fields_to_use));
    }

    return $data;
}

function normaliseDict($json, $fields_to_use = ["ID", "name"]) {

    $data = [];

    foreach($json as $row) {
        $data[$row[$fields_to_use[0]]] = $row[$fields_to_use[1]];
    }

    return $data;
}

function createOrFindNode($internalId) {
    global $user;
    global $language;

    $node = false;
    $query = new EntityFieldQuery();

    $query->entityCondition("entity_type", "node")
        ->entityCondition("bundle", "person")
        ->fieldCondition("field_origin_id", "value", $internalId, "=")
        ->range(0, 1)
        ->addMetaData("account", user_load(1));

    $result = $query->execute();

    if (isset($result['node'])) {
        $nids = array_keys($result['node']);
        $node = node_load($nids[0]);
    }

    if (!$node) {
        $node = new stdClass();
        
        $node->type = "person";
        $node->language = $language->language;
        node_object_prepare($node);
        $node->uid = $user->uid;
    }

    return $node;

}

function a5_prepare_import() {
    $fields_to_use = [
        "mi_data_id",
    
        "employee_LastName",
        "employee_FirstName",
        "employee_MiddleName",
    
        "employee_Photo",
    
        "department_Name",
        "position_Name",
        
        "employee_PhoneMobile",
        "employee_PhoneWorking",
    
        "employee_Email",
    
        "employee_EducationLevel",
        "employee_rangeScience",
        "employee_Rank", //"position_Category",
        "employee_Experience",
    
    ];

    $json = json_decode( file_get_contents(__DIR__ . "/a5/public.json") );
    $public = normaliseJson($json, $fields_to_use);
    
    $public = array_slice($public, 4673);
    // var_dump($public); exit;
    
    $json = json_decode( file_get_contents(__DIR__ . "/a5/hr_dictEducationLevel.json") );
    $employee_EducationLevel = normaliseDict(normaliseJson($json));
    
    $json = json_decode( file_get_contents(__DIR__ . "/a5/hr_dictRank.json") );
    $employee_Rank = normaliseDict(normaliseJson($json));
    
    $json = json_decode( file_get_contents("./a5/hr_dictDegree.json") );
    $employee_rangeScience = normaliseDict(normaliseJson($json));
    
    $dictFields = ["employee_EducationLevel", "employee_Rank", "employee_rangeScience"];
    
    $output = [];

    foreach($public as &$row) {
        foreach($dictFields as $field) {
            $row[$field] = ${$field}[$row[$field]];
        }

        $output[] = [
            "id"                => $row["INTERNAL_ID"],
            "title"             => implode(" ",  array_filter([$row["employee_LastName"], $row["employee_FirstName"], $row["employee_MiddleName"]])),
            "field_department"  => $row["department_Name"],
            "field_lead"        => $row["position_Name"],
            "field_phone"       => implode(", ",  array_filter(array_intersect_key($row, array_flip(["employee_PhoneMobile", "employee_PhoneWorking",]))) ),
            "field_email"       => $row["employee_Email"],
            "field_education"   => $row["employee_EducationLevel"],
            "field_degree"      => $row["employee_Rank"],
            "field_rank"        => $row["employee_rangeScience"],
        ];
    }
    
    return $output;
}

function a5_batch_form($form, $form_state) {

    $form['json'] = array(
        '#title' => 'Personal list',
        '#type' => 'file',
    );

    $form['submit'] = [
        '#value' => t('Start import'),
        '#type' => 'submit',
      ];
    // $form["text"]['#markup'] = "Custom batch process to update nodes.... ";
    return $form;
}

function a5_batch_form_submit($form, $form_state) {
    $filepath = 'public://a5/';
    $filename = 'public.json';
    file_prepare_directory($filepath, FILE_CREATE_DIRECTORY);
    $file = file_save_upload('json', array('file_validate_extensions' => array('json')));
    dpm($file);
    return;
    batch_set(a5_get_items());
}

function a5_get_items() {
    drupal_set_message('Updating Personal');
    
    $items = a5_prepare_import();
    $operations = [];
    
    foreach($items as $item) {
      $operations[] = array('a5_update_person', [$item]);
    }

    $batch = array(
      'operations' => $operations,
      'finished' => 'a5_import_finished',
    );

    return $batch;
}

function a5_update_person($item, &$context) {
    $context['results'][] = $item["title"];
    dpm($item);

    $context['message'] = t('Processing "@title"', ['@title' => $item["title"]]);
    
    $node = createOrFindNode($item["id"]);

    $node->title = $item["title"];

    foreach($item as $key => $value) {
        if (strpos($key, "field_") === 0) {
            $node->${$key}[LANGUAGE_NONE][0]["value"] = $value;
        }
    }

    $node = node_submit($node); 
    node_save($node);
    drupal_set_message($node->title . " updated.");
}

function a5_import_finished($success, $results, $operations) {
    if ($success) {
      drupal_set_message(t('@count persons processed.', array('@count' => count($results))));
    } else {
      $error_operation = reset($operations);
      drupal_set_message(t('An error occurred while processing @operation with arguments : @args', array('@operation' => $error_operation[0], '@args' => print_r($error_operation[0], TRUE))));
    }
}
