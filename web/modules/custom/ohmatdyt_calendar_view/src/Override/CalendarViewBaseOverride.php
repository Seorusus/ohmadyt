<?php

/**
 * @file
 * Contains CalendarViewBaseOverride.
 */

namespace Drupal\ohmatdyt_calendar_view\Override;

use Drupal\calendar_view\Plugin\views\style\CalendarViewBase;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\views\Plugin\views\field\EntityField;
use Drupal\views\ResultRow;

abstract class CalendarViewBaseOverride extends CalendarViewBase {

  /**
   * Get the value out of a view Result for a given date field.
   *
   * @param \Drupal\views\ResultRow $result
   *   A given view result.
   * @param \Drupal\views\Plugin\views\field\EntityField $field
   *   A given date field.
   *
   * @return array
   *   Either the timestamp or nothing.
   */
  public function getRowValues(ResultRow $row, EntityField $field) {
    $delta = 0;
    if ($delta_field = $field->aliases['delta'] ?? NULL) {
      $delta = $row->{$delta_field} ?? 0;
    }

    // Get the result we need from the entity.
    $this->view->row_index = $row->index ?? 0;
    $items = $field->getItems($row) ?? [];
    $item = $items[$delta]['raw'] ?? $items[0]['raw'] ?? NULL;
    $values = $item instanceof FieldItemInterface ? $item->getValue() : [];
    unset($this->view->row_index);

    // Skip empty fields.
    if (empty($values) || empty($values['value'])) {
      return [];
    }

    // Make sure values are timestamps.
    $values['value'] = $this->ensureTimestampValue($values['value']);
    $values['end_value'] = $this->ensureTimestampValue($values['end_value'] ?? $values['value']);

    // Get first item value to reorder multiday events in cells.
    $all_values = $field->getValue($row);
    $all_values = \is_array($all_values) ? $all_values : [$all_values];
    $values['first_instance'] = reset($all_values);

    // Expose the date field if other modules need it in preprocess.
    $config = $field->configuration ?? [];
    $field_id = $config['field_name'] ?? $config['entity field'] ?? $config['id'] ?? NULL;
    $values['field'] = $field_id;

    // Get a unique identifier for this event.
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $field->getEntity($row);
    $key = $entity->getEntityTypeId() . ':' . $entity->id() . ':' . $field_id;
    $values['hash'] = md5($key . $delta);

    // Prepare a title by default (e.g. on hover).
    $start = $values['value'];
    $end = $values['end_value'] ?? $start;
    $title_string = $start && ($start !== $end) ? '@title с @start до @end' : '@field: @title @date';
    $values['title'] = $this->t($title_string, [
      '@field' => $field->label(),
      '@title' => $entity->label(),
      '@date' => $this->dateFormatter->format($start, 'long'),
      '@start' => $this->dateFormatter->format($start, 'short'),
      '@end' => $this->dateFormatter->format($end, 'short'),
    ]);

    return $values;
  }

}