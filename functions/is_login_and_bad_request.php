<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 7:16
 */

if (!isset($isLogin) || !$isLogin) {
    http_response_code(403);
    echo json_encode(array(
        "error" => "forbidden"
    ));
    exit();
}

