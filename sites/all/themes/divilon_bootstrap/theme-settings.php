<?php

  function divilon_bootstrap_form_system_theme_settings_alter(&$form, &$form_state) {
  $form['divilon_settings'] = array(
      '#type' => 'fieldset',
      '#title' => t('Social Links Settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    );
    // $form['divilon_settings']['instagram'] = array(
    //   '#type'  => 'textfield',
    //   '#title'  => 'Instagram',
    //   '#default_value' => theme_get_setting('instagram'),
    //   '#description'   => t('Place link to Your page or group in Social network.'),
    // );
    $form['divilon_settings']['twitter'] = array(
      '#type'  => 'textfield',
      '#title'  => 'Twitter',
      '#default_value' => theme_get_setting('twitter'),
      '#description'   => t('Place link to Your page or group in Social network.'),
    );
    $form['divilon_settings']['facebook'] = array(
      '#type'  => 'textfield',
      '#title'  => 'Facebook',
      '#default_value' => theme_get_setting('facebook'),
      '#description'   => t('Place link to Your page or group in Social network.'),
    );
    // $form['divilon_settings']['linkedin'] = array(
    //   '#type'  => 'textfield',
    //   '#title'  => 'LinkedIn',
    //   '#default_value' => theme_get_setting('linkedin'),
    //   '#description'   => t('Place link to Your page or group in Social network.'),
    // );
    $form['divilon_settings']['youtube'] = array(
      '#type'  => 'textfield',
      '#title'  => 'YouTube',
      '#default_value' => theme_get_setting('youtube'),
      '#description'   => t('Place link to Your page or group in Social network.'),
    );
    // $form['divilon_settings']['telegram'] = array(
    //   '#type'  => 'textfield',
    //   '#title'  => 'Telegram',
    //   '#default_value' => theme_get_setting('telegram'),
    //   '#description'   => t('Place link to Your page or group in Social network.'),
    // );
  }