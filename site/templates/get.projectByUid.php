<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

$pageUid = $page->pageUid();

$project = $site->find('projects')->children()->find($pageUid);

header('Content-Type: application/json');

if($project == null) {
  echo json_encode([
    'error' => 'la page n\'existe pas',
  ]);
} else {
  echo json_encode([
    'uid'   => $project->uid(),
    'title' => $project->title()->value(),
//                      todo: author to authors in blueprint
    'authors' => array_map(function (string $themeSlug) use ($kirby) {
      $author = $kirby->page( trim($themeSlug) );
      if($author == null) return null;
      return [
        'author'      => $author->title(),
        'firstname' => $author->firstname()->value(),
        'Name'      => $author->name()->value(),
      ];
    }, explode(',', $project->author()->value())),
    'dateStart' => $project->dateStart()->value(),
    'dateEnd'   => $project->dateEnd()->value(),
    'showMonth' => $project->showMonth()->value(),
    'cover' => getImageArrayDataInPage($project),
    'themes' => array_map(function (string $themeSlug) use ($kirby) {
      $themePage = $kirby->page( trim($themeSlug) );
      if($themePage == null) return null;
      return [
        'title' => $themePage->title()->value(),
      ];
    }, explode(',', $project->themes()->value())),
    'axes' => array_values($project->axes()->toPages()->map(function (\Kirby\Cms\Page $author) {
      return [
        'title'      => $author->title()->value(),
      ];
    })->data()),



//    project content details
    'partners'    => $project->partners()->value(),
    'team'        => $project->team()->value(),
    'financement' => $project->financement()->value(),
    'content'     => $project->text()->toBlocks()->map(function($value) {

      if( $value->type() == 'image' ) {
        return getBlogContentImageType($value);
      }

      if( $value->type() == 'text' )
        return [
          'type'      => $value->type(),
          'isHidden'  => $value->isHidden(),
          'value'     => $value->text()->value(),
        ];

      if( $value->type() == 'gallery' )
        return [
          'type'  => $value->type(),
          'isHidden' => $value->isHidden(),
        ];

      if( $value->type() == 'video' )
        return [
          'type'  => $value->type(),
          'isHidden' => $value->isHidden(),
        ];

      return [
        'type'  => $value->type(),
//        'isHidden' => $value->isHidden(),
      ];
    })->data(),
  ]);
}

