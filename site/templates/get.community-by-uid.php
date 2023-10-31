<?php

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getCommunityByUID(string $pageUid, Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $communityPage = $site->find('communaute')->children()->find($pageUid);

  if ($communityPage == null) {
    return [
      'error' => 'la page n\'existe pas',
    ];
  } else {

//    return $communityPage->toArray();


    return [
      'uid'           => $communityPage->uid(),
      'title'         => $communityPage->title()->value(),
      'firstname'     => $communityPage->firstname()->value(),
      'name'          => $communityPage->name()->value(),
      'bio'           => $communityPage->bio()->value(),
      'job'           => $communityPage->job()->value(),
      'jobdetail'     => $communityPage->jobdetail()->value(),
      'mail'          => $communityPage->mail()->value(),
      'publications'  => $communityPage->publications()->toStructure()->map(
        fn($item) => $item->toArray()
      )->data(),
      'cover'         => getJsonEncodeImageData($communityPage->cover()->toFile()),
    ];

//    return [
//      'uid'         => $communityPage->uid(),
//      'title'       => $communityPage->title()->value(),
//      'authors' => array_map(function (string $themeSlug) use ($kirby) {
//        $author = $kirby->page(trim($themeSlug));
//        if ($author == null) return null;
//        return [
//          'author' => $author->title(),
//          'firstname' => $author->firstname()->value(),
//          'Name' => $author->name()->value(),
//        ];
//      }, explode(',', $communityPage->author()->value())),
//      'dateStart' => $communityPage->dateStart()->value(),
//      'dateEnd' => $communityPage->dateEnd()->value(),
//      'showMonth' => $communityPage->showMonth()->value(),
//      'cover' => getImageArrayDataInPage($communityPage),
//      'themes' => array_map(function (string $themeSlug) use ($kirby) {
//        $themePage = $kirby->page(trim($themeSlug));
//        if ($themePage == null) return null;
//        return [
//          'title' => $themePage->title()->value(),
//          'uid' => $themePage->uid(),
//        ];
//      }, explode(',', $communityPage->themes()->value())),
//      'axes' => array_values($communityPage->axes()->toPages()->map(function (\Kirby\Cms\Page $author) {
//        return [
//          'title' => $author->title()->value(),
//          'uid' => $author->uid(),
//        ];
//      })->data()),
//
////    project content details
//      'partners' => $communityPage->partners()->value(),
//      'team' => $communityPage->team()->value(),
//      'financement' => $communityPage->financement()->value(),
//
//      'filesChapters' => $communityPage->children()->map(function (\Kirby\Cms\Page $fileChapter) {
//        return [
//          'title' => $fileChapter->title()->value(),
//          'uid' => $fileChapter->uid(),
//          'slug' => $fileChapter->slug(),
//          'uri' => $fileChapter->uri(),
//          'files' => $fileChapter->files()->map(function (\Kirby\Cms\File $file) {
//            return [
//              'extension' => $file->extension(),
//              'mime' => $file->mime(),
//              'modified' => $file->modified(),
//              'name' => $file->name(),
//              'niceSize' => $file->niceSize(),
//              'type' => $file->type(),
//              'url' => $file->url(),
//              'id' => $file->id(),
//            ];
//          })->data(),
//        ];
//      })->data(),
//
//      'content' => $communityPage->text()->toBlocks()->map(function ($value) {
//
//        if ($value->type() == 'image') {
//          return getBlogContentImageType($value);
//        }
//
//        if ($value->type() == 'text')
//          return [
//            'type' => $value->type(),
//            'isHidden' => $value->isHidden(),
//            'value' => $value->text()->value(),
//          ];
//
//        if ($value->type() == 'gallery')
//          return [
//            'type' => $value->type(),
//            'isHidden' => $value->isHidden(),
//          ];
//
//        if ($value->type() == 'video')
//          return [
//            'type' => $value->type(),
//            'isHidden' => $value->isHidden(),
//            'content' => $value->content()->toArray(),
//          ];
//
//        return [
//          'type' => $value->type(),
////        'isHidden' => $value->isHidden(),
//        ];
//      })->data(),
//    ];
  }
}
