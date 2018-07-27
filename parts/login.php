<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 1:30
 */

require_once dirname(__FILE__) . "/../functions/is_login_and_redirect.php";

function getTitle()
{
    return "ログイン";
}

$redirectPage = "";
$errorMessage = "";

if (!empty($_GET["redirect"]))
    $redirectPage = $_GET["redirect"];
else if (!empty($_POST["redirect"]))
    $redirectPage = $_POST["redirect"];
$redirectPage = rawurlencode($redirectPage);

if ($isPost) {
    require_once dirname(__FILE__) . "/../functions/page_user_login.php";
    $res = login($pdo);
    if ($res->isError) $errorMessage = $res->error;
    else {
        $_SESSION["user_id"] = $res->useId;
        if (empty($redirectPage))
            header('Location: /myPage', true, 303);
        else
            header('Location: /' . $redirectPage, true, 303);
        return;
    }
}
?>

<form method="post" id="login" class="basic-form">
    <h1>ログイン</h1>
    <?php if (!empty($errorMessage)) { ?>
        <div class="error"><?php echo $errorMessage ?></div>
    <?php } ?>
    <label>
        <input type="text" name="id" placeholder="Your ID"
               value="<?php echo(empty($_POST["id"]) ? "" : htmlspecialchars($_POST["id"])); ?>">
    </label>
    <label>
        <input type="password" name="password" placeholder="Your Password">
    </label>
    <?php if (!empty($redirectPage)) { ?>
        <input type="hidden" name="redirect" value="<?php echo $redirectPage; ?>">
    <?php } ?>
    <label>
        <input type="submit" value="ログイン">
    </label>
    <div id="login-link">
        <a href="/register">アカウントをお持ちでない場合</a>
    </div>
</form>
