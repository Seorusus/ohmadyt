<?php

/**
 * @file
 * divilon_tmap.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function divilon_tmap_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "field_group" && $api == "field_group") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_eck_bundle_info().
 */
function divilon_tmap_eck_bundle_info() {
  $items = array(
    'maps_legend' => array(
      'machine_name' => 'maps_legend',
      'entity_type' => 'maps',
      'name' => 'legend',
      'label' => 'Легенда',
      'config' => array(),
    ),
  );
  return $items;
}

/**
 * Implements hook_eck_entity_type_info().
 */
function divilon_tmap_eck_entity_type_info() {
  $items = array(
    'maps' => array(
      'name' => 'maps',
      'label' => 'Мапи',
      'properties' => array(
        'uid' => array(
          'label' => 'Author',
          'type' => 'integer',
          'behavior' => 'author',
        ),
        'created' => array(
          'label' => 'Created',
          'type' => 'integer',
          'behavior' => 'created',
        ),
      ),
    ),
  );
  return $items;
}

/**
 * Implements hook_node_info().
 */
function divilon_tmap_node_info() {
  $items = array(
    'tempmap' => array(
      'name' => t('Температурна мапа'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Назва параметру'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
