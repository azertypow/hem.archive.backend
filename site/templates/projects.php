<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

echo '<pre>';
//  print_r( $site->find('themes-et-axe-de-recherche')->children() );
  print_r( $site->find('themes-et-axe-de-recherche')->children()->template('tags-list') );
echo '</pre>';
