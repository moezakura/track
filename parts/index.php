<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 0:01
 */

?>

<section id="top-title">
    <h1 id="top-title-text">Multi Post Tracker</h1>
    <div id="top-title-detail">
        <p>Multi Post Trackerを利用して複数の荷物を同時にトラッキングしましょう。</p>
        <p>Multi Post TrackerはWeb技術の課題で作られたアプリケーションです。</p>
        <?php if (!$isLogin) { ?>
            <a id="top-title-start" href="/login" class="common-button">始める</a>
        <?php } else { ?>
            <a id="top-title-start" href="/myPage" class="common-button">マイページ</a>
        <?php } ?>
</section>
