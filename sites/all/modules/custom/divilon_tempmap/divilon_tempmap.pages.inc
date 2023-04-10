<?php 

function divilon_tempmap_show() {
    $items = _get_map_items();
    if (!$items) return t('No items on map');
    $svg = file_get_contents( drupal_get_path('module', 'divilon_tempmap') . '/ukraine.svg' );
    drupal_add_js(drupal_get_path('module', 'divilon_tempmap') . '/html2canvas.min.js');
    $output = array();
    foreach($items as $item) {
        $values = array();
        $legend = array();
        $wrapper = entity_metadata_wrapper('node', $item->nid);
        foreach($wrapper->getPropertyInfo() as $key => $field) {
            if (strpos($key, 'field_') === 0 && $field['type'] === 'decimal' && strlen($wrapper->{$key}->value()) > 0) {
                $values[$key] = array(
                    'label' => $field['label'],
                    'value' => number_format( $wrapper->{$key}->value(), 1, '.', '' )
                );
            }
        }
        uasort($values, function($a, $b){
            return strcmp_ukr($a['label'], $b['label']);
        });
        foreach($wrapper->field_legend as $legend_item) {
            $legend[$legend_item->getIdentifier()] = array(
                'color' => $legend_item->field_color->value()['rgb'],
                'from' => number_format($legend_item->field_fr->value(), 1, '.', ''),
                'to' => number_format($legend_item->field_to->value(), 1, '.', '')
            );
        }
        $output[$item->nid] = array(
            'created' => (int)$wrapper->created->value(),
            'label' => $wrapper->title->value(),
            'values' => $values,
            'legend' => $legend,
            'units' => $wrapper->field_unit->value(),
            'int' => $wrapper->field_int->value(),
            'body' => $wrapper->body->value()['value']
        );
    }
    drupal_add_js(array('temperature' => $output), 'setting');
    drupal_add_js(drupal_get_path('module', 'divilon_tempmap') . '/divilon_tempmap.js');

    return theme('temperature_map', array('items' => $output, 'svg' => $svg));
}
function _get_map_items() {
    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'node')
        ->propertyOrderBy('created', 'DESC')
        ->entityCondition('bundle', 'tempmap');
    if (!user_access('create tempmap content')) {
        $query->propertyCondition('status', NODE_PUBLISHED);
    }

    $result = $query->execute();
    return (isset($result['node'])) ? $result['node'] : false;
}

function strcmp_ukr($v1, $v2)
{
    if (is_array($v1) AND is_array($v2))
    {
        $v1 = reset($v1);
        $v2 = reset($v2);
    }
    $v1 = mb_string_to_array($v1);
    $v2 = mb_string_to_array($v2);      
    
    $abc = array('А','Б','В','Г','Ґ','Д','Е','Є','Ж','З','И','І','Ї','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ь','Ю','Я',
                 'а','б','в','г','ґ','д','е','є','ж','з','и','і','ї','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ю','я'); 
    
    $len = min(count($v1), count($v2));
    
    for ($i = 0; $i < $len; $i++)
    {
        $abc_len = $s1 = $s2 = count($abc);                
        for ($j = 0; $j < $abc_len; $j++) if ($v1[$i] == $abc[$j]) $s1 = $j;
        for ($k = 0; $k < $abc_len; $k++) if ($v2[$i] == $abc[$k]) $s2 = $k;
        if ($s1 < $s2) return -1;
        else if ($s1 > $s2) return 1;    
    }
    return 0;
}

function mb_string_to_array($string) 
{ 
    $strlen = mb_strlen($string); 
    while ($strlen) 
    { 
        $array[] = mb_substr($string, 0, 1, 'UTF-8'); 
        $string = mb_substr($string, 1, $strlen, 'UTF-8'); 
        $strlen = mb_strlen($string); 
    } 
    return $array; 
}
