<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 8:18
 */

require_once dirname(__FILE__) . "/../functions/is_login_and_bad_request.php";

$id = isset($_GET["id"]) ? $_GET["id"] : "";
$isUpdate = isset($_GET["update"]) ? $_GET["update"] == "true" : false;

require_once dirname(__FILE__) . "/yamato_api.php";
require_once dirname(__FILE__) . "/japan_post_api.php";
require_once dirname(__FILE__) . "/sagawa_api.php";

$stmt = $pdo->prepare("SELECT id, corporation, status, name, contact_id FROM tracking WHERE user_id = ? AND id = ?;");
$stmt->execute([$_SESSION["user_id"], $id]);
$res = $stmt->fetchAll();

if (count($res) <= 0) {
    $result = new GetTrackingResult();
    $result->error = "データがありません";
    $result->isSuccess = false;
    echo json_encode($result);
    return;
}
$res = $res[0];

$result = new GetTrackingResult(
    $res["id"],
    $res["corporation"],
    $res["status"],
    $res["name"],
    $res["contact_id"]
);

if($isUpdate){
    $api = null;
    $number = $res["contact_id"];
    $corp = $res["corporation"];

    switch($corp){
        case 1:
            $api = new YamatoAPI();
            break;
        case 2:
            $api = new JapanPostAPI();
            break;
        case 3:
            $api = new SagawaAPI();
            break;
    }
    $apiResult = $api->run($number);
    $status = trim($apiResult->status);

    $stmt = $pdo->prepare("UPDATE tracking SET status = ? WHERE user_id = ? AND id = ?;");
    $stmt->execute([$status, $_SESSION["user_id"], $id]);
    $result->status = $status;
}

$result->isSuccess = true;
echo json_encode($result);


class GetTrackingResult
{
    public $error = "";
    public $isSuccess = false;

    public $id;
    public $corp;
    public $status;
    public $name;
    public $number;
    private $corpList = array(
        0 => "",
        1 => "ヤマト運輸",
        2 => "日本郵便",
        3 => "佐川急便",
    );

    public function __construct($id = 0, $corp = 0, $status = "", $name = "", $number = "")
    {
        $this->id = (int)$id;
        $this->corp = $this->corpList[(int)$corp];
        $this->status = $status;
        $this->name = $name;
        $this->number = $number;
    }
}