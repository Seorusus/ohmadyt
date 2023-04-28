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

/*
* Environment Indicator module settings.
* see: https://docs.pantheon.io/guides/environment-configuration/environment-indicator
*/

$conf['environment_indicator_overwrite'] = true;
$conf['environment_indicator_overwritten_position'] = 'top';
$conf['environment_indicator_overwritten_fixed'] = false;

if (!defined('PANTHEON_ENVIRONMENT')) {
  $conf['environment_indicator_overwritten_name'] = 'Local';
  $conf['environment_indicator_overwritten_color'] = '#505050';
  $conf['environment_indicator_overwritten_text_color'] = '#ffffff';
}
// Pantheon Env Specific Config
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  switch ($_ENV['PANTHEON_ENVIRONMENT']) {
    case 'local': // Localdev or Lando environments
      $config['environment_indicator.indicator']['name'] = 'Local Dev';
      $config['environment_indicator.indicator']['bg_color'] = '#990055';
      $config['environment_indicator.indicator']['fg_color'] = '#ffffff';
      break;
    case 'dev':
      $conf['environment_indicator_overwritten_name'] = 'Dev';
      $conf['environment_indicator_overwritten_color'] = '#307b24';
      $conf['environment_indicator_overwritten_text_color'] = '#ffffff';
      break;
    case 'test':
      $conf['environment_indicator_overwritten_name'] = 'Test';
      $conf['environment_indicator_overwritten_color'] = '#b85c00';
      $conf['environment_indicator_overwritten_text_color'] = '#ffffff';
      break;
    case 'live':
      $conf['environment_indicator_overwritten_name'] = 'Live!';
      $conf['environment_indicator_overwritten_color'] = '#e7131a';
      $conf['environment_indicator_overwritten_text_color'] = '#ffffff';
      break;
    default:
      //Multidev catchall
      $conf['environment_indicator_overwritten_name'] = 'Multidev';
      $conf['environment_indicator_overwritten_color'] = '#e7131a';
      $conf['environment_indicator_overwritten_text_color'] = '#000000';
      break;
  }
}