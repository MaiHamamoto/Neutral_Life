<?php
/*
 * ファイルパス：/Applications/MAMP/htdocs/DT/shopping/list.php
 * ファイル名：list.php (商品一覧を表示するプログラム、Controller)
 * アクセスURL：http://localhost/DT/shopping/list.php
 */
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

// セッションの初期化
// session_name("something")を使用している場合は特にこれを忘れないように!
session_start();

// セッション変数を全て解除する
$_SESSION = array();

// セッションを切断するにはセッションクッキーも削除する。
// Note: セッション情報だけでなくセッションを破壊する。
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 最終的に、セッションを破壊する
session_destroy();


// 商品一覧へ遷移させる
header('Location: ' . Bootstrap::ENTRY_URL. 'list.php');
