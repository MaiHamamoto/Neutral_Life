<?php

/*
 * ファイルパス : /Applications/MAMP/htdocs/DT/shopping/lib/Item.class.php
 * ファイル名 : Item.class.php (商品に関するプログラムのクラスファイル、Model)
 */
namespace shopping\lib;

class Item
{
    public $cateArr = [];
    public $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }
    // カテゴリーリストの取得
    public function getCategoryList()
    {
        $table = ' category ';
        $col = ' ctg_id, category_name ';
        $res = $this->db->select($table, $col);
        return $res;  
    }

    // 商品リストを取得する
    public function getItemList($ctg_id)
    {
        // カテゴリーによって表示させるアイテムをかえる
        $table = ' item ';
        $col = ' item_id, item_name, price, image, ctg_id ';
        $where = ($ctg_id !== '') ? ' ctg_id = ? ' : '';
        $arrVal = ($ctg_id !== '') ? [$ctg_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    // 商品の詳細情報を取得する
    public function getItemDetailData($item_id)
    {
        $table = ' item ';
        $col = ' item_id, item_name, detail, price, image, ctg_id ';

        $where = ($item_id !== '') ? ' item_id = ? ' : '';
        // カテゴリーによって表示させるアイテムをかえる
        $arrVal = ($item_id !== '') ? [$item_id] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }

    // 検索ワードで商品を絞り込む
    public function getSearchItem($keyword)
    {
        $keyword = "%".$keyword."%";
        // カテゴリーによって表示させるアイテムをかえる
        $table = ' item ';
        $col = ' item_id, item_name, price, image, ctg_id ';
        $where = ($keyword !== '') ? ' item_name LIKE ? OR detail LIKE ? OR price LIKE ? OR image LIKE ? ' : '';
        $arrVal = ($keyword !== '') ? [$keyword,$keyword,$keyword,$keyword] : [];

        $res = $this->db->select($table, $col, $where, $arrVal);

        return ($res !== false && count($res) !== 0) ? $res : false;
    }    
}