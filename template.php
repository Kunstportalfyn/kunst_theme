<?php
require_once "mobile_detect.class.inc";
/* for awsome fonts on menus */
function kunst_theme_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  // Class attributes by menu_attributes
  if (isset($element['#localized_options']['attributes']['class'])) {
    $array_class = $element['#localized_options']['attributes']['class'];
    foreach ($array_class as $i => $class) {
      if (substr($class, 0, 5) == 'icon-') {
        // Don't put the class on the <a> tag!
        unset($element['#localized_options']['attributes']['class'][$i]);
        // It should go on a <i> tag (FontAwesome)!
        $icon = '<i class="' . $class . '"></i>';
      }
    }
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  if (!empty($icon)) {
    // Insert the icons (<i> tags) into the <a> tag.
    $output = substr_replace($output, $icon, strpos($output, '>') + 1, 0);
    $output = substr_replace($output, '<div class="inline-block">', strpos($output, '/i>') + 3, 0);
    $output = substr_replace($output, '</div>', strpos($output, '</a'), 0);
  }

  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
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
 * Implements hook_menu_alter().
 *
 * We want to change the menu-items titles on the login form.
 */
function kunst_theme_menu_alter(&$items) {
  $items['search/node/%']['title'] = 'Hjemmesiden';
}
/**
 * Override or insert variables into the page template.
 */
function kunst_theme_preprocess_page(&$vars) {
  $m = new Mobile_Detect();
  $vars['page']['mobile_detect']['is_mobile'] = $m->isMobile();
  $vars['page']['mobile_detect']['is_tablet'] = $m->isTablet();
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
  /**
   * Adds rss to page header
   */
  drupal_add_html_head_link(array(
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'title' => "RSS",
    'href' => "/rss.xml"
  ));
  
  if(!isset($_GET["m"])) {
    $_GET["m"] = 1;
  }

  $viewport = array(
    '#type' => 'html_tag',
    '#tag' => 'meta',
    '#attributes' => array(
      'name' =>  'viewport',
      'content' =>  'width=device-width, initial-scale=1, maximum-scale=10'
    )
  );

  if ($_GET["m"] == 1) {
    drupal_add_html_head($viewport, 'viewport');
  }
}

function kunst_theme_url_outbound_alter(&$path, &$options, $original_path) {
  if(!isset($options["query"]["m"]) && $options['external'] != TRUE) {
    if(!isset($options["query"])) {
      $options["query"] = array();
    }
    if(isset($_GET["m"])) {
      array_push($options["query"], array("m" => $_GET["m"]));
    }
    else {
      array_push($options["query"], array("m" => 1));
    }
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
  /**
   * @TODO Use date-formats defined in the backend, do not hardcode formats...
   *       ever
   */
  // Add updated to variables.
  $variables['kunst_theme_updated'] = t('Updated: !datetime', array('!datetime' => format_date($variables['node']->changed, 'custom', 'l j. F Y')));

  // Modified submitted variable
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('Submitted: !datetime', array('!datetime' => format_date($variables['created'], 'custom', 'l j. F Y')));
  }

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

function kunst_theme_url_add_mode($url, $mobile) {
  $pos = strpos($url, "?");
  if($pos !== FALSE) {
    $url = substr($url, 0 , $pos);
  }
  return $url . "?m=" . $mobile;
}