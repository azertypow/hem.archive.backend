<?php

function getSearch(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $query   = get('q');
  $minLength = 2;
  $result = page('projects')->children()->listed()->search($query, [
    'fields' => ['title', 'text'],
    'words' => true,
    'minlength' => 2,
    'stopwords' => [
      "je", "tu", "il", "elle", "on", "nous", "vous", "ils", "elles",
      "me", "te", "se", "nous", "vous", "le", "la", "les", "lui", "leur",
      "moi", "toi", "soi", "eux", "elles", "ceci", "cela", "ceux",
      "celles", "celles", "personne", "quelqu'un", "rien", "tout", "un", "une",
      "quelque", "certains", "certaines", "tel", "telle", "tels", "telles",
      "tout", "toute", "tous", "toutes",
    ],
  ])->toArray();

  return [
    'query'     => $query,
    'result'    => $result,
    'minLength' => $minLength,
  ];
}
