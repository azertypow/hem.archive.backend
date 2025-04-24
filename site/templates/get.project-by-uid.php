<?php

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
      'title_EN'  => $project->content()->title_EN()->value(),
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

//    project content details
      'partners' => $project->partners()->value(),
      'team' => $project->team()->value(),
      'financement' => $project->financement()->value(),
      'publications' => $project->publications()->value(),

      'filesChapters' => $project->children()->map(function (\Kirby\Cms\Page $fileChapter) {
        return [
          'title'     => $fileChapter->title()->value(),
          'title_en'  => $fileChapter->title_en()->value(),
          'textDescription'     => $fileChapter->textDescription()->value(),
          'textDescription_EN'  => $fileChapter->textDescription_EN()->value(),
          'uid' => $fileChapter->uid(),
          'slug' => $fileChapter->slug(),
          'uri' => $fileChapter->uri(),
          'detailsListe' => $fileChapter->detailsListe()->toStructure()->map(
            fn($item) => $item->toArray()
          )->data(),
          'detailsListe_EN' => $fileChapter->detailsListe_EN()->toStructure()->map(
            fn($item) => $item->toArray()
          )->data(),
          'archiveFiles' => $fileChapter->archivefiles()->toFiles()->map(function (\Kirby\Cms\File $file) {
            return [
              'extension' => $file->extension(),
              'mime' => $file->mime(),
              'modified' => $file->modified(),
              'name' => $file->name(),
              'niceSize' => $file->niceSize(),
              'type' => $file->type(),
              'url' => $file->url(),
              'id' => $file->id(),
              'caption' => $file->caption()->value(),
              'caption_en' => $file->caption_en()->value(),
            ];
          })->data(),
          'imagesFiles' => $fileChapter->imagesFiles()->toFiles()->map(function (\Kirby\Cms\File $file) {
            return [
              'extension' => $file->extension(),
              'mime' => $file->mime(),
              'modified' => $file->modified(),
              'name' => $file->name(),
              'niceSize' => $file->niceSize(),
              'type' => $file->type(),
              'url' => $file->url(),
              'id' => $file->id(),
              'caption' => $file->caption()->value(),
              'caption_en' => $file->caption_en()->value(),
            ];
          })->data(),
          'videoFiles' => $fileChapter->videoFiles()->toFiles()->map(function (\Kirby\Cms\File $file) {
            return [
              'extension' => $file->extension(),
              'mime' => $file->mime(),
              'modified' => $file->modified(),
              'name' => $file->name(),
              'niceSize' => $file->niceSize(),
              'type' => $file->type(),
              'url' => $file->url(),
              'id' => $file->id(),
              'caption' => $file->caption()->value(),
              'caption_en' => $file->caption_en()->value(),
            ];
          })->data(),
          'audioFiles' => $fileChapter->audioFiles()->toFiles()->map(function (\Kirby\Cms\File $file) {
            return [
              'extension' => $file->extension(),
              'mime' => $file->mime(),
              'modified' => $file->modified(),
              'name' => $file->name(),
              'niceSize' => $file->niceSize(),
              'type' => $file->type(),
              'url' => $file->url(),
              'id' => $file->id(),
              'caption' => $file->caption()->value(),
              'caption_en' => $file->caption_en()->value(),
            ];
          })->data(),
          'pdfFiles' => $fileChapter->pdfFiles()->toFiles()->map(function (\Kirby\Cms\File $file) {
            return [
              'extension' => $file->extension(),
              'mime' => $file->mime(),
              'modified' => $file->modified(),
              'name' => $file->name(),
              'niceSize' => $file->niceSize(),
              'type' => $file->type(),
              'url' => $file->url(),
              'id' => $file->id(),
              'caption' => $file->caption()->value(),
              'caption_en' => $file->caption_en()->value(),
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
            'content' => array_values($value->content()->images()->toFiles()->map(
              fn($file) => getJsonEncodeImageData($file)
            )->data()),
            'caption' => $value->caption()->value(),
          ];

        if ($value->type() == 'video')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
            'content' => $value->content()->toArray(),
          ];

        return $value->toArray();
      })->data(),

      'text_en' => $project->text_EN()->toBlocks()->map(function ($value) {

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
            'content' => array_values($value->content()->images()->toFiles()->map(
              fn($file) => getJsonEncodeImageData($file)
            )->data()),
            'caption' => $value->caption()->value(),
          ];

        if ($value->type() == 'video')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
            'content' => $value->content()->toArray(),
          ];

        return $value->toArray();
      })->data(),
    ];
  }
}
