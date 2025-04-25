<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

echo json_encode([
  'projects' => $site->find('projects')->children()->filterBy('status', 'listed')->map(function (\Kirby\Cms\Page $project) use ($kirby, $site) {
                    return [
                      'status' => $project->status(),
                      'uid'   => $project->uid(),
                      'title' => $project->title()->value(),
                      'title_EN' => $project->title_EN()->value(),
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
                          'title' =>  $themePage->title()->value(),
                          'uid'   =>  $themePage->uid(),
                          'uuid'  =>  $themePage->content()->uuid()->value(),
                          'uri'   =>  $themePage->uri(),
                        ];
                      }, explode(',', $project->themes()->value())),
                      'axes' => array_values($project->axes()->toPages()->map(function (\Kirby\Cms\Page $axePage) {
                        return [
                          'title' =>  $axePage->title()->value(),
                          'uid'   =>  $axePage->uid(),
                          'uuid'  =>  $axePage->content()->uuid()->value(),
                          'uri'   =>  $axePage->uri(),
                          'theme' =>  $axePage->theme()->value(),
                        ];
                      })->data()),
                    ];
                })->data()
]);
