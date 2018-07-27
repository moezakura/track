<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 1:44
 */

require_once dirname(__FILE__) . "/../functions/is_login_and_redirect.php";


function getTitle()
{
    return "新規アカウント作成";
}

$errorMessage = "";
if ($isPost) {
    require_once dirname(__FILE__) . "/../functions/page_user_create.php";
    $res = register($pdo);
    if ($res->isError) $errorMessage = $res->error;
    else{
        require_once dirname(__FILE__)."/../other_parts/register_success.php";
        return;
    }
}

?>

<form method="post" id="login" class="basic-form">
    <h1>新規アカウント作成</h1>
    <?php if (!empty($errorMessage)) { ?>
        <div class="error"><?php echo $errorMessage ?></div>
    <?php } ?>
    <label>
        <input type="text" name="id" placeholder="Your ID"
               value="<?php echo (empty($_POST["id"]) ? "" : htmlspecialchars($_POST["id"])); ?>">
    </label>
    <label>
        <input type="password" name="password" placeholder="Your Password">
    </label>
    <label>
        <input type="password" name="password-re" placeholder="Your Password (確認)">
    </label>
    <label>
        <input type="submit" value="新規作成">
    </label>
    <div id="login-link">
        <a href="/login">既にアカウントをお持ちの場合</a>
    </div>
</form>
