<?php

namespace Drupal\ohmatdyt_import\Plugin\migrate\process;

use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;

/**
 * Custom process plugin to modify mi_data_id field.
 *
 * @MigrateProcessPlugin(
 *   id = "custom_mi_data_id"
 * )
 */
class CustomMiDataId extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $newValue = substr($value, -7);

      return $newValue;
  }

}
