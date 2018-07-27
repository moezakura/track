<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 7:36
 */

require_once dirname(__FILE__) . "/../functions/is_login_and_bad_request.php";

$stmt = $pdo->prepare("SELECT id, corporation, status, name, contact_id FROM tracking WHERE user_id = ?;");
$stmt->execute([$_SESSION["user_id"]]);
$res = $stmt->fetchAll();

$result = [];
foreach ($res as $item) {
    $result[] = new TrackingItem(
        $item["id"],
        $item["corporation"],
        $item["status"],
        $item["name"],
        $item["contact_id"]
    );
}

echo json_encode($result);

class TrackingItem
{
    public $id;
    public $corp;
    public $status;
    public $name;
    public $number;
    private $corpList = array(
        1 => "ヤマト運輸",
        2 => "日本郵便",
        3 => "佐川急便",
    );

    public function __construct($id, $corp, $status, $name, $number)
    {
        $this->id = (int)$id;
        $this->corp = $this->corpList[(int)$corp];
        $this->status = $status;
        $this->name = $name;
        $this->number = $number;
    }
}