<?php

/**
 * @file
 * divilon_tmap.field_group.inc
 */

/**
 * Implements hook_field_group_info().
 */
function divilon_tmap_field_group_info() {
  $field_groups = array();

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_atr|node|tempmap|form';
  $field_group->group_name = 'group_atr';
  $field_group->entity_type = 'node';
  $field_group->bundle = 'tempmap';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'АТР',
    'weight' => '11',
    'children' => array(
      0 => 'field_cr',
      1 => 'field_vn',
      2 => 'field_vl',
      3 => 'field_dp',
      4 => 'field_dn',
      5 => 'field_jt',
      6 => 'field_zak',
      7 => 'field_zap',
      8 => 'field_if',
      9 => 'field_kyivsk',
      10 => 'field_kv',
      11 => 'field_lg',
      12 => 'field_lv',
      13 => 'field_myk',
      14 => 'field_od',
      15 => 'field_pt',
      16 => 'field_rv',
      17 => 'field_sm',
      18 => 'field_tn',
      19 => 'field_kh',
      20 => 'field_khr',
      21 => 'field_khm',
      22 => 'field_chr',
      23 => 'field_chn',
      24 => 'field_chng',
      25 => 'field_kyiv',
      26 => 'field_sv',
    ),
    'format_type' => 'tab',
    'format_settings' => array(
      'formatter' => 'closed',
      'instance_settings' => array(
        'description' => '',
        'classes' => '',
        'required_fields' => 1,
      ),
    ),
  );
  $field_groups['group_atr|node|tempmap|form'] = $field_group;

  // Translatables
  // Included for use with string extractors like potx.
  t('АТР');

  return $field_groups;
}
