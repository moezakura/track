<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 7:14
 */

require_once dirname(__FILE__) . "/../functions/is_login_and_bad_request.php";

$corporation = isset($_GET["corp"]) ? $_GET["corp"] : "";
$number = isset($_GET["number"]) ? $_GET["number"] : "";
$name = isset($_GET["name"]) ? $_GET["name"] : "";

if (empty($corporation) || empty($number) || empty($name)) {
    $result = new AddTrackResult(false, "正しく入力されていません");
    echo json_encode($result);
    return;
}

$stmt = $pdo->prepare("SELECT count(*) r FROM tracking WHERE user_id = ? AND contact_id = ?");
$stmt->execute([$_SESSION["user_id"], $number]);
$res = $stmt->fetchAll()[0];
if ($res["r"] > 0) {
    $result = new AddTrackResult(false, "既に登録されている追跡番号です");
    echo json_encode($result);
    return;
}


$stmt = $pdo->prepare("INSERT INTO tracking(corporation, status, name, contact_id, user_id) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$corporation, "", $name, $number, $_SESSION["user_id"]]);

$result = new AddTrackResult(true);
$result->id = (int)$pdo->lastInsertId('id');
echo json_encode($result);

class AddTrackResult
{
    public $error = "";
    public $isSuccess = false;
    public $id = -1;

    public function __construct(bool $isSuccess, string $error = "")
    {
        $this->isSuccess = $isSuccess;
        $this->error = $error;
    }
}