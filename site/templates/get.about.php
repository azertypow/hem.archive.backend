<?php

include_once '_phpTools/jsonEncodeKirbyContent.php';

function getAbout(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $aboutPage = $site->find('a-propos');

  if ($aboutPage == null) {
    return [
      'error' => 'la page n\'existe pas',
    ];
  } else {

    return [
      'uid'           => $aboutPage->uid(),
      'title'         => $aboutPage->title()->value(),
      'abouttext'     => array_values($aboutPage->abouttext()->toBlocks()->map(function ($value) {

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
            'content' => $value->content()->toArray(),
          ];

        if ($value->type() == 'video')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
            'content' => $value->content()->toArray(),
          ];

        return [
          'type' => $value->type(),
          'content' => $value->content()->toArray(),
          'isHidden' => $value->isHidden(),
        ];
      })->data()),
      'abouttext_en'     => array_values($aboutPage->abouttext_en()->toBlocks()->map(function ($value) {

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
            'content' => $value->content()->toArray(),
          ];

        if ($value->type() == 'video')
          return [
            'type' => $value->type(),
            'isHidden' => $value->isHidden(),
            'content' => $value->content()->toArray(),
          ];

        return [
          'type' => $value->type(),
          'content' => $value->content()->toArray(),
          'isHidden' => $value->isHidden(),
        ];
      })->data()),
    ];

  }
}
