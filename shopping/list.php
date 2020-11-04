<?php
/*
 * ファイルパス : /Applications/MAMP/htdocs/DT/shopping/list.php
 * ファイル名 : list.php
 * アクセスURL : http://localhost/DT/shopping/list.php
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

// SessionKeyを見て、DBへの登録状態をチェックする
$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/', $_GET['ctg_id']) === 1) ? $_GET['ctg_id'] : '';

// カテゴリーリスト(一覧)を取得する
$cateArr = $itm->getCategoryList();
// 商品リストを取得する
$dataArr = $itm->getItemList($ctg_id);
$context = [];
$context['userdata'] = $_SESSION;
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('list.html.twig');
$template->display($context);
