<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

echo json_encode([
  'pages' => $site->find('communaute')->children()->map(function (\Kirby\Cms\Page $comunityPage) use ($kirby, $site) {
    return [
      'uid'         => $comunityPage->uid(),
      'title'        => $comunityPage->title()->value(),
      'firstname'   => $comunityPage->firstname()->value(),
      'name'        => $comunityPage->name()->value(),
      'job'         => $comunityPage->job()->value(),
    ];
  })->data()
]);
