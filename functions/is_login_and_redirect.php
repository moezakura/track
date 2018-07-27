<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 2:45
 */

if(!isset($requireLogin)) $requireLogin = false;

if ($isLogin && !$requireLogin)
    header('Location: /myPage', true, 303);
else if (!$isLogin && $requireLogin)
    header('Location: /login?redirect='.$_GET["page"], true, 303);
