<?php
/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function kunst_theme_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['kunst_theme_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Kunst theme Settings'),
    '#collapsible' => FALSE,
    '#collapsed' => FALSE,
  );
  $form['kunst_theme_settings']['color'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Color Scheme'),
    '#weight' => -2,
    '#description'   => t("Select a predesigned color scheme for the site."),
  );

  $form['kunst_theme_settings']['color']['color_scheme'] = array(
    '#type'          => 'select',
    '#title'         => t('Color Scheme'),
    '#default_value' => theme_get_setting('color_scheme', 'kunst_theme'),
    '#description'   => t('Select a predesigned color scheme.'),
    '#options'       => array(
      'white' => t('White'),
      'dark' => t('Dark'),
     ),
  );
  $form['kunst_theme_settings']['image_logo'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show <strong>Image Logo</strong> instead of text logo in a page'),
    '#default_value' => theme_get_setting('image_logo','kunst_theme'),
    '#description'   => t("Check this option to show Image Logo in page. Uncheck to show the text logo."),
  );
  $form['kunst_theme_settings']['breadcrumbs'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show breadcrumbs in a page'),
    '#default_value' => theme_get_setting('breadcrumbs','kunst_theme'),
    '#description'   => t("Check this option to show breadcrumbs in page. Uncheck to hide."),
  );

  $form['kunst_theme_settings']['socialicon'] = array(
    '#type' => 'fieldset',
    '#title' => t('Social Icon'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );
  $form['kunst_theme_settings']['socialicon']['socialicon_display'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show Social Icon'),
    '#default_value' => theme_get_setting('socialicon_display','kunst_theme'),
    '#description'   => t("Check this option to show Social Icon. Uncheck to hide."),
  );
  $form['kunst_theme_settings']['socialicon']['twitter_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Twitter Profile URL'),
    '#default_value' => theme_get_setting('twitter_url', 'kunst_theme'),
    '#description'   => t("Enter your Twitter Profile URL. Leave blank to hide."),
  );
  $form['kunst_theme_settings']['socialicon']['facebook_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Facebook Profile URL'),
    '#default_value' => theme_get_setting('facebook_url', 'kunst_theme'),
    '#description'   => t("Enter your Facebook Profile URL. Leave blank to hide."),
  );
  $form['kunst_theme_settings']['socialicon']['pinterest_url'] = array(
    '#type' => 'textfield',
    '#title' => t('Pinterest Address'),
    '#default_value' => theme_get_setting('pinterest_url', 'kunst_theme'),
    '#description'   => t("Enter your Pinterest URL. Leave blank to hide."),
  );
}
