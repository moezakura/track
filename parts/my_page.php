<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 3:02
 */

$requireLogin = true;
require_once dirname(__FILE__) . "/../functions/is_login_and_redirect.php";
require_once dirname(__FILE__) . "/../other_parts/common_header.php";
?>

<section id="mypage">
    <h2 class="title">トラッキングする荷物を追加</h2>
    <form class="contact-id" id="contact-id-search">
        <input type="search" placeholder="お問い合わせ番号" id="contact-id-input">
        <input type="submit" value="+">
    </form>
    <div class="both"></div>
    <div id="contact-error" class="error"></div>
    <div class="contact-id" id="contact-id-add" style="display: none;">
        <input type="text" placeholder="荷物の名前" id="tracking-name">
        <div class="contact-id-buttons">
        <div class="common-button" id="yamato-submit">ヤマト運輸として追加</div>
        <div class="common-button" id="japan-post-submit">日本郵便として追加</div>
        <div class="common-button" id="sagawa-submit">佐川急便として追加</div>
        </div>
    </div>

    <div id="tracking-list-parent">
        <h2 class="title">現在トラッキングしてる荷物</h2>
        <div id="tracking-list">
            <div class="row">
                <div class="platform">会社</div>
                <div class="status">ステータス</div>
                <div class="name">名前</div>
                <div class="number">お問い合わせ番号</div>
                <div class="delete">操作</div>
            </div>
            <?php // ここにJsでデータ挿入 ?>
        </div>
    </div>
</section>
<div id="loading">
    <div></div>
</div>
<script src="/assets/js/libs/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="/assets/js/mypage.js" type="text/javascript"></script>
<script src="/assets/js/mypageCreateList.js" type="text/javascript"></script>
