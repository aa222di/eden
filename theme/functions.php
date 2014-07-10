<?php
/**
 * Theme related functions. 
 *
 */



 
/**
 * TITLE
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @return string/null wether the title_append is defined or not.
 */
function get_title($title) {
  global $eden;
  return $title . (isset($eden['title_append']) ? $eden['title_append'] : null);
}


/**
 * NAVBAR
 * Create a navigation bar / menu for the site.
 *
 * @param string $menu for the navigation bar.
 * @return string as the html for the menu.
 */
function get_navbar($menu) {
  $html = "<nav class='{$menu['class']}'>\n<ul>\n";
  foreach($menu['items'] as $item) {
    $selected = $menu['callback_selected']($item['url']) ? " class='selected' " : null;
    $html .= "<li{$selected}><a href='{$item['url']}' title='{$item['title']}'>{$item['text']}</a></li>\n";
  }
  $html .= "</ul>\n</nav>\n";
  return $html;
}


/**
 * DUMP FUNCTION
 * Nice functions which lets you see the content of an array
 *
 * 
 * 
 */


function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}
 

