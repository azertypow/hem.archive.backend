<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

function getTags(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  return [
//    'tags' => $site->find('themes-et-axe-de-recherche')->childrenAndDrafts()->filterBy('template', 'list-theme')->data(),
//    'tags2' => $site->find('themes-et-axe-de-recherche')->childrenAndDrafts()->map(function (\Kirby\Cms\Page $item) {
//      return $item->blueprints()[0]->;
//    }),

    'listAxes' => array_values(
      $site
        ->find('themes-et-axe-de-recherche')
        ->childrenAndDrafts()
        ->filter(function (\Kirby\Cms\Page $themeOrResearchItem) use ($kirby, $site) {
          return $themeOrResearchItem->blueprints()[0]['name'] === 'list-axes';
        })->map(function (\Kirby\Cms\Page $themeItem) {
          return [
            'title' => $themeItem->content()->title()->value(),
            'uuid' => $themeItem->content()->uuid()->value(),
            'uri' => $themeItem->uri(),
            'theme'  => $themeItem->theme()->value(),
          ];
        })->data()
    ),

    'listTheme' => array_values(
      $site
        ->find('themes-et-axe-de-recherche')
        ->childrenAndDrafts()
        ->filter(function (\Kirby\Cms\Page $themeOrResearchItem) use ($kirby, $site) {
          return $themeOrResearchItem->blueprints()[0]['name'] === 'list-theme';
        })->map(function (\Kirby\Cms\Page $themeItem) {
          return [
            'title' => $themeItem->content()->title()->value(),
            'uuid' => $themeItem->content()->uuid()->value(),
            'uri' => $themeItem->uri(),
          ];
        })->data()
    ),

//    'projects' => $site->find('projects')->children()->filterBy('status', 'listed')->map(function (\Kirby\Cms\Page $project) use ($kirby, $site) {
//      return [
//        'status' => $project->status(),
//        'template' => $project->template(),
//        'uid'   => $project->uid(),
//        'title' => $project->title()->value(),
////                      todo: author to authors in blueprint
//        'authors' => array_map(function (string $themeSlug) use ($kirby) {
//          $author = $kirby->page( trim($themeSlug) );
//          if($author == null) return null;
//          return [
//            'author'      => $author->title(),
//            'firstname' => $author->firstname()->value(),
//            'Name'      => $author->name()->value(),
//          ];
//        }, explode(',', $project->author()->value())),
//        'dateStart' => $project->dateStart()->value(),
//        'dateEnd'   => $project->dateEnd()->value(),
//        'showMonth' => $project->showMonth()->value(),
//        'themes' => array_map(function (string $themeSlug) use ($kirby) {
//          $themePage = $kirby->page( trim($themeSlug) );
//          if($themePage == null) return null;
//          return [
//            'title' => $themePage->title()->value(),
//            'uid' => $themePage->uid(),
//          ];
//        }, explode(',', $project->themes()->value())),
//      ];
//    })->data()

  ];
}


//echo \Kirby\Cms\Response::json([
//  'tags' => $site->find('themes-et-axe-de-recherche')->children()->filterBy('status', 'listed'),
//]);

//echo json_encode([
//  'projects' => $site->find('themes et axe de recherche')->children()->filterBy('status', 'listed')->map(function (\Kirby\Cms\Page $project) use ($kirby, $site) {
//                    return [
//                      'status' => $project->status(),
//                      'uid'   => $project->uid(),
//                      'title' => $project->title()->value(),
////                      todo: author to authors in blueprint
//                      'authors' => array_map(function (string $themeSlug) use ($kirby) {
//                        $author = $kirby->page( trim($themeSlug) );
//                        if($author == null) return null;
//                        return [
//                          'author'      => $author->title(),
//                          'firstname' => $author->firstname()->value(),
//                          'Name'      => $author->name()->value(),
//                        ];
//                      }, explode(',', $project->author()->value())),
//                      'dateStart' => $project->dateStart()->value(),
//                      'dateEnd'   => $project->dateEnd()->value(),
//                      'showMonth' => $project->showMonth()->value(),
//                      'cover' => getImageArrayDataInPage($project),
//                      'themes' => array_map(function (string $themeSlug) use ($kirby) {
//                        $themePage = $kirby->page( trim($themeSlug) );
//                        if($themePage == null) return null;
//                        return [
//                          'title' => $themePage->title()->value(),
//                          'uid' => $themePage->uid(),
//                        ];
//                      }, explode(',', $project->themes()->value())),
//                      'axes' => array_values($project->axes()->toPages()->map(function (\Kirby\Cms\Page $author) {
//                        return [
//                          'title'      => $author->title()->value(),
//                          'uid'        => $author->uid(),
//                        ];
//                      })->data()),
//                    ];
//                })->data()
//]);
