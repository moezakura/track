<?php
/**
 * Created by PhpStorm.
 * User: mox
 * Date: 2018/07/20
 * Time: 0:58
 */

// SQLiteへ接続
$pdo = new PDO("sqlite:data/main.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

// テーブルが存在しなければ作成
$pdo->exec("CREATE TABLE IF NOT EXISTS user(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(200),
        password VARCHAR(512),
        password_salt VARCHAR(16)
    )");

$pdo->exec("CREATE TABLE IF NOT EXISTS tracking(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        corporation INTEGER,
        status VARCHAR(128),
        name VARCHAR(200),
        contact_id VARCHAR(256),
        user_id INTEGER,
        foreign key (user_id) references user(id)
    )");