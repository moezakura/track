<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 4:21
 */

session_destroy();
header('Location: /', true, 303);