<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/27
 * Time: 3:03
 */

function getTitle(){
    return "404 NotFound";
}

http_response_code(404)
?>
<section id="error-page">
    <h1>404&nbsp;NotFound</h1>
    <p>お探しのページを見つけることができませんでした</p>
    <a class="common-button" href="/">トップページへ</a>
</section>