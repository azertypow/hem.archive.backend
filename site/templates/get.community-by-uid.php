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
      'bio_EN'           => $communityPage->bio_EN()->value(),
      'job'           => $communityPage->job()->value(),
      'job_en'           => $communityPage->job_en()->value(),
      'jobdetail'         => $communityPage->jobdetail()->value(),
      'jobDetail_EN'      => $communityPage->jobDetail_EN()->value(),
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
      'cover'         => $communityPage->cover()->toFile() ? getJsonEncodeImageData($communityPage->cover()->toFile()) : null,
    ];
  }
}
