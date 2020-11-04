<?php
/*
 * ファイルパス：/Applications/MAMP/htdocs/DT/shopping/list.php
 * ファイル名：list.php (商品一覧を表示するプログラム、Controller)
 * アクセスURL：http://localhost/DT/shopping/list.php
 */
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Item;
use shopping\lib\Login;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$itm = new Item($db);
$login = new Login($db);

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);


//POSTで受け取る
$data = $_POST;
$userdata = [];
$error_msg = "";

// 入力チェック
if($_POST['email']!=="" && $_POST['password']!==""){
    //パスワードを暗号化する
    $data['password'] = md5($data['password']);

    // IDとパスワードに合致するユーザー情報を取得
    $login_data = $login->get_userdata($data);

    //ユーザー情報が存在する場合と存在しない場合
    if(count($login_data)!==0) {
        //セッション変数に取得したユーザー情報を入れる
        $_SESSION = $login_data[0];
        //ログイン状態をTRUEにする。
        $_SESSION['login'] = true;
    } else {
        //ログイン状態をFALSEにする。
        $_SESSION['login'] = false;
        $error_msg = "ログインに失敗しました。";
    }
} else {
    $error_msg = "email,passwordは必須です。";
}

$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1) ? $_GET['ctg_id'] : '';

// カテゴリーリスト(一覧)を取得する
$cateArr = $itm->getCategoryList();
// 商品リストを取得する
$dataArr = $itm->getItemList($ctg_id);
$context = [];
$context['error_msg'] = $error_msg;
$context['userdata'] = $_SESSION;
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);
