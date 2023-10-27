<?php
/** @global Kirby\Cms\App $kirby */
/** @global Kirby\Cms\Site $site */
/** @global Kirby\Cms\Page $page */

$session = $kirby->session();

$session->set('app.sample.v1.connected', true);

echo '<pre>';
print_r($session->get('app.sample.v1.connected'));
echo '</pre>';

//                $csrfKey = csrf(); // Génère une clé CSRF
//                $_SESSION['csrf_key'] = $csrfKey; // Stockez la clé CSRF dans la session pour une utilisation ultérieure
//                print_r(session_status());
//                print_r($_SESSION);

//                if ($csrfKey === $storedCSRFKey) {
//                    // La clé CSRF est valide, continuez avec la requête
//                } else {
//                    // La clé CSRF n'est pas valide, rejetez la requête
//                }
