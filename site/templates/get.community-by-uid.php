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
      'researchProject' => $site->find('projects')->children()->filter(
        function ($projectItem) use ($communityPage) {

          $articleAuthorArray = array_map( fn($authorItem) => trim($authorItem), explode( ',', $projectItem->content()->author()) );

          return in_array( $communityPage->uri(), $articleAuthorArray );
        },
      )->toArray(),
      'publications'  => $communityPage->publications()->toStructure()->map(
        fn($item) => $item->toArray()
      )->data(),
      'cover'         => getJsonEncodeImageData($communityPage->cover()->toFile()),
    ];
  }
}
