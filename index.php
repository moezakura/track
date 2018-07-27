<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 0:45
 */

require_once "functions/strings.php";

//セッションの開始
ini_set('session.gc_maxlifetime', 2592000);
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 1);
session_set_cookie_params(0, '/', '', false, true);
session_name("mox-session");
session_start(
    [
        'cookie_lifetime' => 2592000,
    ]
);

// 各変数の定義
$title = "";
$isPost = $_SERVER["REQUEST_METHOD"] == "POST";
$isLogin = false;

// ログインしてるかどうか
if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0)
    $isLogin = true;

// SQLite接続を読み込み
require_once "functions/sql_connection.php";

// APIを振り分け
$pageName = empty($_GET["page"]) ? "" : $_GET["page"];
$pageNameRaw = $pageName;
$pageName = preg_replace("/([A-Z])/", '_$1', $pageName);
$pageName = preg_replace("/\.\./", '', $pageName);
$pageName = strtolower($pageName);
$isAPI = false;

if (startsWith($pageName,"api/")) {
    $isAPI = true;
    header("content-type: application/json");
    $pageName = preg_replace("/api\//", '', $pageName);
    $filePath = "api/" . (empty($pageName) ? "index" : $pageName) . ".php";
} else if (startsWith($pageName,"assets/")) {
    echo file_get_contents($pageNameRaw);
    return;
} else
    $filePath = "parts/" . (empty($pageName) ? "index" : $pageName) . ".php";

// 標準出力にHTMLを吐き出させ読み取り
ob_start();

if (file_exists($filePath)) require_once $filePath;
else {
    if(!$isAPI) require_once "system_parts/404.php";
    else {
        http_response_code(404);
        echo json_encode(array(
                "error" => "404 notfound"
        ));
        return;
    }
}

$partHtml = ob_get_contents();
ob_end_clean();

if($isAPI){
    echo $partHtml;
    return;
}

// getTitle関数が定義されていればタイトルとして取得
if (function_exists("getTitle")) $title = getTitle();
?>
<html>
<head>
    <title>Multi Post Tracker<?php echo empty($title) ? "" : ("| " . $title); ?></title>
    <style>
        <?php echo file_get_contents("assets/scss/main.css"); ?>
    </style>
</head>
<body><?php echo $partHtml; ?></body>
</html>