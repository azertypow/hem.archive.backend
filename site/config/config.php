<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen.
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */

use Kirby\Cms\Page;

return [
    'debug' => true,
    'routes' => [
        [
            'pattern' => '/',
            'action'  => function () {
                go('/panel');
            }
        ],
        [
            'pattern' => '/webapp/api/v1/projects',
            'action'  => function () {
                header("Access-Control-Allow-Origin: *");

                return new Page([
                    'slug'      => 'projects',
                    'template'  => 'get.projects',
                ]);
            }
        ],
        [
            'pattern' => '/webapp/api/v1/project-by-uid/(:any)',
            'action'  => function ($pageUid) {
                header("Access-Control-Allow-Origin: *");

                return new Page([
                    'slug'      => 'project',
                    'template'  => 'get.project-by-uid',
                    'content'   => [
                        'pageUid'        => $pageUid,
                    ],
                ]);
            }
        ],
        [
            'pattern' => '/webapp/api/v1/community',
            'action'  => function () {
                header("Access-Control-Allow-Origin: *");

                return new Page([
                    'slug'      => 'community',
                    'template'  => 'get.community',
                ]);
            }
        ],
        [
            'pattern' => '/webapp/api/v1/connection',
            'action'  => function () {
                header("Access-Control-Allow-Origin: *");

                return new Page([
                    'slug'      => 'auth',
                    'template'  => 'post.auth',
                ]);
            }
        ],
    ],
    'panel' => [
        'css' => '_custom-panel/main.css',
    ],
];
