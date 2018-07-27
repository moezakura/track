<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 1:52
 */

require_once "rand_str.php";

/***
 * アカウント登録処理をします。RegisterResultでエラー・成功を返します。
 * @param $pdo PDO
 * @return RegisterResult
 */
function register($pdo)
{
    if (empty($_POST["id"]))
        return new RegisterResult("IDを入力してください");
    else if (empty($_POST["password"]) || empty($_POST["password-re"]))
        return new RegisterResult("パスワードを入力してください");
    else if (strlen($_POST["password"]) < 8)
        return new RegisterResult("パスワードは8文字以上で入力してください");
    else if ($_POST["password"] != $_POST["password-re"])
        return new RegisterResult("パスワードが確認と一致しません");

    $stmt = $pdo->prepare("SELECT count(*) r FROM user WHERE name = ?");
    $stmt->execute([$_POST["id"]]);
    $res = $stmt->fetchAll()[0];
    if ($res["r"] > 0)
        return new RegisterResult("すでに使用されているIDです");

    $salt = makeRandStr(16);
    $passwordHash = hash("sha512", $salt . $_POST["password"]);

    $stmt = $pdo->prepare("INSERT INTO user(name, password, password_salt) VALUES (?, ?, ?)");
    $stmt->execute([$_POST["id"], $passwordHash, $salt]);

    $result = new RegisterResult("");
    $result->isError = false;
    return $result;
}

class RegisterResult
{
    public $error = "";
    public $isError = true;

    function __construct(string $errorMessage)
    {
        $this->error = $errorMessage;
    }
}