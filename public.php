<?php

declare(strict_types=1);

use App\Service\TemplateRenderer;
use Ubnt\UcrmPluginSdk\Security\PermissionNames;
use Ubnt\UcrmPluginSdk\Service\UcrmApi;
use Ubnt\UcrmPluginSdk\Service\UcrmOptionsManager;
use Ubnt\UcrmPluginSdk\Service\UcrmSecurity;
use Jajo\JSONDB;
use Symfony\Component\HttpClient\HttpClient;

chdir(__DIR__);

require __DIR__ . '/vendor/autoload.php';
session_start();
// Retrieve API connection.
$api = UcrmApi::create();
// use to make json file as db like
$json_db = new JSONDB( __DIR__ ); // Or passing the directory of your json files with no trailing slash, default is the current directory. E.g.  new JSONDB( '/var/www/html/json_files' )

// initiate httpclient for connecting to apis
$client = HttpClient::create();


// itextmo credrntials
$apikey='TR-WARRE804776_PPHZF';
$apipass='#@{nwkw5{5';

// twilio credentials
// $client = new Twilio\Rest\Client($sid, $token);
// $sid = "AC30a0f2078a0db789f4fe0bd5a82ae0e1"; // Your Account SID from www.twilio.com/console
// $token = "d457dd70ae0aae2900dc626d27bc1f66"; // Your Auth Token from www.twilio.com/console\
// $mynum="+13158608965";


$temp=[];// for templates

$targets=[];// target clients to send filtered with contact or billing num selected

$alerts=$_SESSION['alerts']??[];// store alerts



// Ensure that user is logged in and has permission to view invoices.
$security = UcrmSecurity::create();
$user = $security->getUser();
if (! $user || $user->isClient || ! $user->hasViewPermission(PermissionNames::BILLING_INVOICES)) {
    \App\Http::forbidden();
}

// Get the templates
$templates = $json_db->select( '*' )
	->from( 'templates.json' )
    ->get();
foreach($templates as $template){
    $temp[$template->name]=$template->content;
}

// get current balance
$response = $client->request('POST', 'https://www.itexmo.com/php_api/apicode_info.php',
    [
        'query' => [
            'apicode' => $apikey
        ]
    ]
);
$res = $response->toArray();
$bal=$res['Result ']['MessagesLeft'];


// get all clients
$allclients = $api->get('clients');

// if post request was sent contining ids of the clients get the clients and store in array
$ids=$_POST['ids']??'';
$ids=$ids!==''?explode(',',$ids):[];
// check if message to send is for billing or for contact
$isBilling=isset($_POST['type'])&&$_POST['type']==='isBilling';
$isContact=isset($_POST['type'])&&$_POST['type']==='isContact';
// if manual message or templated message get content
$content=$_POST['message']??$_POST['template']??'no content';
$content=$content===''?'no content':$content;

// if theres request for sending sms
if(isset($_POST['submit'])){
    // get the target contact of clients store it in target
    foreach($allclients as $perclient){
        if(in_array($perclient['id'],$ids)){
            foreach($perclient['contacts'] as $nums){
                if(($nums['isBilling']&&$isBilling)||($nums['isContact']&&$isContact)){
                    $data=[];
                    $data['num']=$nums['phone'];
                    $data['name']=$perclient['clientType']==2?$perclient['companyName']:$perclient['firstName'].' '.$perclient['lastName'];
                    array_push($targets,$data);
                    // $response = $client->request('POST', 'https://www.itexmo.com/php_api/api.php',
                    //         [
                    //             'body' => [
                    //                 '1' => $nums['phone'],
                    //                 '2' => $content,
                    //                 '3' => $apikey,
                    //                 'passwd' => $apipass
                    //             ]
                    //         ]
                    //     );
                    //     echo $content = $response->getContent();
                    //     echo 'sent to '.$nums['phone'].'<br>';
                }
            }
        }
    }
    if($bal>=count($targets)){
        $alertcontents=[];
        foreach($targets as $target){
            $response = $client->request('POST', 'https://www.itexmo.com/php_api/api.php',
                            [
                                'body' => [
                                    '1' => $target['num'],
                                    '2' => $content,
                                    '3' => $apikey,
                                    'passwd' => $apipass
                                ]
                            ]
                        );
            $res=$response->getContent();
            if($res>0){
                $c='Message sending failed to '.$target['name'].'.';
                switch($res){
                    case 1:
                        $c='Invalid number for '.$target['name'].'.';
                        break;
                }
                array_push($alertcontents,$c);
            }
        }
        $type=count($alertcontents)>0?'error':'success';
        $alertcontents=count($alertcontents)>0?$alertcontents:['Messages successfuly sent!'];
        array_push($alerts,[
            'type'=> $type,
            'contents' => $alertcontents
            ]);
        $_SESSION['alerts']=$alerts;
    }
    header('location:'.$_SERVER['PHP_SELF']);
    return;
}

session_destroy();
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
        'balance' => $bal,
        'templates' => $temp,
        'alerts' => $alerts,
        'ucrmPublicUrl' => $optionsManager->loadOptions()->ucrmPublicUrl,
        'result' => $result ?? [],
    ]
);