<?php

function getSearch(Kirby\Cms\App $kirby, Kirby\Cms\Site $site): array
{
  $query   = get('q');
  $minLength = str_word_count($query) > 1 ? 5 : 2;
  $result = page('projects')->search($query, [
    'minlength' => $minLength,
  ]);

  return [
    'query'     => $query,
    'result'    => $result,
    'minLength' => $minLength,
  ];
}
