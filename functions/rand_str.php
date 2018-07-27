<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 2:16
 */

/**
 * ランダム文字列生成 (英数字)
 * https://qiita.com/TetsuTaka/items/bb020642e75458217b8a#comment-905020877ffcfacfdb66
 *
 * $length: 生成する文字数
 */
function makeRandStr($length = 8) {
    static $chars;
    if (!$chars) {
        $chars = array_flip(array_merge(
            range('a', 'z'), range('A', 'Z'), range('0', '9')
        ));
    }
    $str = '';
    for ($i = 0; $i < $length; ++$i) {
        $str .= array_rand($chars);
    }
    return $str;
}
