<?php
/*
 * ファイルパス : /Applications/MAMP/htdocs/DT/shopping/cart.php
 * ファイル名 : cart.php (カートページの処理を制御するコントローラー)
 * アクセスURL : http://localhost/DT/shopping/cart.php
 */
namespace shopping;

require_once dirname(__FILE__) . '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Login;
use shopping\lib\Cart;

$db = new PDODatabase(Bootstrap::DB_HOST, Bootstrap::DB_USER, Bootstrap::DB_PASS, Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$cart = new Cart($db);
$login = new Login($db);

$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
      'cache' => Bootstrap::CACHE_DIR
]);
// memberIDを設定する
if(!isset($_SESSION['mem_id'])){
    //count.txtを開き、仮mem_idの連番を払い出す
    if(is_file('count.txt') === false) file_put_contents('count.txt', 0);

    $num = intval(file_get_contents('count.txt'));
    $num ++;
    file_put_contents('count.txt', $num);

    $_SESSION['mem_id'] = $num;

}

$mem_id = $_SESSION['mem_id'];

// item_idを取得する
$item_id = (isset($_GET['item_id']) === true && preg_match('/^\d+$/', $_GET['item_id']) === 1) ? $_GET['item_id'] : '';
$crt_id = (isset($_GET['crt_id']) === true && preg_match('/^\d+$/', $_GET['crt_id']) === 1) ? $_GET['crt_id'] : '';

// item_idが設定されていれば、ショッピングカートに登録する
if ($item_id !== '') {
    $res = $cart->insCartData($mem_id, $item_id);
    // 登録に失敗した場合、エラーページを表示する
    if ($res === false) {
        echo "商品購入に失敗しました。";
        exit();
    }
}

// 商品(item_id)の数量変更(最大５個まで)
//for ($item_id = 0; $item_id > 5; $item_id++) {
//$item_id = $sumNum;
//}

// crt_idが設定されていれば、削除する
if ($crt_id !== '') {
    $res = $cart->delCartData($crt_id);
}
// カート情報を取得する
$dataArr = $cart->getCartData($mem_id);
// アイテム数と合計金額を取得する。listは配列をそれぞれの変数にわける
// $cartSumAndNumData = $cart->getItemAndSumPrice($mem_id);
list($sumNum, $sumPrice) = $cart->getItemAndSumPrice($mem_id);

$context = [];
$context['userdata'] = $_SESSION;
$context['sumNum'] = $sumNum;
$context['sumPrice'] = $sumPrice;
$context['dataArr'] = $dataArr;
$template = $twig->loadTemplate('cart.html.twig');
$template->display($context);