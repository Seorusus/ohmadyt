<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all environments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to ensure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * Skipping permissions hardening will make scaffolding
 * work better, but will also raise a warning when you
 * install Drupal.
 *
 * https://www.drupal.org/project/drupal/issues/3091285
 */
// $settings['skip_permissions_hardening'] = TRUE;

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}

if (defined('PANTHEON_ENVIRONMENT')) {
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'dev') {
    $config['environment_indicator.indicator']['bg_color'] = '#5d2888';
    $config['environment_indicator.indicator']['fg_color'] = '#ffffff';
    $config['environment_indicator.indicator']['name'] = 'Pantheon Dev';
  }
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'test') {
    $config['environment_indicator.indicator']['bg_color'] = '#fffe00';
    $config['environment_indicator.indicator']['fg_color'] = '#320000';
    $config['environment_indicator.indicator']['name'] = 'Pantheon Test';

  }
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
    $config['environment_indicator.indicator']['bg_color'] = '#f70b0b';
    $config['environment_indicator.indicator']['fg_color'] = '#ffffff';
    $config['environment_indicator.indicator']['name'] = 'Pantheon Production';
  }
}