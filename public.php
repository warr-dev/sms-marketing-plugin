<?php

declare(strict_types=1);

use App\Service\TemplateRenderer;
use Ubnt\UcrmPluginSdk\Security\PermissionNames;
use Ubnt\UcrmPluginSdk\Service\UcrmApi;
use Ubnt\UcrmPluginSdk\Service\UcrmOptionsManager;
use Ubnt\UcrmPluginSdk\Service\UcrmSecurity;
use Jajo\JSONDB;

chdir(__DIR__);

require __DIR__ . '/vendor/autoload.php';

// Retrieve API connection.
$api = UcrmApi::create();

// Ensure that user is logged in and has permission to view invoices.
$security = UcrmSecurity::create();
$user = $security->getUser();
if (! $user || $user->isClient || ! $user->hasViewPermission(PermissionNames::BILLING_INVOICES)) {
    \App\Http::forbidden();
}
$json_db = new JSONDB( __DIR__ ); // Or passing the directory of your json files with no trailing slash, default is the current directory. E.g.  new JSONDB( '/var/www/html/json_files' )
$templates = $json_db->select( '*' )
	->from( 'templates.json' )
    ->get();
$temp=[];
foreach($templates as $template){
    $temp[$template->name]=$template->content;
}
// print_r( $temps );
// return;
$api = UcrmApi::create();
$allclients = $api->get('clients');
$ids=$_POST['ids']??'';
$ids=$ids!==''?explode(',',$ids):[];
// if(isset($_POST['submit'])){
//     $sid = "ACXXXXXX"; // Your Account SID from www.twilio.com/console
//     $token = "YYYYYY"; // Your Auth Token from www.twilio.com/console

//     $client = new Twilio\Rest\Client($sid, $token);
//     $message = $client->messages->create(
//     '8881231234', // Text this number
//     [
//         'from' => '9991231234', // From a valid Twilio number
//         'body' => 'Hello from Twilio!'
//     ]
//     );
// }
    $sid = "AC30a0f2078a0db789f4fe0bd5a82ae0e1"; // Your Account SID from www.twilio.com/console
    $token = "d457dd70ae0aae2900dc626d27bc1f66"; // Your Auth Token from www.twilio.com/console\
    $mynum="+13158608965";
    $client = new Twilio\Rest\Client($sid, $token);
    $isBilling=isset($_POST['type'])&&$_POST['type']==='isBilling';
    $isContact=isset($_POST['type'])&&$_POST['type']==='isContact';
    $content=$_POST['message']??$_POST['template']??'';
    if(isset($_POST['submit']))
        foreach($allclients as $perclient){
            if(in_array($perclient['id'],$ids)){
                foreach($perclient['contacts'] as $nums){
                    if(($nums['isBilling']&&$isBilling)||($nums['isContact']&&$isContact)){
                    $message = $client->messages->create(
                        $nums['phone'], // Text this number
                        [
                            'from' => $mynum, // From a valid Twilio number
                            'body' => $content
                        ]
                    ); 
                    }
                    // echo 'send to '.$nums['phone'];
                }
            }
        }
$pageinfo=[];
$params=[];
$tab=$_GET['tab']??'all';
if($tab!='all') $params['lead']=$tab=='lead'?1:0;
$allclients = $api->get('clients',$params);
$allclients=count($allclients);
$page=$_GET['page']??1;
$pageinfo['tab']=$tab;
$pageinfo['count']=$allclients;
$pageinfo['pages']=$allclients/10;
if($allclients%10!==0)
    $pageinfo['pages']=intval($allclients/10)+1;
$pageinfo['page']=$page;
$params=[];
$params =['limit'=>10,'offset'=>(($page-1)*10)];
if($tab!=='all') $params['lead']=$tab=='lead'?1:0;
$clients = $api->get('clients',$params);
$services = $api->get('clients/services');
$cls=[];
foreach($clients as $client){
    $data['Id'] = $client['id'];
    $data['Name'] = $client['clientType']==2?$client['companyName']:$client['firstName'].' '.$client['lastName'];
    $data['Created'] = date("F j, Y, g:i a",strtotime($client['registrationDate']));
    $data['Qouted Services']=[];
    foreach($services as $s)
        if($s['clientId']===$client['id'])
           $data['Qouted Services']=$s['name'];
    $data['Note']='';
    array_push($cls,$data);
}

$cols=['Id','Name','Created','Qouted Services','Note'];
$styles=[
    'Qouted Services'=>'status-yellow|tdcenter',
    'Created' => 'tdcenter',
];
// print_r($cls);
// Retrieve renderer.
$renderer = new TemplateRenderer();


// Render form.
// $organizations = $api->get('organizations');

$optionsManager = UcrmOptionsManager::create();

$renderer->render(
    __DIR__ . '/templates/layout.php',
    [
        'clients' => $cls,
        'cols' => $cols,
        'pageinfo' => $pageinfo,
        'styles' => $styles,
        'templates' => $temp,
        'ucrmPublicUrl' => $optionsManager->loadOptions()->ucrmPublicUrl,
        'result' => $result ?? [],
    ]
);