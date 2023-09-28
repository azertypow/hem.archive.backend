<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

echo json_encode([
  'projects' => $site->find('projects')->children()->map(function (\Kirby\Cms\Page $project) use ($kirby, $site) {
                    return [
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
                    ];
                })->data()
]);
