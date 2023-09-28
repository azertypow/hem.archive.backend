<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

echo json_encode([
  'projects' => $site->find('projects')->children()->map(function (\Kirby\Cms\Page $project) use ($site) {
                    return [
                      'title' => $project->title()->value(),
//                      todo: author to authors in blueprint
                      'authors' => array_values($project->author()->toPages()->map(function (\Kirby\Cms\Page $author) {
                                  return [
                                      'author'      => $author->title(),
                                      'firstname' => $author->firstname()->value(),
                                      'Name'      => $author->name()->value(),
                                    ];
                              })->data()),
                      'cover' => getImageArrayDataInPage($project),
                      'theme1' => $project->themes(),
                      'theme2' => array_map(function (string $themeSlug) {
                        return $themeSlug;
                      },$project->themes()->yaml()),
                      'themes' => $project->themes(),
                      'axes' => $project->axes()->value(),
                    ];
                })
]);
