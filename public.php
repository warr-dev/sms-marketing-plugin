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
// Render form.
// $organizations = $api->get('organizations');

$optionsManager = UcrmOptionsManager::create();


$vars = $json_db->select( '*' )
->from( 'variables.json' )
->get();

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

// Retrieve renderer.
$renderer = new TemplateRenderer();


// Ensure that user is logged in and has permission to view invoices.
$security = UcrmSecurity::create();
$user = $security->getUser();
if (! $user || $user->isClient || ! $user->hasViewPermission(PermissionNames::BILLING_INVOICES)) {
    \App\Http::forbidden();
}

// function getMesVars($mes){
//     $pos=0;
//     $v=[];
//     while(strpos($mes,'{{',$pos)!==false){
//         $start=strpos($mes,'{{',$pos);
//         $end=strpos($mes,'}}',$pos)+2;
//         $var=substr($mes,$start,$end-$start);
//        $var=str_replace(array(" ", "{", "}"),'',$var);
//         $pos=$end+1;
//         array_push($v,$var);
//     }
//     return $v;
// }


if(isset($_GET['json'])){
    echo readfile('templates.json');
}
// Get the templates
$templates = $json_db->select( '*' )
	->from( 'templates.json' )
    ->get();
$lastid=0;
foreach($templates as $template){
    $lastid=$template->id;
    $temp[$template->name]=$template->content;
}
if(isset($_GET['templating'])){
    if(isset($_GET['deltemplate'])){
        $id=$_GET['deltemplate'];
        $json_db->delete()
            ->from( 'templates.json' )
            ->where( [ 'id' => $id ] )
            ->trigger();
        array_push($alerts,['type'=>'success','contents'=>['Template deleted successfully.']]);
        $_SESSION['alerts']=$alerts;
        header('location:'.$_SERVER['PHP_SELF'].'?templating');
        return;
    }
    if(isset($_POST['addt'])){
        $name=$_POST['tname'];
        $mes=$_POST['message'];
        $json_db->insert( 'templates.json', 
            [ 
                'id' => $lastid + 1, 
                'name' => $name,
                'category' => [],
                'content' => $mes 
            ]
        );
        array_push($alerts,['type'=>'success','contents'=>['Template added successfully.']]);
        $_SESSION['alerts']=$alerts;
        header('location:'.$_SERVER['PHP_SELF'].'?templating');
        return;
    }
    else if(isset($_POST['upt'])){
        $id=$_POST['upt'];
        $name=$_POST['tname'];
        $mes=$_POST['message'];
        $json_db->update( [ 'name' => $name, 'content' => $mes ] )
            ->from( 'templates.json' )
            ->where( [ 'id' => $id ] )
            ->trigger();
        array_push($alerts,['type'=>'success','contents'=>['Template updated successfully.']]);
        $_SESSION['alerts']=$alerts;
        header('location:'.$_SERVER['PHP_SELF'].'?templating');
        return;
    }
    session_destroy();

    $renderer->render(
        __DIR__ . '/templates/templating.php',
        [
            'alerts' => $alerts,
            'pagename' => '- Templating',
            'temps' => $templates,
            'variables' => $vars
        ]
    );
    return;
}
if(isset($_GET['upload'])){
    $uploadDir = __DIR__; //path you wish to store you uploaded files
    $uploadedFile = $uploadDir . '/templates.json';
    $errors=[];
    if (isset($_FILES['template'])) {
        if($_FILES['template']['error'] > 0){
            switch($_FILES['template']['error'])
            {
                case 1: array_push($errors,'File exceeded upload_max_filesize'); break;
                case 2: array_push($errors,'File exceeded max_file_size'); break;
                case 3: array_push($errors,'File only partially uploaded'); break;
                case 4: array_push($errors,'No file uploaded'); break;
            }
            array_push($alerts,['type'=>'error','contents'=> $errors]);
        }
        else{
            $filename = $_FILES['template']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if($ext==='json'){
                if(move_uploaded_file($_FILES['template']['tmp_name'], $uploadedFile)) {
                    array_push($alerts,['type'=>'success','contents'=>['Restoration Successful']]);
                } else {
                    array_push($alerts,['type'=>'error','contents'=>['Restoration failed!']]);
                }
            }
            else{
                array_push($alerts,['type'=>'error','contents'=>['Only JSON file was allowed']]);
            }
        }
        $_SESSION['alerts']=$alerts;
        header('location:'.$_SERVER['PHP_SELF'].'?templating');
        return;
    }
    array_push($alerts,['type'=>'error','contents'=>['No File was selected']]);
    $_SESSION['alerts']=$alerts;
    header('location:'.$_SERVER['PHP_SELF'].'?templating');
    return;
}
if(isset($_GET["download"])){
        $filepath='templates.json';
        // Process download
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
            die('downloaded');
        } else {
            http_response_code(404);
	        die('failed');
        }
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


// $mesVars=getMesVars($content);



// Templating
function templatize($str,$vals,$vars){
    foreach($vars as $var){
        $column=$var->varval;
        $str=str_replace('{{ ' . $var->varname . ' }}', $vals[$column] ?? '' , $str);
    }
    return $str;
}
// if theres request for sending sms
if(isset($_POST['submit'])){
    // get the target contact of clients store it in target
    foreach($allclients as $perclient){
        if(in_array($perclient['id'],$ids)){
            foreach($perclient['contacts'] as $nums){
                if(($nums['isBilling']&&$isBilling)||($nums['isContact']&&$isContact)){
                    $data=[];
                    $invoices=$api->get('invoices',['clientId'=>$perclient['id']]);
                    $service=$api->get('clients/services',['clientId'=>$perclient['id']]);
                    $data['serviceAccountNumber']='N/A';
                    if(count($service)>0)
                    foreach($service[0]['attributes'] as $att){
                        if( $att['key']==='serviceAccountNumber'){
                            $data['serviceAccountNumber']=$att['value'];
                        }
                    }
                    $data['num']=$nums['phone'];
                    $data['name']=$perclient['clientType']==2?$perclient['companyName']:$perclient['firstName'].' '.$perclient['lastName'];
                    if(count($invoices)>0){
                        foreach($invoices as $invoice){
                            $data['total']=$invoice['total'];
                            $data['duedate']=strtotime($invoice['dueDate']);
                            $data['duedate']=date('F j, Y',$data['duedate']);
                            array_push($targets,$data);
                        }
                    }
                    else{
                        array_push($targets,$data);
                    }
                }
            }
        }
    }
    $segments=strlen($content);
    if($segments<640&&$segments>=460) $segments=4;
    else if($segments<=459&&$segments>=307) $segments=3;
    else if($segments<=306&&$segments>=161) $segments=2;
    else if($segments<=160&&$segments>0) $segments=1;
    else $segments=0;
    if($segments!=0){
        if($bal>=(count($targets)*$segments)){
            $alertcontents=[];
            foreach($targets as $target){
                $message=templatize($content,$target,$vars);
                $response = $client->request('POST', 'https://www.itexmo.com/php_api/api.php',
                                [
                                    'body' => [
                                        '1' => $target['num'],
                                        '2' => $message,
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
                        case 4:
                            $c='Message sending failed to '.$target['name'].'!<br> No credit left';
                            break;
                        case 5:
                            $c='Message sending failed to '.$target['name'].'!<br> You have reached the maximum characters per SMS ';
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
        }
        else
            array_push($alerts,['type' => 'error','contents' => ['Message sending failed!<br> Not enough credits']]);
    }
    else
        array_push($alerts,['type' => 'error','contents' => ['Message sending failed!<br> You have reached the maximum characters per SMS']]);
    $_SESSION['alerts']=$alerts;
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
    // $lead="";
    $data['Id'] = $client['id'];
    $data['Name'] = $client['clientType']==2?$client['companyName']:$client['firstName'].' '.$client['lastName'];
    // $data['Name'] .= $client['isLead']?$lead:'';
    $data['Created'] = date("F j, Y, g:i a",strtotime($client['registrationDate']));
    $data['Qouted Services']=[];
    foreach($services as $s){
        if($s['clientId']===$client['id']){
            array_push($data['Qouted Services'],$s['name']);
        }
    }
    $data['Note']='';
    array_push($cls,$data);
}
$cols=['Id','Name','Created','Qouted Services','Note'];
$styles=[
    'Qouted Services'=>'status-yellow|tdcenter',
    'Created' => 'tdcenter',
];



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
        'variables' => $vars,
        'ucrmPublicUrl' => $optionsManager->loadOptions()->ucrmPublicUrl,
        'result' => $result ?? [],
    ]
);