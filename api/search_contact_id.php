<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 5:45
 */

/*
 * 1: yamato
 * 2: japan_post
 * 3: sagawa
 */

require_once dirname(__FILE__) . "/../functions/is_login_and_bad_request.php";

$corporation = isset($_GET["corp"]) ? $_GET["corp"] : "";
$number = isset($_GET["number"]) ? $_GET["number"] : "";

require_once dirname(__FILE__) . "/yamato_api.php";
require_once dirname(__FILE__) . "/japan_post_api.php";
require_once dirname(__FILE__) . "/sagawa_api.php";

$api = [];
switch ($corporation) {
    case 1:
        $api = [new YamatoAPI()];
        break;
    case 2:
        $api = [new JapanPostAPI()];
        break;
    case 3:
        $api = [new SagawaAPI()];
        break;
    case 99:
        $api = [
            new YamatoAPI(),
            new JapanPostAPI(),
            new SagawaAPI()
        ];
        break;
}

if (count($api) <= 0) {
    http_response_code(404);
    echo json_encode(array(
        "error" => "404 notfound"
    ));
    return;
}

$result = new SearchContactIdResult();
foreach ($api as $i){
    $name = $i->name;
    $jsonObject = $i->run($number);
    $result->$name = isset($jsonObject) && isset($jsonObject->code) && $jsonObject->code === 200;
}


echo json_encode($result);
return;

class SearchContactIdResult
{
    public $yamato = false;
    public $japanPost = false;
    public $sagawa = false;

    public function __construct()
    {
    }
}