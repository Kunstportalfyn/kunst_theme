<?php
/**
 * Implements hook_html_head_alter().
 * This will overwrite the default meta character type tag with HTML5 version.
 */
function kunst_theme_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8'
  );
}

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function kunst_theme_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Use CSS to hide titile .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
    // comment below line to hide current page to breadcrumb
$breadcrumb[] = drupal_get_title();
    $output .= '<nav class="breadcrumb">' . implode(' » ', $breadcrumb) . '</nav>';
    return $output;
  }
}

function kunst_theme_preprocess_html(&$vars) {
  // Add body classes for custom design options
  $colors = theme_get_setting('color_scheme', 'kunst_theme');
  $classes = explode(" ", $colors);
  for($i=0; $i<count($classes); $i++){
    $vars['classes_array'][] = $classes[$i];
  }
}

/**
 * Override or insert variables into the page template.
 */
function kunst_theme_preprocess_page(&$vars) {
  if (isset($vars['main_menu'])) {
    $vars['main_menu'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'main-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['main_menu'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_menu'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'secondary-menu', 'clearfix'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['secondary_menu'] = FALSE;
  }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function kunst_theme_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Override or insert variables into the node template.
 */
function kunst_theme_preprocess_node(&$variables) {
  $node = $variables['node'];
  if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
    $variables['classes_array'][] = 'node-full';
  }
  $variables['date'] = t('!datetime', array('!datetime' =>  date('l, j F Y', $variables['created'])));
  //added open graph meta tags for facebook.
  if(isset($node)){
    $site_name = variable_get('site_name');
    $og_title = $node->title . ($site_name ? ' | ' . $site_name : '');
    $og_description = isset($node->	field_lead[LANGUAGE_NONE][0]) ? drupal_substr(check_plain(strip_tags($node->field_lead[LANGUAGE_NONE][0]['safe_value'])), 0, 100) . '..' : '';
    $og_image = isset($node->field_image[LANGUAGE_NONE][0]) ? file_create_url($node->field_image[LANGUAGE_NONE][0]['uri'], array('absolute' => TRUE)) : '';
    drupal_add_html_head(array(
      '#tag' => 'meta',  
      '#attributes' => array(
        'property' => 'og:title',
        'content' => $og_title,
      ),
    ), 'node_' . $node->nid . '_og_title');
    drupal_add_html_head(array(
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:description',
        'content' => $og_description,
      ),
    ), 'node_' . $node->nid . '_og_description');
 
    drupal_add_html_head(array(
      '#tag' => 'meta',
      '#attributes' => array(
        'property' => 'og:image',
        'content' => $og_image,
      ),
    ), 'node_' . $node->nid . '_og_image');
}
}
function kunst_theme_page_alter($page) {
  // <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
  $viewport = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
    'name' =>  'viewport',
    'content' =>  'width=device-width, initial-scale=1, maximum-scale=1'
    )
  );
  drupal_add_html_head($viewport, 'viewport');
}

/**
 * Add css for color style.
 */
if (theme_get_setting('color_scheme', 'kunst_theme') == 'dark') {
  drupal_add_css(drupal_get_path('theme', 'kunst_theme') . '/css/color-schemes.css');
}

/**
 * Implements hook_form_alter
 *
 * @param array $form
 *   form obj
 * @param array $form_state
 *   form state obj
 * @param string $form_id
 *   form id
 */
function kunst_theme_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
    case 'user_login_block':
      $form['name']['#prefix'] = '<i class="icon-user"></i>';
      unset($form['name']['#title']);
      $form['name']['#attributes']['placeholder'] = t('Username');
      $form['pass']['#attributes']['placeholder'] = t('Password');
      $form['pass']['#prefix'] = '<i class="icon-lock"></i>';
      unset($form['pass']['#title']);
      $form['links']['#markup'] = "";
      $form['actions']['submit']['#attributes']['class'][] = 'btn';
      $form['actions']['submit']['#attributes']['class'][] = 'btn-info';
      break;
  }
}
