<?php
// $Id: template.php,v 1.45 2010/12/01 00:18:15 webchick Exp $

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function rraister_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $output .= '<div class="breadcrumb">' . implode(' › ', $breadcrumb) . '</div>';
    return $output;
  }
}

/**
 * Override or insert variables into the maintenance page template.
 */
function rraister_preprocess_maintenance_page(&$vars) {
  // While markup for normal pages is split into page.tpl.php and html.tpl.php,
  // the markup for the maintenance page is all in the single
  // maintenance-page.tpl.php template. So, to have what's done in
  // garland_preprocess_html() also happen on the maintenance page, it has to be
  // called here.
  rraister_preprocess_html($vars);
}

/**
 * Override or insert variables into the html template.
 */
function rraister_preprocess_html(&$vars) {

}

/**
 * Override or insert variables into the html template.
 */
function rraister_process_html(&$vars) {

}

/**
 * Override or insert variables into the page template.
 */
function rraister_preprocess_page(&$vars) {
  $vars['title_prefix']['rraister'] = array();
  $vars['title_prefix']['rraister']['#markup'] = '';
  foreach($vars['page']['sidebar_first']['system_main-menu'] as $key => $value ){
    if( is_numeric($key) and !empty($value['#below'])  ){
      drupal_set_title('<span class="sub">'.drupal_get_title().'</span>',PASS_THROUGH);
      $vars['title_prefix']['rraister']['#markup'].='<div class="rraister-submenu">';
      $vars['title_prefix']['rraister']['#markup'].='<h1>'.$value['#title'].'</h1>';
      $vars['title_prefix']['rraister']['#markup'].='<ul class="menu">';
      foreach($value['#below'] as $key2 => $value2 ){
        if( is_numeric($key2) ){
          $vars['title_prefix']['rraister']['#markup'].='<li class="'.implode(' ',$value2['#attributes']['class']).'"><a href="'.url($value2['#href']).'" class="'.($value2['#original_link']['in_active_trail'] ? 'active' : '').'">'.$value2['#title'].'</a></li>';
        }
      }
      $vars['title_prefix']['rraister']['#markup'].='</ul>';
      $vars['title_prefix']['rraister']['#markup'].='</div>';
    }
  }
  
  // Move secondary tabs into a separate variable.
  $vars['tabs2'] = array(
    '#theme' => 'menu_local_tasks',
    '#secondary' => $vars['tabs']['#secondary'],
  );
  unset($vars['tabs']['#secondary']);

  if (isset($vars['main_menu'])) {
    $vars['primary_nav'] = theme('links__system_main_menu', array(
      'links' => $vars['main_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'main-menu'),
      ),
      'heading' => array(
        'text' => t('Main menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['primary_nav'] = FALSE;
  }
  if (isset($vars['secondary_menu'])) {
    $vars['secondary_nav'] = theme('links__system_secondary_menu', array(
      'links' => $vars['secondary_menu'],
      'attributes' => array(
        'class' => array('links', 'inline', 'secondary-menu'),
      ),
      'heading' => array(
        'text' => t('Secondary menu'),
        'level' => 'h2',
        'class' => array('element-invisible'),
      )
    ));
  }
  else {
    $vars['secondary_nav'] = FALSE;
  }

  // Prepare header.
  $site_fields = array();
  if (!empty($vars['site_name'])) {
    $site_fields[] = $vars['site_name'];
  }
  if (!empty($vars['site_slogan'])) {
    $site_fields[] = $vars['site_slogan'];
  }
  $vars['site_title'] = implode(' ', $site_fields);
  if (!empty($site_fields)) {
    $site_fields[0] = '<span>' . $site_fields[0] . '</span>';
  }
  $vars['site_html'] = implode(' ', $site_fields);

  // Set a variable for the site name title and logo alt attributes text.
  $slogan_text = $vars['site_slogan'];
  $site_name_text = $vars['site_name'];
  $vars['site_name_and_slogan'] = $site_name_text . ' ' . $slogan_text;
}

/**
 * Override or insert variables into the node template.
 */
function rraister_preprocess_node(&$vars) {
  $vars['submitted'] = $vars['date'];
}

/**
 * Override or insert variables into the comment template.
 */
function rraister_preprocess_comment(&$vars) {
  $vars['submitted'] = $vars['created'] . ' — ' . $vars['author'];
}

/**
 * Override or insert variables into the block template.
 */
function rraister_preprocess_block(&$vars) {
}

/**
 * Override or insert variables into the page template.
 */
function rraister_process_page(&$vars) {
}

/**
 * Override or insert variables into the region template.
 */
function rraister_preprocess_region(&$vars) {

}



