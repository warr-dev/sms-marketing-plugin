<?php

use \Ubnt\UcrmPluginSdk\Service\UcrmApi;
use \Ubnt\UcrmPluginSdk\Service\UcrmSecurity;
use \Ubnt\UcrmPluginSdk\Security\PermissionNames;
use Symfony\Component\HttpClient\HttpClient;


require_once __DIR__ . '/vendor/autoload.php';
$api = UcrmApi::create();
$security = UcrmSecurity::create();
$user = $security->getUser();

$client = HttpClient::create();
$response = $client->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');
dd($response->toArray());
// if (! $user || ! $user->hasViewPermission(PermissionNames::SCHEDULING_MY_JOBS)) {
//     die('You do not have permission to see this page.');
// }
// $jobs = $api->get(
//     'scheduling/jobs',
//     [
//         'statuses' => [0],
//         'assignedUserId' => $user->userId,
//     ]
// );
// echo 'The following jobs are open and assigned to you:<br>';
// echo '<ul>';
// foreach ($jobs as $job) {
//     echo sprintf('<li>%s</li>', htmlspecialchars($job['title'], ENT_QUOTES));
// }
// echo '</ul>';

function dd($data){
    echo '<pre>';
    die(var_dump($data));
    echo '</pre>';
}
?>