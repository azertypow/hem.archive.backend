<?php
//
//use  Kirby\Cms\App as KirbyApp;
//
//try {
//    KirbyApp::plugin('azertypow/blueprint-structure-type-limitation', [
//            'hooks' => [
//
//                'page.update:before' => function (Kirby\Cms\Page $page, array $values, array $strings) {
//
//
//                    // Récupérez le contenu actuel du champ "axes" de type "structure"
//                    /** @var object $currentContent */
//                    $currentContent = $page->content()->get('axes');
//
//                    echo'<h1>-----</h1>';
//                    echo'<pre>';
//                    print_r($currentContent->toStructure()->toArray());
//                    echo'</pre>';
//                    echo'<h1>-----</h1>';
//
//                    // Récupérez les nouvelles données du champ "axes" de type "structure" du tableau $values
//                    /** @var array $newContent */
//                    $newContent = $values['axes'] ?? [];
//
//                    echo'<pre>';
//                    var_dump($values['axes']);
//                    echo'</pre>';
//                    echo'<h1>-----</h1>';
//
//                    // Comparez les données actuelles avec les nouvelles données
//                    if ($currentContent !== $newContent) {
//                        // Le champ "axes" de type "structure" a été modifié, effectuez une action personnalisée ici
//                        // ...
//                        echo'<pre>';
//                        echo 'Le champ "axes" de type "structure" a été modifié';
//                        echo'</pre>';
//                    }
//
////                    echo'<pre>';
////                    var_dump($page);
////                    echo'</pre>';
////
////                    echo'<h1>-----</h1>';
//
//                    echo'<pre>';
//                    var_dump($values);
//                    echo'</pre>';
//
//                    echo'<h1>-----</h1>';
//
////                    echo'<pre>';
////                    var_dump($strings);
////                    echo'</pre>';
//                    die();
//                }
//            ]]
//    );
//} catch (\Kirby\Exception\DuplicateException $e) {
//}
//
