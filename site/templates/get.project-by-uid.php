<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getProjectByUID(string $pageUid, Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $project = $site->find('projects')->children()->find($pageUid);


  if ($project == null) {
    return [
      'error' => 'la page n\'existe pas',
    ];
  } else {
    return [
      'uid' => $project->uid(),
      'title' => $project->title()->value(),
//                      todo: author to authors in blueprint
      'authors' => array_map(function (string $themeSlug) use ($kirby) {
        $author = $kirby->page(trim($themeSlug));
        if ($author == null) return null;
        return [
          'author' => $author->title(),
          'firstname' => $author->firstname()->value(),
          'Name' => $author->name()->value(),
        ];
      }, explode(',', $project->author()->value())),
      'dateStart' => $project->dateStart()->value(),
      'dateEnd' => $project->dateEnd()->value(),
      'showMonth' => $project->showMonth()->value(),
      'cover' => getImageArrayDataInPage($project),
      'themes' => array_map(function (string $themeSlug) use ($kirby) {
        $themePage = $kirby->page(trim($themeSlug));
        if ($themePage == null) return null;
        return [
          'title' => $themePage->title()->value(),
          'uid' => $themePage->uid(),
        ];
      }, explode(',', $project->themes()->value())),
      'axes' => array_values($project->axes()->toPages()->map(function (\Kirby\Cms\Page $author) {
        return [
          'title' => $author->title()->value(),
          'uid' => $author->uid(),
        ];
      })->data()),

//    project content details
      'partners' => $project->partners()->value(),
      'team' => $project->team()->value(),
      'financement' => $project->financement()->value(),

      'filesChapters' => $project->children()->map(function (\Kirby\Cms\Page $fileChapter) {
        return [
          'title' => $fileChapter->title()->value(),
          'uid' => $fileChapter->uid(),
          'slug' => $fileChapter->slug(),
          'uri' => $fileChapter->uri(),
          'files' => $fileChapter->files()->map(function (\Kirby\Cms\File $file) {
            return [
              'extension' => $file->extension(),
              'mime' => $file->mime(),
              'modified' => $file->modified(),
              'name' => $file->name(),
              'niceSize' => $file->niceSize(),
              'type' => $file->type(),
              'url' => $file->url(),
              'id' => $file->id(),
            ];
          })->data(),
        ];
      })->data(),

      'content' => $project->text()->toBlocks()->map(function ($value) {

        if ($value->type() == 'image') {
          return getBlogContentImageType($value);
        }

        if ($value->type() == 'text')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
            'value' => $value->text()->value(),
          ];

        if ($value->type() == 'gallery')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
          ];

        if ($value->type() == 'video')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
            'content' => $value->content()->toArray(),
          ];

        return [
          'type' => $value->type(),
//        'isHidden' => $value->isHidden(),
        ];
      })->data(),
    ];
  }
}
