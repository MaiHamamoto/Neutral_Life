<?php
/*
* ファイルパス：/Applications/MAMP/htdocs/DT/shopping/search.php
*ファイル名：search.php
*/
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Item;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER,
Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$itm = new Item($db);

// POSTを受け取る
$keyword = $_POST['keyword'];

// テンプレート指定
$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

//キーワードを元に商品名をitemテーブルから取ってくる
$dataArr = $itm->getSearchItem($keyword);

// カテゴリーリスト(一覧)を取得する
$cateArr = $itm->getCategoryList();

// データをビューで表示させる。
$context = [];
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);

