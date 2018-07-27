<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 2:37
 */

/**
 * @param $pdo PDO
 * @return LoginResult
 */
function login($pdo){
    $stmt = $pdo->prepare("SELECT * FROM user WHERE name = ?");
    $stmt->execute([$_POST["id"]]);
    $res = $stmt->fetchAll();

    if(count($res) <= 0)
        return new LoginResult();

    $res = $res[0];
    $salt = $res["password_salt"];
    $password_hash = hash("sha512", $salt . $_POST["password"]);

    if($password_hash !== $res["password"])
        return new LoginResult();

    $result = new LoginResult("");
    $result->isError = false;
    $result->useId = $res["id"];
    return $result;
}

class LoginResult{
    public $error = "";
    public $isError = true;
    public $useId = 0;

    function __construct(string $errorMessage = "IDとパスワードの組み合わせが間違っています")
    {
        $this->error = $errorMessage;
    }
}